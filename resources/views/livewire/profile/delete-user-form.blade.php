<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-red-600 border-b border-gray-100 pb-3 mb-6 font-heading">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan data di dalamnya akan dihapus secara permanen. Poin Anda yang tersisa juga akan hangus dan tidak dapat dikembalikan.') }}
        </p>
    </header>

    <x-danger-button wire:click="confirmUserDeletion">
        {{ __('Hapus Akun Permanen') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6">
            <h2 class="text-lg font-medium text-gray-900 font-heading">
                {{ __('Apakah Anda yakin ingin menghapus akun ini?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Tindakan ini tidak dapat dibatalkan. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="sr-only" />

                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Kata Sandi') }}"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Hapus Akun Permanen') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
