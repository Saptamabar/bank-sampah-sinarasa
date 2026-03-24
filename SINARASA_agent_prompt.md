# 🌿 SINARASA — Sistem Informasi Bank Sampah Desa Sidomukti

> **Perintah Khusus untuk AI Agent**
> Proyek: Website Bank Sampah SINARASA
> Lokasi: Desa Sidomukti, Kecamatan Mayang, Jember, Jawa Timur
> Framework: Laravel 11 + Livewire 3 + Alpine.js + MySQL

---

## 🎯 Konteks Proyek

Kamu adalah seorang senior full-stack developer yang bertugas membangun website **SINARASA** (Sistem Informasi Bank Sampah Desa Sidomukti). Website ini adalah platform digital untuk mengelola bank sampah berbasis komunitas di Desa Sidomukti, Kecamatan Mayang, Kabupaten Jember, Jawa Timur. Tujuan utama website ini adalah mendorong partisipasi warga dalam pengelolaan sampah dengan sistem gamifikasi berbasis poin dan hadiah.

Website ini menggunakan **Livewire 3** untuk navigasi tanpa reload halaman (SPA-like experience) dan interaktivitas reaktif, sambil tetap menggunakan ekosistem Laravel + Blade sepenuhnya.

---

## 🛠️ Tech Stack Wajib

| Layer | Teknologi |
|---|---|
| Backend Framework | **Laravel 11** (PHP 8.2+) |
| Reaktivitas & SPA | **Livewire 3** (navigasi tanpa reload) |
| Frontend | **Blade Templating** + **Tailwind CSS v3** + **Alpine.js v3** |
| Database | **MySQL 8** |
| Peta/Lokasi | **Leaflet.js** (OpenStreetMap, gratis) |
| Autentikasi | Laravel Breeze **with Livewire stack** (multi-role) |
| UI Component | Flowbite atau komponen custom Tailwind |
| Notifikasi | Laravel Notifications (database + opsional email) |
| Storage | Laravel Storage (lokal atau S3) |

---

## ⚡ Arsitektur Livewire — Aturan Wajib

### Navigasi Tanpa Reload (`wire:navigate`)
Gunakan **`wire:navigate`** pada **semua** tag `<a>` internal situs agar perpindahan halaman tidak memicu full page reload:

```blade
{{-- WAJIB: Semua link internal pakai wire:navigate --}}
<a href="{{ route('dashboard') }}" wire:navigate>Dashboard</a>
<a href="{{ route('setoran.index') }}" wire:navigate>Riwayat Setoran</a>

{{-- Navbar, sidebar, breadcrumb — semua pakai wire:navigate --}}
```

Livewire akan otomatis melakukan prefetch dan swap konten halaman via AJAX, memberikan pengalaman seperti SPA tanpa framework JavaScript terpisah.

### Persistent Layout
Gunakan **Persistent Layout** di Livewire agar navbar dan sidebar tidak di-render ulang saat navigasi:

```php
// Di setiap Livewire Full-Page Component
#[Layout('layouts.app')]   // untuk user
#[Layout('layouts.admin')] // untuk admin
class Dashboard extends Component { ... }
```

### Kapan Pakai Livewire Component vs Blade Biasa

| Situasi | Gunakan |
|---|---|
| Halaman dengan state reaktif (form, filter, tabel dinamis) | **Livewire Full-Page Component** |
| Halaman statis sederhana (landing, detail artikel) | **Blade view biasa + Controller** (tetap pakai `wire:navigate`) |
| Widget reaktif dalam halaman (modal konfirmasi, live search, counter poin) | **Livewire Nested Component** |
| Interaksi UI ringan tanpa server roundtrip (toggle dropdown, accordion) | **Alpine.js** murni |

### Kombinasi Livewire + Alpine.js (`$wire`)
Gunakan `$wire` untuk menghubungkan Alpine.js dengan Livewire component:

