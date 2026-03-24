<?php

namespace App\Livewire\Admin;

use App\Models\WasteSubmission;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class SubmissionList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'pending'; // Default show pending
    public $dateFilter = '';

    public function updatedSearch() { $this->resetPage(); }
    public function updatedStatusFilter() { $this->resetPage(); }
    public function updatedDateFilter() { $this->resetPage(); }

    public function resetFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->dateFilter = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = WasteSubmission::with(['user', 'collectionPost'])->latest('submission_date');

        if ($this->search) {
            $query->whereHas('user', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('nik', 'like', '%' . $this->search . '%');
            })->orWhereHas('collectionPost', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->dateFilter) {
            $query->whereDate('submission_date', $this->dateFilter);
        }

        return view('livewire.admin.submission-list', [
            'submissions' => $query->paginate(15)
        ]);
    }
}
