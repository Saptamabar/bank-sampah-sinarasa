<?php

namespace App\Livewire\User;

use App\Models\PointTransaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PointHistory extends Component
{
    use WithPagination;

    public $typeFilter = '';

    public function updatedTypeFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = PointTransaction::where('user_id', Auth::id())
            ->latest('created_at');

        if ($this->typeFilter) {
            $query->where('type', $this->typeFilter);
        }

        return view('livewire.user.point-history', [
            'transactions' => $query->paginate(15)
        ]);
    }
}
