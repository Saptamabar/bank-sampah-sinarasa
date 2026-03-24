<?php

namespace App\Livewire\Public;

use App\Models\News;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.public')]
class NewsDetail extends Component
{
    public News $news;
    public $relatedNews;

    public function mount($slug)
    {
        $this->news = News::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment view count 
        // We don't have a views column, but we could add one. Skip for now to keep DB clean.

        $this->relatedNews = News::where('is_published', true)
            ->where('id', '!=', $this->news->id)
            ->latest('published_at')
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.public.news-detail');
    }
}
