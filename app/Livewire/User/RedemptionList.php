<?php

namespace App\Livewire\User;

use App\Models\Redemption;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class RedemptionList extends Component
{
    use WithPagination;

    public $statusFilter = '';

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Redemption::with('reward')
            ->where('user_id', Auth::id())
            ->latest('created_at');

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('livewire.user.redemption-list', [
            'redemptions' => $query->paginate(10)
        ]);
    }
}
