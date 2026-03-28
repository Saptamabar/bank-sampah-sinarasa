<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;

#[Layout('layouts.admin')]
class UserList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = ''; // 'active' or 'inactive'

    // Form Properties
    public $userId = null;
    public $name = '';
    public $nik = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $rt = '';
    public $rw = '';
    public $password = '';
    public $isModalOpen = false;

    // Automatically reset pagination when search terms or filters change
    public function updatedSearch() { $this->resetPage(); }
    public function updatedStatusFilter() { $this->resetPage(); }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'nik' => 'required|digits:16|unique:users,nik,' . $this->userId,
            'email' => 'required|email|max:255|unique:users,email,' . $this->userId,
            'phone' => 'nullable|digits_between:10,20',
            'address' => 'nullable|string|max:500',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            // Password wajib diisi saat tambah (userId null), opsional saat edit
            'password' => $this->userId ? 'nullable|min:8' : 'required|min:8',
        ];
    }

    public function create()
    {
        $this->reset(['userId', 'name', 'nik', 'email', 'phone', 'address', 'rt', 'rw', 'password']);
        $this->resetValidation();
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->nik = $user->nik;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->rt = $user->rt;
        $this->rw = $user->rw;
        $this->password = ''; // Kosongkan password saat edit agar tidak tertimpa kecuali diisi

        $this->resetValidation();
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'nik' => $this->nik,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'rt' => $this->rt,
            'rw' => $this->rw,
            'role' => 'user',
        ];

        // Jika password diisi, update passwordnya. Jika ini create baru, default is_active = true
        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if (!$this->userId) {
            $data['is_active'] = true; // Otomatis aktif jika dibuat oleh admin
        }

        User::updateOrCreate(
            ['id' => $this->userId],
            $data
        );

        $this->isModalOpen = false;
        $this->dispatch('flash', type: 'success', message: $this->userId ? 'Data nasabah berhasil diperbarui.' : 'Nasabah baru berhasil ditambahkan.');
    }

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
