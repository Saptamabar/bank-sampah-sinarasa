<?php

namespace App\Livewire\Public;

use App\Models\News;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.public')]
class NewsList extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = News::where('is_published', true)->with('author');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.public.news-list', [
            'news' => $query->latest('published_at')->paginate(9)
        ]);
    }
}