```blade
{{-- Contoh: tombol hapus dengan konfirmasi Alpine, lalu aksi Livewire --}}
<div x-data="{ confirmOpen: false }">
    <button @click="confirmOpen = true">Hapus</button>
    <div x-show="confirmOpen">
        <p>Yakin ingin menghapus?</p>
        <button @click="confirmOpen = false; $wire.delete({{ $id }})">Ya, Hapus</button>
        <button @click="confirmOpen = false">Batal</button>
    </div>
</div>
```

### Flash Message dengan Livewire Events
```php
// Di Livewire component setelah aksi berhasil
$this->dispatch('flash', type: 'success', message: 'Data berhasil disimpan!');
```

```blade
{{-- Di layouts/app.blade.php — listener global --}}
<div x-data x-on:flash.window="
    // tampilkan toast notification
    $dispatch('show-toast', { type: $event.detail.type, message: $event.detail.message })
">
```

---

## 👥 Peran Pengguna (Roles)

### 1. `admin`
Pengurus Bank Sampah Desa Sidomukti. Memiliki akses penuh ke dashboard manajemen.

### 2. `user`
Warga Desa Sidomukti yang terdaftar sebagai nasabah bank sampah.

---

## 🗄️ Struktur Database

Buat migrasi Laravel untuk tabel-tabel berikut:

### Tabel `users`
```
id, name, nik (KTP, unique), phone, address, rt, rw, photo, role (enum: admin|user),
points_total (integer, default 0), is_active (boolean), email, password,
remember_token, timestamps
```

### Tabel `waste_categories`
```
id, name (e.g. "Plastik", "Kertas", "Logam", "Kaca", "Organik"), 
unit (e.g. "kg", "pcs"), points_per_unit (decimal), 
description, icon, is_active, timestamps
```

### Tabel `collection_posts` (Pos Bank Sampah)
```
id, name, address, rt, rw, latitude (decimal 10,7), longitude (decimal 10,7),
pic_name (penanggung jawab), pic_phone, operational_hours, photo,
is_active, timestamps
```

### Tabel `waste_submissions` (Pengajuan Setoran Sampah)
```
id, user_id (FK), collection_post_id (FK), submission_date,
status (enum: pending|validated|rejected), 
notes (catatan dari user), admin_notes, validated_by (FK users.id),
validated_at, total_points_earned (integer), timestamps
```

### Tabel `waste_submission_items` (Detail Jenis Sampah)
```
id, waste_submission_id (FK), waste_category_id (FK),
quantity (decimal), points_per_unit (snapshot), subtotal_points (integer),
timestamps
```

### Tabel `rewards` (Hadiah/Penukaran Poin)
```
id, name, description, points_required (integer), stock (integer),
photo, is_active, timestamps
```

### Tabel `redemptions` (Riwayat Penukaran Hadiah)
```
id, user_id (FK), reward_id (FK), points_used (integer),
status (enum: pending|approved|rejected|delivered),
notes, admin_notes, processed_by (FK users.id), processed_at, timestamps
```

### Tabel `point_transactions` (Ledger Poin)
```
id, user_id (FK), type (enum: credit|debit), amount (integer),
reference_type (morphs: waste_submissions|redemptions),
reference_id, description, balance_after, timestamps
```

### Tabel `news` (Berita/Pengumuman)
```
id, title, slug, content (longtext), thumbnail, category 
(enum: berita|pengumuman|edukasi), author_id (FK), is_published, 
published_at, timestamps
```

---

## 🔐 Sistem Autentikasi & Otorisasi

- Install **Laravel Breeze** dengan stack **`livewire`**: `php artisan breeze:install livewire`.
- Tambahkan field `role`, `nik`, `phone`, `address`, `rt`, `rw`, `photo` pada form registrasi dan migrasi.
- Gunakan **Laravel Gates dan Policies** untuk otorisasi.
- Middleware `role:admin` dan `role:user` untuk proteksi route.
- Setelah login, redirect berdasarkan role:
  - `admin` → `/admin/dashboard`
  - `user` → `/dashboard`
- Registrasi user baru default `role = user`, status `is_active = false` sampai diaktifkan admin.
- Halaman login dan register sudah menjadi Livewire component bawaan Breeze (SPA-like otomatis).

