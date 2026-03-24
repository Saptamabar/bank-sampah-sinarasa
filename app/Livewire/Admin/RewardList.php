<?php

namespace App\Livewire\Admin;

use App\Models\Reward;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class RewardList extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';

    public $rewardId = null;
    
    #[Validate('required|string|max:255')]
    public $name = '';
    
    #[Validate('nullable|string')]
    public $description = '';
    
    #[Validate('required|numeric|min:0')]
    public $points_required = 0;
    
    #[Validate('required|numeric|min:0')]
    public $stock = 0;
    
    #[Validate('nullable|image|max:2048')]
    public $photo;
    
    public $existingPhoto = '';
    public $isModalOpen = false;

    public function updatedSearch() { $this->resetPage(); }

    public function create()
    {
        $this->reset(['rewardId', 'name', 'description', 'points_required', 'stock', 'photo', 'existingPhoto']);
        $this->resetValidation();
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $reward = Reward::findOrFail($id);
        $this->rewardId = $reward->id;
        $this->name = $reward->name;
        $this->description = $reward->description;
        $this->points_required = $reward->points_required;
        $this->stock = $reward->stock;
        $this->existingPhoto = $reward->photo;
        $this->photo = null;
        
        $this->resetValidation();
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate();

        $photoPath = $this->existingPhoto;
        if ($this->photo) {
            $photoPath = $this->photo->store('rewards', 'public');
        }

        Reward::updateOrCreate(
            ['id' => $this->rewardId],
            [
                'name' => $this->name,
                'description' => $this->description,
                'points_required' => $this->points_required,
                'stock' => $this->stock,
                'photo' => $photoPath,
            ]
        );

        $this->isModalOpen = false;
        $this->dispatch('flash', type: 'success', message: $this->rewardId ? 'Hadiah berhasil diperbarui.' : 'Hadiah berhasil ditambahkan.');
    }

    public function toggleActive($id)
    {
        $reward = Reward::findOrFail($id);
        $reward->is_active = !$reward->is_active;
        $reward->save();

        $status = $reward->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $this->dispatch('flash', type: 'success', message: "Hadiah {$reward->name} berhasil {$status}.");
    }

    public function delete($id)
    {
        $reward = Reward::findOrFail($id);
        if ($reward->redemptions()->count() > 0) {
            $this->dispatch('flash', type: 'error', message: 'Tidak dapat menghapus hadiah yang memiliki riwayat penukaran!');
            return;
        }
        
        $reward->delete();
        $this->dispatch('flash', type: 'success', message: 'Hadiah berhasil dihapus.');
    }

    public function render()
    {
        $query = Reward::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        return view('livewire.admin.reward-list', [
            'rewards' => $query->latest()->paginate(10)
        ]);
    }
}
