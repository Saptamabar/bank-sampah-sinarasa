<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class UserList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = ''; // 'active' or 'inactive'
    
    // Automatically reset pagination when search terms or filters change
    public function updatedSearch() { $this->resetPage(); }
    public function updatedStatusFilter() { $this->resetPage(); }

    public function toggleActive($userId)
    {
        $user = User::findOrFail($userId);
        
        // Prevent admin from deactivating themselves
        if ($user->id === auth()->id()) {
            $this->dispatch('flash', type: 'error', message: 'Anda tidak dapat menonaktifkan akun sendiri!');
            return;
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $this->dispatch('flash', type: 'success', message: "Akun {$user->name} berhasil {$status}.");
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        
        if ($user->id === auth()->id()) {
            $this->dispatch('flash', type: 'error', message: 'Anda tidak dapat menghapus akun sendiri!');
            return;
        }

        $user->delete();
        $this->dispatch('flash', type: 'success', message: "Pengguna {$user->name} berhasil dihapus.");
    }

    public function render()
    {
        $query = User::where('role', 'user')->latest();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('nik', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        return view('livewire.admin.user-list', [
            'users' => $query->paginate(10)
        ]);
    }
}
