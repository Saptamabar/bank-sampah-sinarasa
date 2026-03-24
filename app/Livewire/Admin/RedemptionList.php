<?php

namespace App\Livewire\Admin;

use App\Models\Redemption;
use App\Models\PointTransaction;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class RedemptionList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'pending';
    
    // For rejection modal
    public $isRejectModalOpen = false;
    public $redemptionIdToReject = null;
    public $rejectionNotes = '';

    public function updatedSearch() { $this->resetPage(); }
    public function updatedStatusFilter() { $this->resetPage(); }

    public function approve($id)
    {
        $redemption = Redemption::findOrFail($id);
        
        if ($redemption->status !== 'pending') {
            $this->dispatch('flash', type: 'error', message: 'Penukaran ini sudah diproses.');
            return;
        }

        $redemption->update([
            'status' => 'approved',
            'processed_by' => auth()->id(),
            'processed_at' => now(),
        ]);
        
        $this->dispatch('flash', type: 'success', message: 'Penukaran berhasil disetujui. Silakan siapkan hadiah.');
    }

    public function markDelivered($id)
    {
        $redemption = Redemption::findOrFail($id);
        
        if ($redemption->status !== 'approved') {
            $this->dispatch('flash', type: 'error', message: 'Hanya penukaran yang telah disetujui yang dapat ditandai selesai.');
            return;
        }

        $redemption->update([
            'status' => 'delivered',
            'processed_at' => now(),
        ]);
        
        $this->dispatch('flash', type: 'success', message: 'Status penukaran berhasil diubah menjadi Telah Diberikan.');
    }

    public function openRejectModal($id)
    {
        $this->redemptionIdToReject = $id;
        $this->rejectionNotes = '';
        $this->isRejectModalOpen = true;
    }

    public function reject()
    {
        if (empty($this->rejectionNotes)) {
            $this->addError('rejectionNotes', 'Alasan penolakan wajib diisi.');
            return;
        }

        $redemption = Redemption::findOrFail($this->redemptionIdToReject);

        if ($redemption->status !== 'pending') {
            $this->dispatch('flash', type: 'error', message: 'Hanya penukaran berstatus pending yang dapat ditolak.');
            $this->isRejectModalOpen = false;
            return;
        }

        try {
            DB::beginTransaction();

            // 1. Update status
            $redemption->update([
                'status' => 'rejected',
                'admin_notes' => $this->rejectionNotes,
                'processed_by' => auth()->id(),
                'processed_at' => now(),
            ]);

            // 2. Refund points to user
            $user = $redemption->user;
            $user->points_total += $redemption->points_used;
            $user->save();

            // 3. Create PointTransaction for refund
            PointTransaction::create([
                'user_id' => $user->id,
                'type' => 'credit',
                'amount' => $redemption->points_used,
                'reference_type' => Redemption::class,
                'reference_id' => $redemption->id,
                'description' => 'Pengembalian poin karena penukaran hadiah ditolak oleh admin.',
                'balance_after' => $user->points_total,
            ]);

            // 4. Restore Reward stock
            $reward = $redemption->reward;
            $reward->stock += 1;
            $reward->save();

            DB::commit();

            $this->isRejectModalOpen = false;
            $this->dispatch('flash', type: 'success', message: 'Penukaran ditolak dan poin berhasil dikembalikan ke nasabah.');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('flash', type: 'error', message: 'Gagal menolak penukaran: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $query = Redemption::with(['user', 'reward'])->latest('created_at');

        if ($this->search) {
            $query->whereHas('user', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('nik', 'like', '%' . $this->search . '%');
            })->orWhereHas('reward', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('livewire.admin.redemption-list', [
            'redemptions' => $query->paginate(15)
        ]);
    }
}
