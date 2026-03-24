<?php

namespace App\Livewire\User;

use App\Models\WasteSubmission;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class SubmissionList extends Component
{
    use WithPagination;

    public $statusFilter = '';

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = WasteSubmission::with(['collectionPost', 'items.category'])
            ->where('user_id', Auth::id())
            ->latest('submission_date');

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('livewire.user.submission-list', [
            'submissions' => $query->paginate(10)
        ]);
    }
}