---

## 📋 Fitur & Halaman Lengkap

---

### 🌐 HALAMAN PUBLIK (Tanpa Login)

#### 1. Landing Page (`/`)
- Hero section dengan nama **SINARASA** dan tagline
- Penjelasan singkat tentang bank sampah
- Statistik publik: total nasabah, total sampah terkumpul (kg), total poin beredar
- Cara kerja (3 langkah: Kumpul → Setor → Tukar Poin)
- Daftar pos bank sampah (peta + kartu)
- Berita/pengumuman terbaru (3 artikel)
- CTA: Daftar Sekarang / Login

#### 2. Peta Pos Bank Sampah (`/peta`)
- Tampilkan **Leaflet.js** map dengan marker untuk setiap `collection_posts` yang aktif
- Klik marker → popup info: nama pos, alamat, PIC, jam operasional
- Koordinat default map: Desa Sidomukti, Kec. Mayang, Jember (lat: -8.1000, lng: 113.7500, zoom: 14)

#### 3. Halaman Berita (`/berita`)
- List artikel dengan filter kategori
- Detail artikel (`/berita/{slug}`)

#### 4. Halaman Login (`/login`) & Registrasi (`/register`)

---

### 👤 PANEL USER (Warga)

Semua route diawali `/` dan memerlukan autentikasi role `user`.

#### 1. Dashboard User (`/dashboard`)
- Greeting dengan nama user
- Kartu poin total saat ini
- Riwayat 5 setoran terakhir (dengan status badge)
- Riwayat 5 penukaran poin terakhir
- Shortcut: Setor Sampah, Tukar Poin, Lihat Peta

#### 2. Setoran Sampah — Pengajuan (`/setoran/buat`)
- Implementasikan sebagai **Livewire Full-Page Component** `CreateSubmission`
- Form pengajuan setoran:
  - Pilih **Pos Bank Sampah** (dropdown, `wire:model`)
  - Tanggal setoran (date picker, `wire:model`)
  - **Dynamic rows** untuk jenis sampah: tambah/hapus baris via `wire:click`, pilih kategori dan jumlah → estimasi poin dihitung otomatis di PHP (`updatedItems()`) dan tampil reaktif
  - Catatan tambahan (opsional)
  - Preview total estimasi poin secara reaktif (Livewire computed property)
- Submit via `wire:submit.prevent="store"` → status `pending`, menunggu validasi admin

#### 3. Riwayat Setoran (`/setoran`)
- Implementasikan sebagai **Livewire Full-Page Component** `SubmissionList`
- Tabel/list semua setoran milik user
- Filter status dan tanggal reaktif via `wire:model.live` (tanpa tombol submit)
- Badge status: `pending` (kuning), `validated` (hijau), `rejected` (merah)
- Klik detail → navigasi via `wire:navigate` ke halaman detail

#### 4. Katalog Hadiah & Penukaran (`/hadiah`)
- Grid kartu hadiah yang aktif (foto, nama, poin yang dibutuhkan, stok)
- Tombol "Tukar" → konfirmasi modal → submit `redemption`
- Validasi: poin user harus cukup

#### 5. Riwayat Penukaran (`/penukaran`)
- List semua riwayat penukaran dengan status

#### 6. Riwayat Poin (`/poin`)
- Tabel transaksi poin: tanggal, deskripsi, credit/debit, saldo setelah transaksi

#### 7. Profil (`/profil`)
- Edit data diri, foto profil, ganti password

#### 8. Peta Pos (`/peta`) — akses dari dalam juga

---

### 🔧 PANEL ADMIN

Semua route diawali `/admin/` dan memerlukan autentikasi role `admin`.

#### 1. Dashboard Admin (`/admin/dashboard`)
- Statistik ringkasan:
  - Total nasabah aktif
  - Setoran hari ini / bulan ini (jumlah & kg)
  - Poin beredar total
  - Penukaran hadiah pending
  - Setoran pending menunggu validasi
- Grafik: setoran per bulan (Chart.js atau ApexCharts)
- Tabel setoran terbaru yang `pending` (aksi cepat validasi)
- Tabel penukaran terbaru yang `pending`

