<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 border-b border-gray-100 pb-3 mb-6 font-heading">
            {{ __('Ubah Kata Sandi') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 mb-6">
            {{ __('Pastikan akun Anda menggunakan kata sandi acak yang panjang untuk tetap aman.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        <div>
            <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" />
            <x-text-input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full bg-gray-50" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" />
            <x-text-input wire:model="password" id="update_password_password" name="password" type="password" class="mt-1 block w-full bg-gray-50" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')" />
            <x-text-input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-gray-50" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 mt-8 pt-6 border-t border-gray-100">
            <x-primary-button class="bg-brand hover:bg-brand-dark focus:bg-brand-dark">{{ __('Simpan Kata Sandi') }}</x-primary-button>

            <x-action-message class="me-3 text-green-600 font-medium font-heading" on="password-updated">
                {{ __('Tersimpan.') }}
            </x-action-message>
        </div>
    </form>
</section>
