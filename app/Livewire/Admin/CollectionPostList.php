<?php

namespace App\Livewire\Admin;

use App\Models\CollectionPost;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class CollectionPostList extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';

    public $postId = null;

    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|string|max:255')]
    public $address = '';

    #[Validate('required|string|max:5')]
    public $rt = '';

    #[Validate('required|string|max:5')]
    public $rw = '';

    #[Validate('required|numeric')]
    public $latitude = -8.2041451;

    #[Validate('required|numeric')]
    public $longitude = 113.8285047;

    #[Validate('required|string|max:255')]
    public $pic_name = '';

    #[Validate('required|string|max:20|regex:/^[0-9]+$/')]
    public $pic_phone = '';

    #[Validate('nullable|string|max:255')]
    public $operational_hours = '';

    #[Validate('nullable|image|max:2048')]
    public $photo;

    public $existingPhoto = '';

    public $isModalOpen = false;

    public function updatedSearch() { $this->resetPage(); }

    public function create()
    {
        $this->reset(['postId', 'name', 'address', 'rt', 'rw', 'pic_name', 'pic_phone', 'operational_hours', 'photo', 'existingPhoto']);
        $this->latitude = -8.2041451;
        $this->longitude = 113.8285047;
        $this->resetValidation();
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $post = CollectionPost::findOrFail($id);
        $this->postId = $post->id;
        $this->name = $post->name;
        $this->address = $post->address;
        $this->rt = $post->rt;
        $this->rw = $post->rw;
        $this->latitude = $post->latitude;
        $this->longitude = $post->longitude;
        $this->pic_name = $post->pic_name;
        $this->pic_phone = $post->pic_phone;
        $this->operational_hours = $post->operational_hours;
        $this->existingPhoto = $post->photo;
        $this->photo = null;

        $this->resetValidation();
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate();

        $photoPath = $this->existingPhoto;
        if ($this->photo) {
            $photoPath = $this->photo->store('collection-posts', 'public');
        }

        CollectionPost::updateOrCreate(
            ['id' => $this->postId],
            [
                'name' => $this->name,
                'address' => $this->address,
                'rt' => $this->rt,
                'rw' => $this->rw,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'pic_name' => $this->pic_name,
                'pic_phone' => $this->pic_phone,
                'operational_hours' => $this->operational_hours,
                'photo' => $photoPath,
            ]
        );

        $this->isModalOpen = false;
        $this->dispatch('flash', type: 'success', message: $this->postId ? 'Pos berhasil diperbarui.' : 'Pos berhasil ditambahkan.');
    }

    public function toggleActive($id)
    {
        $post = CollectionPost::findOrFail($id);
        $post->is_active = !$post->is_active;
        $post->save();

        $status = $post->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $this->dispatch('flash', type: 'success', message: "Pos {$post->name} berhasil {$status}.");
    }

    public function delete($id)
    {
        $post = CollectionPost::findOrFail($id);
        if ($post->wasteSubmissions()->count() > 0) {
            $this->dispatch('flash', type: 'error', message: 'Tidak dapat menghapus pos yang memiliki riwayat setoran!');
            return;
        }

        $post->delete();
        $this->dispatch('flash', type: 'success', message: 'Pos berhasil dihapus.');
    }

    public function render()
    {
        $query = CollectionPost::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('pic_name', 'like', '%' . $this->search . '%')
                  ->orWhere('address', 'like', '%' . $this->search . '%');
        }

        return view('livewire.admin.collection-post-list', [
            'posts' => $query->latest()->paginate(10)
        ]);
    }
}