#### 2. Manajemen Pengguna (`/admin/pengguna`)
- Tabel semua user dengan filter (aktif/nonaktif, cari nama/NIK)
- Aksi: aktifkan, nonaktifkan, lihat detail, edit, hapus
- Form tambah user manual (admin bisa daftarkan warga langsung)
- Detail user: info lengkap + riwayat setoran + riwayat poin

#### 3. Validasi Setoran (`/admin/setoran`)
- Implementasikan sebagai **Livewire Full-Page Component** `AdminSubmissionList`
- Tabel semua setoran, filter: status, pos, tanggal, user — semua reaktif via `wire:model.live`
- Live search nama user (`wire:model.live.debounce.300ms`)
- Klik detail → halaman detail via `wire:navigate`
- Di halaman detail (`AdminSubmissionDetail` Livewire component):
  - Admin bisa edit jumlah aktual tiap item (input reaktif, total poin update otomatis)
  - Input `admin_notes` via `wire:model`
  - Tombol **Validasi**: `wire:click="validate"` → loading state otomatis via `wire:loading`
  - Tombol **Tolak**: buka modal konfirmasi (Alpine.js) → `$wire.reject()`
- Proses validasi harus atomic (gunakan `DB::transaction()`)

#### 4. Manajemen Kategori Sampah (`/admin/kategori-sampah`)
- CRUD kategori sampah
- Set `points_per_unit` (poin per satuan berat/unit)
- Toggle aktif/nonaktif

#### 5. Manajemen Pos Bank Sampah (`/admin/pos`)
- CRUD pos bank sampah
- Input koordinat latitude & longitude (dengan preview peta mini Leaflet)
- Toggle aktif/nonaktif

#### 6. Manajemen Hadiah (`/admin/hadiah`)
- CRUD hadiah/reward
- Set nama, deskripsi, poin yang dibutuhkan, stok, foto
- Toggle aktif/nonaktif

#### 7. Manajemen Penukaran Hadiah (`/admin/penukaran`)
- Tabel penukaran dengan status `pending`
- Aksi: Setujui (→ `approved`), Tandai Terkirim (→ `delivered`), Tolak (→ `rejected`)
- Input catatan admin

#### 8. Manajemen Berita/Pengumuman (`/admin/berita`)
- CRUD artikel berita/pengumuman/edukasi
- Rich text editor (gunakan TinyMCE atau Trix)
- Publish/unpublish

#### 9. Laporan (`/admin/laporan`)
- Laporan setoran: per periode, per pos, per kategori sampah → export CSV/PDF
- Laporan penukaran: per periode → export CSV/PDF
- Laporan nasabah aktif → export CSV

#### 10. Pengaturan Sistem (`/admin/pengaturan`)
- Informasi website (nama, tagline, logo, kontak)
- Pengaturan poin (misal: minimum penukaran, batas maksimum)

---

## 🎨 Panduan Desain & UI/UX

### Identitas Visual SINARASA
- **Palet warna utama**: Hijau organik (`#2D6A4F`, `#40916C`, `#74C69D`) sebagai warna dominan
- **Aksen**: Kuning/amber (`#F4A261`) untuk highlight dan CTA
- **Netral**: Putih gading dan abu-abu lembut untuk background
- **Font**: Gunakan Google Fonts — `Plus Jakarta Sans` untuk heading, `Inter` atau `Nunito` untuk body
- **Ikon**: Heroicons (sudah termasuk di Tailwind) atau Lucide Icons

### Prinsip UI
- **Responsive first**: Mobile, tablet, desktop — semua harus sempurna
- **Card-based layout** untuk dashboard, katalog hadiah, dan list pos
- **Badge berwarna** untuk status: pending=kuning, validated=hijau, rejected=merah
- **Loading state** pada tombol menggunakan `wire:loading` dan `wire:target` (bukan manual Alpine.js)
- **Flash message** via Livewire event dispatch setelah setiap aksi
- **Empty state** yang informatif ketika data kosong
- **Optimistic UI**: Gunakan `wire:loading.class` untuk disable tombol saat request berlangsung

