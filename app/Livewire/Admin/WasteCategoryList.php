<?php

namespace App\Livewire\Admin;

use App\Models\WasteCategory;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class WasteCategoryList extends Component
{
    use WithPagination;

    public $search = '';

    public $categoryId = null;
    
    #[Validate('required|string|max:255')]
    public $name = '';
    
    #[Validate('required|string|max:50')]
    public $unit = 'kg';
    
    #[Validate('required|numeric|min:0')]
    public $points_per_unit = 0;
    
    #[Validate('nullable|string')]
    public $description = '';
    
    #[Validate('nullable|string|max:50')]
    public $icon = '';
    
    public $isModalOpen = false;

    public function updatedSearch() { $this->resetPage(); }

    public function create()
    {
        $this->reset(['categoryId', 'name', 'unit', 'points_per_unit', 'description', 'icon']);
        $this->resetValidation();
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $category = WasteCategory::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->unit = $category->unit;
        $this->points_per_unit = $category->points_per_unit;
        $this->description = $category->description;
        $this->icon = $category->icon;
        
        $this->resetValidation();
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate();

        WasteCategory::updateOrCreate(
            ['id' => $this->categoryId],
            [
                'name' => $this->name,
                'unit' => $this->unit,
                'points_per_unit' => $this->points_per_unit,
                'description' => $this->description,
                'icon' => $this->icon,
            ]
        );

        $this->isModalOpen = false;
        $this->dispatch('flash', type: 'success', message: $this->categoryId ? 'Kategori berhasil diperbarui.' : 'Kategori berhasil ditambahkan.');
    }

    public function toggleActive($id)
    {
        $category = WasteCategory::findOrFail($id);
        $category->is_active = !$category->is_active;
        $category->save();

        $status = $category->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $this->dispatch('flash', type: 'success', message: "Kategori {$category->name} berhasil {$status}.");
    }

    public function delete($id)
    {
        $category = WasteCategory::findOrFail($id);
        // Check if there are associated submissions before deleting
        if ($category->wasteSubmissionItems()->count() > 0) {
            $this->dispatch('flash', type: 'error', message: 'Tidak dapat menghapus kategori yang memiliki riwayat setoran!');
            return;
        }
        
        $category->delete();
        $this->dispatch('flash', type: 'success', message: 'Kategori berhasil dihapus.');
    }

    public function render()
    {
        $query = WasteCategory::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        return view('livewire.admin.waste-category-list', [
            'categories' => $query->latest()->paginate(10)
        ]);
    }
}
