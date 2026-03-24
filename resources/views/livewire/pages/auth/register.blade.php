<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $nik = '';
    public string $phone = '';
    public string $address = '';
    public string $rt = '';
    public string $rw = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'nik' => ['required', 'string', 'size:16', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'rt' => ['required', 'string', 'max:5'],
            'rw' => ['required', 'string', 'max:5'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        // Redirect based on role
        if ($user->role === 'admin') {
            $this->redirect(route('admin.dashboard', absolute: false), navigate: true);
        } else {
            $this->redirect(route('dashboard', absolute: false), navigate: true);
        }
    }
}; ?>

<div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- NIK -->
        <div class="mt-4">
            <x-input-label for="nik" :value="__('NIK (16 Digit)')" />
            <x-text-input wire:model="nik" id="nik" class="block mt-1 w-full" type="text" name="nik" required />
            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('No. HP / WhatsApp')" />
            <x-text-input wire:model="phone" id="phone" class="block mt-1 w-full" type="text" name="phone" required />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Alamat (Jalan/Dusun)')" />
            <x-text-input wire:model="address" id="address" class="block mt-1 w-full" type="text" name="address" required />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <div class="grid grid-cols-2 gap-4 mt-4">
            <!-- RT -->
            <div>
                <x-input-label for="rt" :value="__('RT')" />
                <x-text-input wire:model="rt" id="rt" class="block mt-1 w-full" type="text" name="rt" required />
                <x-input-error :messages="$errors->get('rt')" class="mt-2" />
            </div>

            <!-- RW -->
            <div>
                <x-input-label for="rw" :value="__('RW')" />
                <x-text-input wire:model="rw" id="rw" class="block mt-1 w-full" type="text" name="rw" required />
                <x-input-error :messages="$errors->get('rw')" class="mt-2" />
            </div>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