### Komponen Wajib
- Navbar responsif dengan hamburger menu di mobile
- Sidebar admin collapsible
- Modal konfirmasi sebelum aksi kritis (hapus, validasi, tukar poin)
- Pagination pada semua tabel data
- Breadcrumb pada halaman admin

---

## ⚙️ Logika Bisnis Penting

### Kalkulasi Poin Setoran
```
subtotal_points = quantity × points_per_unit (diambil dari waste_categories saat pengajuan)
total_points_earned = SUM(subtotal_points semua item)
```
> **Snapshot poin**: Simpan `points_per_unit` pada `waste_submission_items` saat pengajuan agar riwayat tidak berubah jika admin mengubah tarif poin di kemudian hari.

### Kredit Poin (saat validasi)
```php
// Gunakan DB::transaction()
DB::transaction(function () use ($submission) {
    $submission->update(['status' => 'validated', 'total_points_earned' => $totalPoints]);
    $user->increment('points_total', $totalPoints);
    PointTransaction::create([
        'user_id' => $user->id,
        'type' => 'credit',
        'amount' => $totalPoints,
        'reference_type' => 'waste_submissions',
        'reference_id' => $submission->id,
        'description' => 'Validasi setoran sampah #' . $submission->id,
        'balance_after' => $user->points_total,
    ]);
});
```

### Debit Poin (saat penukaran hadiah)
```php
DB::transaction(function () use ($redemption, $user, $reward) {
    if ($user->points_total < $reward->points_required) {
        throw new \Exception('Poin tidak mencukupi.');
    }
    $user->decrement('points_total', $reward->points_required);
    $reward->decrement('stock');
    $redemption->update(['status' => 'approved', 'points_used' => $reward->points_required]);
    PointTransaction::create([
        'user_id' => $user->id,
        'type' => 'debit',
        'amount' => $reward->points_required,
        'reference_type' => 'redemptions',
        'reference_id' => $redemption->id,
        'description' => 'Penukaran hadiah: ' . $reward->name,
        'balance_after' => $user->points_total,
    ]);
});
```

---

## 📁 Struktur Direktori Laravel

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Auth/                  (bawaan Breeze)
│   └── Middleware/
│       └── RoleMiddleware.php
├── Livewire/
│   ├── Admin/
│   │   ├── Dashboard.php
│   │   ├── UserList.php
│   │   ├── UserForm.php
│   │   ├── SubmissionList.php
│   │   ├── SubmissionDetail.php
│   │   ├── WasteCategoryList.php
│   │   ├── CollectionPostList.php
│   │   ├── RewardList.php
│   │   ├── RedemptionList.php
│   │   ├── NewsList.php
│   │   └── ReportPage.php
│   └── User/
│       ├── Dashboard.php
│       ├── CreateSubmission.php   (form dinamis + kalkulasi poin reaktif)
│       ├── SubmissionList.php
│       ├── RewardCatalog.php
│       ├── RedemptionList.php
│       ├── PointHistory.php
│       └── ProfilePage.php
├── Models/
│   ├── User.php
│   ├── WasteCategory.php
│   ├── CollectionPost.php
│   ├── WasteSubmission.php
│   ├── WasteSubmissionItem.php
│   ├── Reward.php
│   ├── Redemption.php
│   ├── PointTransaction.php
│   └── News.php
└── Policies/
    └── WasteSubmissionPolicy.php

resources/views/
├── layouts/
│   ├── app.blade.php              (layout publik & user, WAJIB ada <livewire:scripts />)
│   ├── admin.blade.php            (layout admin dengan sidebar)
│   └── auth.blade.php             (layout login/register)
├── components/
│   ├── flash-message.blade.php    (listener event Livewire dispatch)
│   ├── stat-card.blade.php
│   └── badge-status.blade.php
├── livewire/
│   ├── admin/                     (view Blade untuk setiap Livewire admin component)
│   └── user/                      (view Blade untuk setiap Livewire user component)
├── public/                        (halaman publik statis — Blade biasa + Controller)
│   ├── landing.blade.php
│   ├── peta.blade.php
│   └── berita/
└── (auth views bawaan Breeze)

