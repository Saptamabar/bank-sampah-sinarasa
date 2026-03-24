<?php

namespace App\Livewire\Admin;

use App\Models\WasteSubmission;
use App\Models\WasteSubmissionItem;
use App\Models\PointTransaction;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class SubmissionDetail extends Component
{
    public WasteSubmission $submission;
    
    // Store mutable item quantities: [item_id => quantity]
    public $quantities = [];
    public $adminNotes = '';

    public function mount($submissionId)
    {
        $this->submission = WasteSubmission::with(['user', 'collectionPost', 'items.category'])->findOrFail($submissionId);
        $this->adminNotes = $this->submission->admin_notes;

        // Initialize quantities array with current values
        foreach ($this->submission->items as $item) {
            $this->quantities[$item->id] = $item->quantity;
        }
    }

    public function validateSubmission()
    {
        if ($this->submission->status !== 'pending') {
            $this->dispatch('flash', type: 'error', message: 'Setoran ini sudah diproses sebelumnya!');
            return;
        }

        // Validate that all quantities are numeric and >= 0
        foreach ($this->quantities as $qty) {
            if (!is_numeric($qty) || $qty < 0) {
                $this->dispatch('flash', type: 'error', message: 'Kuantitas tidak valid!');
                return;
            }
        }

        try {
            DB::beginTransaction();

            $totalPointsEarned = 0;

            // 1. Update each item
            foreach ($this->submission->items as $item) {
                $actualQty = $this->quantities[$item->id];
                $subtotal = $actualQty * $item->points_per_unit;
                
                $item->update([
                    'quantity' => $actualQty,
                    'subtotal_points' => $subtotal,
                ]);

                $totalPointsEarned += $subtotal;
            }

            // 2. Update submission
            $this->submission->update([
                'status' => 'validated',
                'admin_notes' => $this->adminNotes,
                'validated_by' => auth()->id(),
                'validated_at' => now(),
                'total_points_earned' => $totalPointsEarned,
            ]);

            // 3. Update User points and create PointTransaction
            $user = $this->submission->user;
            
            if ($totalPointsEarned > 0) {
                $user->points_total += $totalPointsEarned;
                $user->save();

                PointTransaction::create([
                    'user_id' => $user->id,
                    'type' => 'credit',
                    'amount' => $totalPointsEarned,
                    'reference_type' => WasteSubmission::class,
                    'reference_id' => $this->submission->id,
                    'description' => 'Mendapatkan poin dari setoran sampah #' . str_pad($this->submission->id, 5, '0', STR_PAD_LEFT),
                    'balance_after' => $user->points_total,
                ]);
            }

            DB::commit();

            $this->dispatch('flash', type: 'success', message: 'Setoran berhasil divalidasi dan poin telah ditambahkan ke saldo nasabah!');
            return redirect()->route('admin.setoran.index');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('flash', type: 'error', message: 'Gagal memvalidasi setoran: ' . $e->getMessage());
        }
    }

    public function rejectSubmission()
    {
        if ($this->submission->status !== 'pending') {
            $this->dispatch('flash', type: 'error', message: 'Setoran ini sudah diproses sebelumnya!');
            return;
        }

        if (empty($this->adminNotes)) {
            $this->dispatch('flash', type: 'error', message: 'Catatan admin wajib diisi untuk menjelaskan alasan penolakan!');
            return;
        }

        $this->submission->update([
            'status' => 'rejected',
            'admin_notes' => $this->adminNotes,
            'validated_by' => auth()->id(),
            'validated_at' => now(),
            'total_points_earned' => 0,
        ]);

        $this->dispatch('flash', type: 'success', message: 'Setoran telah ditolak.');
        return redirect()->route('admin.setoran.index');
    }

    public function render()
    {
        // Calculate projected totals dynamically for the UI
        $projectedTotal = 0;
        foreach ($this->submission->items as $item) {
            $qty = $this->quantities[$item->id] ?? 0;
            $projectedTotal += (float)$qty * $item->points_per_unit;
        }

        return view('livewire.admin.submission-detail', [
            'projectedTotal' => $projectedTotal
        ]);
    }
}
