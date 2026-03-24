<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('/pengguna', \App\Livewire\Admin\UserList::class)->name('pengguna.index');
    Route::get('/kategori-sampah', \App\Livewire\Admin\WasteCategoryList::class)->name('kategori.index');
    Route::get('/pos', \App\Livewire\Admin\CollectionPostList::class)->name('pos.index');
    Route::get('/setoran', \App\Livewire\Admin\SubmissionList::class)->name('setoran.index');
    Route::get('/setoran/{submissionId}', \App\Livewire\Admin\SubmissionDetail::class)->name('setoran.detail');
    Route::get('/hadiah', \App\Livewire\Admin\RewardList::class)->name('hadiah.index');
    Route::get('/penukaran', \App\Livewire\Admin\RedemptionList::class)->name('penukaran.index');
    Route::get('/berita', \App\Livewire\Admin\NewsList::class)->name('berita.index');
    Route::get('/laporan', \App\Livewire\Admin\ReportPage::class)->name('laporan.index');
});

// User Routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', \App\Livewire\User\Dashboard::class)->name('dashboard');
    Route::get('/setoran/buat', \App\Livewire\User\CreateSubmission::class)->name('setoran.create');
    Route::view('profile', 'profile')->name('profile');
});

require __DIR__.'/auth.php';