routes/
└── web.php                        (gunakan Route::get(...)->middleware([...]) grup admin & user)
```

---

## 🚀 Urutan Pengerjaan (Step-by-Step)

Ikuti urutan ini secara ketat:

1. **Setup Project**
   ```bash
   laravel new sinarasa
   cd sinarasa
   composer require livewire/livewire
   php artisan breeze:install livewire   # Breeze dengan Livewire stack
   npm install && npm run build
   ```
   - Konfigurasi `.env` (database, `APP_NAME=SINARASA`, `APP_TIMEZONE=Asia/Jakarta`)
   - Pastikan `@livewireStyles` dan `@livewireScripts` ada di semua layout utama

2. **Database & Models**
   - Buat semua migrasi sesuai skema di atas
   - Buat semua Model dengan relasi (`hasMany`, `belongsTo`, `morphTo`)
   - Buat Seeders: `AdminSeeder`, `WasteCategorySeeder`, `CollectionPostSeeder`, `RewardSeeder`

3. **Autentikasi & Role**
   - Modifikasi Breeze Livewire component (RegisteredUserController / Register.php) untuk field tambahan
   - Buat `RoleMiddleware` dan daftarkan di `bootstrap/app.php`
   - Redirect post-login berdasarkan role

4. **Layout & Navigasi**
   - Buat `layouts/app.blade.php` dan `layouts/admin.blade.php` dengan semua link menggunakan `wire:navigate`
   - Sidebar admin collapsible menggunakan Alpine.js
   - Pastikan persistent layout berjalan (tidak ada flicker saat navigasi)

5. **Panel Admin** (mulai dari fitur inti)
   - Buat Livewire components: `UserList`, `WasteCategoryList`, `CollectionPostList`, `RewardList`
   - `SubmissionList` + `SubmissionDetail` (fitur validasi terpenting)
   - `Dashboard` admin dengan grafik

6. **Panel User**
   - `CreateSubmission` Livewire component (form dinamis + kalkulasi poin real-time)
   - `SubmissionList`, `PointHistory`, `RewardCatalog`, `RedemptionList`
   - `ProfilePage`

7. **Halaman Publik**
   - Landing Page (Blade biasa, tetap gunakan `wire:navigate` di semua link)
   - Peta Leaflet.js — inisialisasi map dengan `@script` directive Livewire agar tidak konflik
   - Halaman Berita

8. **Polish & Testing**
   - Test navigasi tanpa reload di semua halaman
   - Test `wire:loading` state di semua tombol aksi
   - Responsive test: mobile, tablet, desktop
   - Pastikan Leaflet.js di-reinisialisasi dengan benar menggunakan hook `document.addEventListener('livewire:navigated', ...)`

---

## ✅ Checklist Kualitas

Sebelum menyelesaikan setiap fitur, pastikan:

- [ ] Semua route diproteksi middleware yang tepat
- [ ] Semua input form divalidasi dengan Livewire `#[Validate]` attribute atau `rules()` method
- [ ] Operasi kritis (poin kredit/debit) menggunakan `DB::transaction()`
- [ ] Tidak ada N+1 query (gunakan `with()` eager loading)
- [ ] Semua halaman responsif (mobile-first)
- [ ] Flash message tampil via `$this->dispatch('flash', ...)` setelah setiap aksi
- [ ] Semua link internal menggunakan `wire:navigate`
- [ ] Semua tombol aksi memiliki `wire:loading.attr="disabled"` dan `wire:target`
- [ ] Pagination menggunakan `WithPagination` trait Livewire (`$this->resetPage()` saat filter berubah)
- [ ] Gambar/foto yang diupload divalidasi (mimeType, maxSize) via `#[Validate]`
- [ ] Koordinat peta pos dapat dipreview sebelum disimpan
- [ ] Leaflet.js diinisialisasi ulang dengan `document.addEventListener('livewire:navigated', initMap)`
- [ ] Tidak ada konflik antara Alpine.js `x-data` dan Livewire `wire:model` pada elemen yang sama

