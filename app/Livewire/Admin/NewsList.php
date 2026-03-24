<?php

namespace App\Livewire\Admin;

use App\Models\News;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class NewsList extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';

    public $newsId = null;
    
    #[Validate('required|string|max:255')]
    public $title = '';
    
    #[Validate('required|string')]
    public $content = '';
    
    #[Validate('required|string|max:50')]
    public $category = 'Edukasi';
    
    #[Validate('nullable|image|max:2048')]
    public $thumbnail;
    
    public $is_published = false;
    
    public $existingThumbnail = '';
    public $isModalOpen = false;

    public function updatedSearch() { $this->resetPage(); }

    public function create()
    {
        $this->reset(['newsId', 'title', 'content', 'category', 'thumbnail', 'existingThumbnail', 'is_published']);
        $this->resetValidation();
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        $this->newsId = $news->id;
        $this->title = $news->title;
        $this->content = $news->content;
        $this->category = $news->category;
        $this->is_published = $news->is_published;
        $this->existingThumbnail = $news->thumbnail;
        $this->thumbnail = null;
        
        $this->resetValidation();
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate();

        $thumbnailPath = $this->existingThumbnail;
        if ($this->thumbnail) {
            $thumbnailPath = $this->thumbnail->store('news', 'public');
        }

        $slug = Str::slug($this->title);
        // Ensure slug is unique if creating
        if (!$this->newsId && News::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . time();
        }

        $newsData = [
            'title' => $this->title,
            'slug' => $slug,
            'content' => $this->content,
            'category' => $this->category,
            'thumbnail' => $thumbnailPath,
            'is_published' => $this->is_published,
            'author_id' => auth()->id(),
        ];

        if ($this->is_published && !$this->newsId) {
            $newsData['published_at'] = now();
        }

        News::updateOrCreate(
            ['id' => $this->newsId],
            $newsData
        );

        $this->isModalOpen = false;
        $this->dispatch('flash', type: 'success', message: $this->newsId ? 'Berita/Artikel berhasil diperbarui.' : 'Berita/Artikel berhasil ditambahkan.');
    }

    public function togglePublish($id)
    {
        $news = News::findOrFail($id);
        $news->is_published = !$news->is_published;
        if ($news->is_published && !$news->published_at) {
            $news->published_at = now();
        }
        $news->save();

        $status = $news->is_published ? 'dipublikasikan' : 'disembunyikan (draft)';
        $this->dispatch('flash', type: 'success', message: "Artikel berhasil $status.");
    }

    public function delete($id)
    {
        News::findOrFail($id)->delete();
        $this->dispatch('flash', type: 'success', message: 'Artikel berhasil dihapus.');
    }

    public function render()
    {
        $query = News::with('author')->latest('created_at');

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('category', 'like', '%' . $this->search . '%');
        }

        return view('livewire.admin.news-list', [
            'newsItems' => $query->paginate(10)
        ]);
    }
}
