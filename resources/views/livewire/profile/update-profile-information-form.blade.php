<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use Livewire\Volt\Component;

new class extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';
    public string $rt = '';
    public string $rw = '';
    public string $nik = '';
    
    public $photo;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name ?? '';
        $this->email = $user->email ?? '';
        $this->phone = $user->phone ?? '';
        $this->address = $user->address ?? '';
        $this->rt = $user->rt ?? '';
        $this->rw = $user->rw ?? '';
        $this->nik = $user->nik ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:25'],
            'address' => ['nullable', 'string'],
            'rt' => ['nullable', 'string', 'max:5'],
            'rw' => ['nullable', 'string', 'max:5'],
            'nik' => ['nullable', 'string', 'max:20'],
            'photo' => ['nullable', 'image', 'max:2048'], // 2MB Max
        ]);

        if ($this->photo) {
            $path = $this->photo->store('avatars', 'public');
            
            // Delete old photo
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $path;
        }

        $user->fill([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'rt' => $this->rt,
            'rw' => $this->rw,
            'nik' => $this->nik,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 border-b border-gray-100 pb-3 mb-6 font-heading">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 mb-6">
            {{ __("Perbarui data diri, foto profil, dan informasi kontak Anda.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="space-y-6">
        
        <!-- Photo Upload Profile -->
        <div class="flex items-center space-x-6 mb-6">
            <div class="shrink-0 h-24 w-24 rounded-full overflow-hidden bg-gray-100 border-2 border-brand/20 shadow-sm relative group cursor-pointer" onclick="document.getElementById('photoInput').click()">
                @if ($photo)
                    <img src="{{ $photo->temporaryUrl() }}" class="h-full w-full object-cover">
                @elseif (auth()->user()->photo)
                    <img src="{{ Storage::url(auth()->user()->photo) }}" class="h-full w-full object-cover">
                @else
                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.99614C2.083320 20.993 12 14.508 12 14.508C12 14.508 21.9167 20.993 24 20.993zM12 2C15.3137 2 18 4.68629 18 8C18 11.3137 15.3137 14 12 14C8.68629 14 6 11.3137 6 8C6 4.68629 8.68629 2 12 2z"/></svg>
                @endif
                
                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
            </div>
            <div>
                <x-input-label for="photo" value="{{ __('Foto Profil') }}" />
                <input wire:model="photo" id="photoInput" type="file" class="hidden" accept="image/*">
                <button type="button" onclick="document.getElementById('photoInput').click()" class="mt-2 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand">
                    Pilih Foto Baru
                </button>
                <div wire:loading wire:target="photo" class="text-sm text-brand-light mt-2 ml-2">Mengunggah...</div>
                <x-input-error class="mt-2" :messages="$errors->get('photo')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" />
                <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full bg-gray-50" required autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="nik" :value="__('NIK')" />
                <x-text-input wire:model="nik" id="nik" name="nik" type="text" class="mt-1 block w-full bg-gray-50" autocomplete="nik" />
                <x-input-error class="mt-2" :messages="$errors->get('nik')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full bg-gray-50" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="phone" :value="__('Nomor Handphone')" />
                <x-text-input wire:model="phone" id="phone" name="phone" type="text" class="mt-1 block w-full bg-gray-50" autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
        </div>

        <div class="mt-6">
            <x-input-label for="address" :value="__('Alamat')" />
            <textarea wire:model="address" id="address" name="address" rows="3" class="border-gray-300 focus:border-brand focus:ring-brand rounded-md shadow-sm block w-full bg-gray-50 mt-1"></textarea>
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-4">
            <div class="col-span-1 border border-transparent">
                <x-input-label for="rt" :value="__('RT')" />
                <x-text-input wire:model="rt" id="rt" name="rt" type="text" class="mt-1 block w-full bg-gray-50" />
                <x-input-error class="mt-2" :messages="$errors->get('rt')" />
            </div>
            <div class="col-span-1 border border-transparent">
                <x-input-label for="rw" :value="__('RW')" />
                <x-text-input wire:model="rw" id="rw" name="rw" type="text" class="mt-1 block w-full bg-gray-50" />
                <x-input-error class="mt-2" :messages="$errors->get('rw')" />
            </div>
        </div>

        <div class="flex items-center gap-4 mt-8 pt-6 border-t border-gray-100">
            <x-primary-button class="bg-brand hover:bg-brand-dark focus:bg-brand-dark">{{ __('Simpan Perubahan') }}</x-primary-button>

            <x-action-message class="me-3 text-green-600 font-medium font-heading" on="profile-updated">
                {{ __('Tersimpan.') }}
            </x-action-message>
        </div>
    </form>
</section>