---

## 📍 Data Awal (Seed)

### Admin Default
```
Name: Admin SINARASA
Email: admin@sinarasa.id
Password: sinarasa2024
Role: admin
```

### Pos Bank Sampah Awal (Contoh)
```
Nama: Pos Induk Sidomukti
Alamat: Balai Desa Sidomukti, Kec. Mayang, Jember
Latitude: -8.1023
Longitude: 113.7489
PIC: Kepala Desa / Pengurus BUMDes
```

### Kategori Sampah Awal
| Kategori | Satuan | Poin/Satuan |
|---|---|---|
| Plastik Keras | kg | 500 |
| Plastik Lunak | kg | 300 |
| Kertas/Kardus | kg | 250 |
| Logam/Besi | kg | 700 |
| Aluminium | kg | 1000 |
| Kaca | kg | 200 |
| Sampah Organik | kg | 100 |

### Hadiah Awal
| Hadiah | Poin |
|---|---|
| Sabun Cuci (500gr) | 1.500 |
| Minyak Goreng (1L) | 5.000 |
| Beras (2kg) | 8.000 |
| Pulsa Rp 10.000 | 10.000 |

---

## ⚠️ Livewire Gotchas & Solusi

### 1. Leaflet.js dengan `wire:navigate`
Leaflet.js harus diinisialisasi ulang setiap kali halaman peta dimuat via navigasi Livewire:
```javascript
// Di view peta — JANGAN gunakan DOMContentLoaded
document.addEventListener('livewire:navigated', function () {
    if (document.getElementById('map')) {
        initSinarasaMap(); // fungsi inisialisasi Leaflet
    }
});
// Juga panggil sekali untuk load pertama
initSinarasaMap();
```

### 2. Menghindari Konflik Alpine.js + Livewire
Jangan pasang `x-data` pada elemen yang memiliki `wire:model`. Pisahkan:
```blade
{{-- SALAH: konflik --}}
<input x-data="{ val: '' }" wire:model="name" x-model="val">

{{-- BENAR: gunakan salah satu, atau pisahkan scope --}}
<div x-data="{ open: false }">
    <input wire:model="name">  {{-- Livewire handle value --}}
    <button @click="open = !open">Toggle</button>  {{-- Alpine handle UI state --}}
</div>
```

### 3. Upload File di Livewire
Gunakan trait `WithFileUploads` untuk upload foto:
```php
use Livewire\WithFileUploads;
class RewardList extends Component {
    use WithFileUploads;
    #[Validate('image|max:2048')]
    public $photo;
}
```

### 4. Pagination Livewire
```php
use Livewire\WithPagination;
class SubmissionList extends Component {
    use WithPagination;
    public function updatedSearch() { $this->resetPage(); }
    public function updatedStatusFilter() { $this->resetPage(); }
}
```

### 5. Route untuk Livewire Full-Page Component
```php
// routes/web.php
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', \App\Livewire\User\Dashboard::class)->name('dashboard');
    Route::get('/setoran', \App\Livewire\User\SubmissionList::class)->name('setoran.index');
    Route::get('/setoran/buat', \App\Livewire\User\CreateSubmission::class)->name('setoran.create');
    // ...
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('/setoran', \App\Livewire\Admin\SubmissionList::class)->name('setoran.index');
    // ...
});
```

---



- Seluruh antarmuka dalam **Bahasa Indonesia**
- Format tanggal: `dd MMMM yyyy` (contoh: 24 Maret 2026)
- Format angka poin: gunakan titik sebagai pemisah ribuan (contoh: 1.500 poin)
- Timezone: `Asia/Jakarta`
- Set di `config/app.php`: `'locale' => 'id'`, `'timezone' => 'Asia/Jakarta'`

---

*Dokumen ini adalah instruksi lengkap untuk membangun website SINARASA. Ikuti setiap bagian dengan teliti dan tanyakan jika ada yang perlu klarifikasi sebelum memulai pengerjaan.*
