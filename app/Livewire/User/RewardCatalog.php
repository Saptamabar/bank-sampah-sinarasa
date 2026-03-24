<?php

namespace App\Livewire\User;

use App\Models\Reward;
use App\Models\Redemption;
use App\Models\PointTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class RewardCatalog extends Component
{
    public $search = '';
    
    // For Modal
    public $selectedRewardId = null;
    public $notes = '';
    public $isConfirmModalOpen = false;

    public function confirmRedeem($rewardId)
    {
        $this->selectedRewardId = $rewardId;
        $this->notes = '';
        $this->isConfirmModalOpen = true;
    }

    public function processRedemption()
    {
        $user = Auth::user();
        $reward = Reward::findOrFail($this->selectedRewardId);

        // Security Validation
        if (!$reward->is_active || $reward->stock <= 0) {
            $this->dispatch('flash', type: 'error', message: 'Hadiah ini sedang tidak tersedia atau stok habis.');
            $this->isConfirmModalOpen = false;
            return;
        }

        if ($user->points_total < $reward->points_required) {
            $this->dispatch('flash', type: 'error', message: 'Poin Anda tidak mencukupi untuk menukar hadiah ini.');
            $this->isConfirmModalOpen = false;
            return;
        }

        try {
            DB::transaction(function () use ($user, $reward) {
                // 1. Create Redemption Record
                $redemption = Redemption::create([
                    'user_id' => $user->id,
                    'reward_id' => $reward->id,
                    'points_used' => $reward->points_required,
                    'status' => 'pending',
                    'notes' => $this->notes,
                ]);

                // 2. Deduct Points & Stock
                $user->decrement('points_total', $reward->points_required);
                $reward->decrement('stock', 1);

                // 3. Create Point Transaction Ledger
                PointTransaction::create([
                    'user_id' => $user->id,
                    'type' => 'debit',
                    'amount' => $reward->points_required,
                    'reference_type' => Redemption::class,
                    'reference_id' => $redemption->id,
                    'description' => 'Penukaran hadiah: ' . $reward->name,
                    'balance_after' => $user->points_total,
                ]);
            });

            $this->isConfirmModalOpen = false;
            $this->dispatch('profile-updated', name: $user->name); // Optional: trigger UI updates if listening
            $this->dispatch('flash', type: 'success', message: 'Permintaan penukaran hadiah berhasil dikirim!');
            
        } catch (\Exception $e) {
            $this->dispatch('flash', type: 'error', message: 'Terjadi kesalahan sistem, silakan coba lagi.');
        }
    }

    public function render()
    {
        $query = Reward::where('is_active', true)
                       ->where('stock', '>', 0);
                       
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        return view('livewire.user.reward-catalog', [
            'rewards' => $query->latest()->get()
        ]);
    }
}
