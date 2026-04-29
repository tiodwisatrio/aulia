# Panduan Membuat Modul CRUD Baru

Panduan lengkap membuat modul CRUD baru di CMS-TIO dari nol, berdasarkan pola nyata yang dipakai seluruh modul yang sudah ada.

---

## Daftar Isi

1. [Cara Kerja Sistem Modul](#1-cara-kerja-sistem-modul)
2. [Struktur Direktori](#2-struktur-direktori)
3. [Checklist Langkah-Langkah](#3-checklist-langkah-langkah)
4. [Step 1 — Migration](#step-1--migration)
5. [Step 2 — Model](#step-2--model)
6. [Step 3 — Controller Backend](#step-3--controller-backend)
7. [Step 4 — Routes](#step-4--routes)
8. [Step 5 — ServiceProvider](#step-5--serviceprovider)
9. [Step 6 — Views Backend](#step-6--views-backend)
10. [Step 7 — Tambah Menu Sidebar](#step-7--tambah-menu-sidebar)
11. [Step 8 — Frontend (Opsional)](#step-8--frontend-opsional)
12. [Konvensi Penamaan](#konvensi-penamaan)
13. [Kesalahan Umum dan Solusinya](#kesalahan-umum-dan-solusinya)
14. [Helper yang Tersedia](#helper-yang-tersedia)

---
<!-- Command make migration untuk modul-->
php artisan make:migration create_portfolio_table --create=portfolio

## 1. Cara Kerja Sistem Modul

Sistem modul bekerja secara **auto-discovery** — tidak perlu mendaftarkan modul ke `config/app.php` atau `bootstrap/providers.php`.

**Alurnya:**
1. `ModuleManager::discover()` membaca semua folder di `app/Modules/`
2. Untuk setiap folder `{NamaModul}`, dicari class `App\Modules\{NamaModul}\{NamaModul}ServiceProvider`
3. Jika class ditemukan, ServiceProvider otomatis di-boot → routes & views modul dimuat

**Syarat agar auto-discovery bekerja:**

| Item | Contoh |
|---|---|
| Nama folder | `app/Modules/Hero/` |
| Nama file ServiceProvider | `HeroServiceProvider.php` |
| Nama class | `class HeroServiceProvider` |
| Namespace | `namespace App\Modules\Hero;` |

Semua harus konsisten. Jika salah satu tidak cocok, modul tidak terdaftar.

---

## 2. Struktur Direktori

Contoh untuk modul `Portfolio`:

```
app/Modules/Portfolio/
├── PortfolioServiceProvider.php   ← WAJIB, nama harus exact
├── routes.php
├── Http/
│   └── Controllers/
│       └── Backend/
│           └── PortfolioController.php
├── Models/
│   └── Portfolio.php
└── Views/
    └── Backend/
        ├── index.blade.php
        ├── create.blade.php
        ├── edit.blade.php
        └── show.blade.php
```

---

## 3. Checklist Langkah-Langkah

- [ ] Buat migration → jalankan `php artisan migrate`
- [ ] Buat Model di `app/Modules/{Modul}/Models/`
- [ ] Buat Controller di `app/Modules/{Modul}/Http/Controllers/Backend/`
- [ ] Buat `routes.php` — pastikan `use` import controller **benar**
- [ ] Buat `{Modul}ServiceProvider.php`
- [ ] Buat folder `Views/Backend/` dan 4 view (index, create, edit, show)
- [ ] Tambah menu di dashboard **Navigation**
- [ ] Jalankan `php artisan storage:link` (hanya sekali, jika ada upload gambar)

---

## Step 1 — Migration

```php
<?php
// database/migrations/2026_01_01_000000_create_portfolio_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('portfolio', function (Blueprint $table) {
            $table->id('portfolio_id');
            $table->string('portfolio_judul');
            $table->text('portfolio_deskripsi')->nullable();
            $table->string('portfolio_gambar')->nullable();
            $table->tinyInteger('portfolio_status')->default(1);  // 1=aktif, 0=nonaktif
            $table->integer('portfolio_urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio');
    }
};
```

Jalankan: `php artisan migrate`

**Konvensi kolom:**

| Kolom | Tipe | Keterangan |
|---|---|---|
| `{prefix}_id` | bigIncrements | Primary key |
| `{prefix}_judul` / `{prefix}_nama` | string | Nama/judul utama |
| `{prefix}_deskripsi` / `{prefix}_konten` | text, nullable | Teks panjang |
| `{prefix}_gambar` | string, nullable | Path file gambar |
| `{prefix}_status` | tinyInteger, default 1 | 1=Aktif, 0=Nonaktif |
| `{prefix}_urutan` | integer, default 0 | Urutan tampil |

> Jangan tambahkan kolom `slug` jika modul tidak butuh URL slug di frontend.

---

## Step 2 — Model

### Modul tanpa slug (paling umum)

```php
<?php
namespace App\Modules\Portfolio\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $table      = 'portfolio';
    protected $primaryKey = 'portfolio_id';

    protected $fillable = [
        'portfolio_judul',
        'portfolio_deskripsi',
        'portfolio_gambar',
        'portfolio_status',
        'portfolio_urutan',
    ];

    protected $casts = [
        'portfolio_status' => 'integer',
        'portfolio_urutan' => 'integer',
    ];
}
```

### Modul dengan slug (untuk URL frontend)

Gunakan **hanya jika tabel memang punya kolom `slug`**:

```php
<?php
namespace App\Modules\Portfolio\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    protected $table      = 'portfolio';
    protected $primaryKey = 'portfolio_id';

    protected $fillable = [
        'portfolio_judul',
        'portfolio_deskripsi',
        'portfolio_status',
        'slug',              // hanya jika kolom ada di tabel
    ];

    // Auto-generate slug dari judul
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $base = Str::slug($model->portfolio_judul);
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $model->slug = $slug;
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('portfolio_judul') && !$model->isDirty('slug')) {
                $model->slug = Str::slug($model->portfolio_judul);
            }
        });
    }

    // Route model binding pakai slug (untuk frontend route)
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
```

> ⚠️ **Jangan tambahkan `boot()`, `getRouteKeyName()`, atau `use Str` jika tabel tidak punya kolom `slug`.** Akan error saat create/update karena Laravel mencoba menulis ke kolom yang tidak ada.

---

## Step 3 — Controller Backend

```php
<?php
namespace App\Modules\Portfolio\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\Portfolio\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $query = Portfolio::latest();

        if ($request->filled('search')) {
            $query->where('portfolio_judul', 'like', '%' . $request->search . '%');
        }

        $portfolios = $query->paginate(10);
        return view('portfolio::backend.index', compact('portfolios'));
    }

    public function create()
    {
        return view('portfolio::backend.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'portfolio_judul'     => 'required|max:255',
            'portfolio_deskripsi' => 'nullable',
            'portfolio_gambar'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'portfolio_status'    => 'required|in:0,1',
            'portfolio_urutan'    => 'nullable|integer',
        ]);

        $data = $request->only([
            'portfolio_judul', 'portfolio_deskripsi',
            'portfolio_status', 'portfolio_urutan',
        ]);

        if ($request->hasFile('portfolio_gambar')) {
            $data['portfolio_gambar'] = $request->file('portfolio_gambar')
                ->store('uploads/portfolio', 'public');
        }

        Portfolio::create($data);

        return redirect()->route('portfolios.index')
            ->with('success', 'Portfolio berhasil ditambahkan.');
    }

    public function show(Portfolio $portfolio)
    {
        return view('portfolio::backend.show', compact('portfolio'));
    }

    public function edit(Portfolio $portfolio)
    {
        return view('portfolio::backend.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'portfolio_judul'     => 'required|max:255',
            'portfolio_deskripsi' => 'nullable',
            'portfolio_gambar'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'portfolio_status'    => 'required|in:0,1',
            'portfolio_urutan'    => 'nullable|integer',
        ]);

        $data = $request->only([
            'portfolio_judul', 'portfolio_deskripsi',
            'portfolio_status', 'portfolio_urutan',
        ]);

        if ($request->hasFile('portfolio_gambar')) {
            // Hapus gambar lama sebelum simpan yang baru
            if ($portfolio->portfolio_gambar) {
                Storage::disk('public')->delete($portfolio->portfolio_gambar);
            }
            $data['portfolio_gambar'] = $request->file('portfolio_gambar')
                ->store('uploads/portfolio', 'public');
        }

        $portfolio->update($data);

        return redirect()->route('portfolios.index')
            ->with('success', 'Portfolio berhasil diperbarui.');
    }

    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->portfolio_gambar) {
            Storage::disk('public')->delete($portfolio->portfolio_gambar);
        }

        $portfolio->delete();

        return redirect()->route('portfolios.index')
            ->with('success', 'Portfolio berhasil dihapus.');
    }
}
```

---

## Step 4 — Routes

```php
<?php
// app/Modules/Portfolio/routes.php

use Illuminate\Support\Facades\Route;
use App\Modules\Portfolio\Http\Controllers\Backend\PortfolioController;
// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
// WAJIB: tulis namespace lengkap controller yang benar

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('portfolios', PortfolioController::class)
        ->middleware('can:admin-access');
});
```

> ⚠️ **Kesalahan paling sering di file ini:** Lupa menulis atau salah menulis `use` import.
> Jika `use` tidak ada atau namespace-nya salah, Laravel akan throw:
> `BindingResolutionException: Target class [PortfolioController] does not exist`

**Route yang dihasilkan otomatis:**

| Method | URI | Route Name | Controller |
|---|---|---|---|
| GET | /dashboard/portfolios | `portfolios.index` | `index()` |
| GET | /dashboard/portfolios/create | `portfolios.create` | `create()` |
| POST | /dashboard/portfolios | `portfolios.store` | `store()` |
| GET | /dashboard/portfolios/{id} | `portfolios.show` | `show()` |
| GET | /dashboard/portfolios/{id}/edit | `portfolios.edit` | `edit()` |
| PUT/PATCH | /dashboard/portfolios/{id} | `portfolios.update` | `update()` |
| DELETE | /dashboard/portfolios/{id} | `portfolios.destroy` | `destroy()` |

---

## Step 5 — ServiceProvider

```php
<?php
// app/Modules/Portfolio/PortfolioServiceProvider.php

namespace App\Modules\Portfolio;
//        ^^^^^^^^^^^^^^^^^^^^^ sesuai nama folder

use Illuminate\Support\ServiceProvider;

class PortfolioServiceProvider extends ServiceProvider
//    ^^^^^^^^^^^^^^^^^^^^^^^^^ harus {NamaModul}ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Load routes
        $routesPath = __DIR__ . '/routes.php';
        if (file_exists($routesPath)) {
            $this->app['router']->group(['middleware' => ['web']], function () use ($routesPath) {
                require $routesPath;
            });
        }

        // Load views dengan namespace lowercase
        $this->loadViewsFrom(__DIR__ . '/Views', 'portfolio');
        //                                        ^^^^^^^^^
        //          dipakai di controller: view('portfolio::backend.index')
    }
}
```

> **Tidak perlu** daftarkan ke `bootstrap/providers.php`. Auto-discovery sudah menanganinya.

---

## Step 6 — Views Backend

Semua view extends `core::dashboard-layout`. Flash message (`success`, `error`) sudah ditangani otomatis oleh layout — **jangan** tambahkan sendiri di view.

### index.blade.php

```blade
@extends('core::dashboard-layout')
@section('header', 'Portfolio')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between gap-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Portfolio</h1>
            <p class="text-gray-600 mt-1">Kelola semua portfolio</p>
            <div class="mt-4">
                <a href="{{ route('portfolios.create') }}"
                   class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition inline-block">
                    + Tambah Portfolio
                </a>
            </div>
        </div>
        <form method="GET" action="{{ route('portfolios.index') }}" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari portfolio..."
                   class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition">Cari</button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Judul</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Dibuat</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($portfolios as $portfolio)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $portfolio->portfolio_judul }}</td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                            {{ $portfolio->portfolio_status ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $portfolio->portfolio_status ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $portfolio->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-3 items-center">
                            <a href="{{ route('portfolios.show', $portfolio) }}" class="text-gray-500 hover:text-gray-800" title="Lihat">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('portfolios.edit', $portfolio) }}" class="text-blue-500 hover:text-blue-800" title="Edit">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('portfolios.destroy', $portfolio) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Hapus {{ $portfolio->portfolio_judul }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-800" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                        Belum ada portfolio.
                        <a href="{{ route('portfolios.create') }}" class="text-teal-600 font-semibold">Buat yang pertama</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex justify-center">{{ $portfolios->links() }}</div>
</div>
@endsection
```

### create.blade.php

```blade
@extends('core::dashboard-layout')
@section('header', 'Tambah Portfolio')
@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('portfolios.index') }}" class="text-gray-500 hover:text-gray-700">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Tambah Portfolio</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('portfolios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="portfolio_judul" value="{{ old('portfolio_judul') }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none @error('portfolio_judul') border-red-400 @enderror">
                @error('portfolio_judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="portfolio_deskripsi" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none">{{ old('portfolio_deskripsi') }}</textarea>
            </div>

            <!-- Upload gambar dengan preview -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
                <input type="file" name="portfolio_gambar" accept="image/*" id="img_input"
                       class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700">
                <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Maks 2MB.</p>
                <div id="preview_wrap" class="hidden mt-3">
                    <p class="text-xs text-gray-500 mb-1">Preview:</p>
                    <img id="preview_img" src="#" class="h-40 rounded-lg border border-gray-200 object-cover">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="portfolio_status" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    <option value="1" {{ old('portfolio_status', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('portfolio_status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">Simpan</button>
                <a href="{{ route('portfolios.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-semibold transition">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('img_input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = ev => {
            document.getElementById('preview_img').src = ev.target.result;
            document.getElementById('preview_wrap').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    });
</script>
@endsection
```

### edit.blade.php

Perbedaan utama dari `create.blade.php`:
1. Action form: `route('portfolios.update', $portfolio)` + `@method('PUT')`
2. Value field: `old('field', $model->field)` bukan hanya `old('field')`
3. Tampilkan gambar existing sebelum input file
4. Header: "Edit Portfolio" bukan "Tambah Portfolio"

```blade
@extends('core::dashboard-layout')
@section('header', 'Edit Portfolio')
@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('portfolios.index') }}" class="text-gray-500 hover:text-gray-700">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Edit Portfolio</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('portfolios.update', $portfolio) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="portfolio_judul" value="{{ old('portfolio_judul', $portfolio->portfolio_judul) }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none @error('portfolio_judul') border-red-400 @enderror">
                @error('portfolio_judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="portfolio_deskripsi" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none">{{ old('portfolio_deskripsi', $portfolio->portfolio_deskripsi) }}</textarea>
            </div>

            <!-- Gambar: tampilkan existing + preview baru -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>

                @if($portfolio->portfolio_gambar)
                <div class="mb-2">
                    <p class="text-xs text-gray-500 mb-1">Gambar saat ini:</p>
                    <img id="current_img" src="{{ asset('storage/' . $portfolio->portfolio_gambar) }}"
                         class="h-40 rounded-lg border border-gray-200 object-cover">
                </div>
                @endif

                <input type="file" name="portfolio_gambar" accept="image/*" id="img_input"
                       class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-50 file:text-teal-700">
                <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin ganti gambar. Format: JPG, PNG. Maks 2MB.</p>

                <div id="preview_wrap" class="hidden mt-3">
                    <p class="text-xs text-gray-500 mb-1">Preview gambar baru:</p>
                    <img id="preview_img" src="#" class="h-40 rounded-lg border border-gray-200 object-cover">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="portfolio_status" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    <option value="1" {{ old('portfolio_status', $portfolio->portfolio_status) == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('portfolio_status', $portfolio->portfolio_status) == '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">Simpan Perubahan</button>
                <a href="{{ route('portfolios.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-semibold transition">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('img_input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = ev => {
            document.getElementById('preview_img').src = ev.target.result;
            document.getElementById('preview_wrap').classList.remove('hidden');
            const cur = document.getElementById('current_img');
            if (cur) cur.classList.add('hidden'); // sembunyikan gambar lama
        };
        reader.readAsDataURL(file);
    });
</script>
@endsection
```

### show.blade.php

```blade
@extends('core::dashboard-layout')
@section('header', 'Detail Portfolio')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('portfolios.index') }}" class="text-gray-500 hover:text-gray-700">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">{{ $portfolio->portfolio_judul }}</h1>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('portfolios.edit', $portfolio) }}"
               class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                Edit
            </a>
            <form action="{{ route('portfolios.destroy', $portfolio) }}" method="POST" class="inline"
                  onsubmit="return confirm('Hapus portfolio ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
        @if($portfolio->portfolio_gambar)
        <img src="{{ asset('storage/' . $portfolio->portfolio_gambar) }}" class="rounded-lg max-h-64 object-cover">
        @endif

        <div>
            <p class="text-xs text-gray-500 font-semibold">DESKRIPSI</p>
            <p class="text-gray-700 mt-1">{{ $portfolio->portfolio_deskripsi ?? '-' }}</p>
        </div>

        <div>
            <p class="text-xs text-gray-500 font-semibold">STATUS</p>
            <span class="mt-1 inline-block text-xs font-semibold px-3 py-1 rounded-full
                {{ $portfolio->portfolio_status ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                {{ $portfolio->portfolio_status ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>

        <div>
            <p class="text-xs text-gray-500 font-semibold">DIBUAT</p>
            <p class="text-gray-700 mt-1">{{ $portfolio->created_at->format('d M Y, H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('portfolios.index') }}" class="text-teal-600 hover:text-teal-900 font-semibold">
        ← Kembali ke Portfolio
    </a>
</div>
@endsection
```

---

## Step 7 — Tambah Menu Sidebar

Buka dashboard → **Navigations** → tambah item baru:

| Field | Nilai |
|---|---|
| Label | `Portfolio` |
| Route | `portfolios.index` |
| Icon | `briefcase` |
| Status | Aktif |

Atau via tinker:
```bash
php artisan tinker
```
```php
\App\Modules\Navigation\Models\Navigation::create([
    'menu_label'  => 'Portfolio',
    'menu_route'  => 'portfolios.index',
    'menu_ikon'   => 'briefcase',
    'menu_urutan' => 10,
    'menu_status' => 1,
]);
```

**Icon Lucide yang umum dipakai:**

| Nama Icon | Kegunaan |
|---|---|
| `home` | Home / Beranda |
| `file-text` | Post / Artikel |
| `package` | Produk |
| `image` | Galeri / Foto |
| `users` | Tim |
| `star` | Unggulan / Testimoni |
| `mail` | Email / Kontak |
| `briefcase` | Portfolio / Karir |
| `calendar` | Agenda / Jadwal |
| `layout` | Hero / Banner |
| `tag` | Kategori |
| `message-circle` | Pesan / Chat |
| `settings` | Pengaturan |
| `info` | About / Tentang |
| `award` | Penghargaan / Nilai |
| `help-circle` | FAQ |

---

## Step 8 — Frontend (Opsional)

Tambahkan halaman publik jika modul perlu diakses pengunjung tanpa login (seperti halaman blog, produk, portfolio).

### Struktur tambahan

```
app/Modules/Portfolio/
├── Http/
│   └── Controllers/
│       ├── Backend/
│       │   └── PortfolioController.php   ← sudah ada
│       └── Frontend/
│           └── PortfolioController.php   ← tambahkan ini
└── Views/
    ├── Backend/                          ← sudah ada
    └── Frontend/
        ├── index.blade.php               ← daftar/list
        └── show.blade.php                ← detail (opsional)
```

### 8a — Controller Frontend

```php
<?php
// app/Modules/Portfolio/Http/Controllers/Frontend/PortfolioController.php

namespace App\Modules\Portfolio\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Modules\Portfolio\Models\Portfolio;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::where('portfolio_status', 1)
            ->orderBy('portfolio_urutan')
            ->latest()
            ->paginate(12);

        return view('portfolio::frontend.index', compact('portfolios'));
    }

    public function show(Portfolio $portfolio)
    {
        // Opsional: hanya tampilkan yang aktif
        abort_if($portfolio->portfolio_status !== 1, 404);

        return view('portfolio::frontend.show', compact('portfolio'));
    }
}
```

> **Perbedaan dari controller backend:**
> - Tidak ada middleware `auth`
> - Filter hanya data yang aktif (`portfolio_status = 1`)
> - Tidak ada method create/store/edit/update/destroy

---

### 8b — Routes Frontend

Update `routes.php` — tambahkan import alias dan route publik:

```php
<?php
// app/Modules/Portfolio/routes.php

use Illuminate\Support\Facades\Route;
use App\Modules\Portfolio\Http\Controllers\Backend\PortfolioController as BackendPortfolioController;
use App\Modules\Portfolio\Http\Controllers\Frontend\PortfolioController as FrontendPortfolioController;

// ── Frontend (publik, tanpa login) ───────────────────────────────────────────
Route::get('/portfolio', [FrontendPortfolioController::class, 'index'])
    ->name('frontend.portfolio.index');

Route::get('/portfolio/{portfolio}', [FrontendPortfolioController::class, 'show'])
    ->name('frontend.portfolio.show');

// ── Backend (butuh login) ─────────────────────────────────────────────────────
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('portfolios', BackendPortfolioController::class)
        ->middleware('can:admin-access');
});
```

> ⚠️ Saat kedua controller punya nama class yang sama (`PortfolioController`), **wajib pakai alias** `as BackendPortfolioController` dan `as FrontendPortfolioController`. Tanpa alias akan error.

**Route dengan slug** (jika model pakai slug):

```php
// Gunakan {portfolio:slug} untuk route model binding pakai kolom slug
Route::get('/portfolio/{portfolio:slug}', [FrontendPortfolioController::class, 'show'])
    ->name('frontend.portfolio.show');
```

---

### 8c — Views Frontend

Frontend views extends `frontend.layouts.app` (bukan `core::dashboard-layout`).

**Dua layout frontend yang tersedia:**

| Layout | File | Dipakai untuk |
|---|---|---|
| `frontend.layouts.app` | `resources/views/frontend/layouts/app.blade.php` | Halaman publik umum |
| `frontend.layouts.main` | `resources/views/frontend/layouts/main.blade.php` | Alternatif (sama saja) |

#### index.blade.php (daftar)

```blade
@extends('frontend.layouts.app')

@section('title', 'Portfolio')

@section('content')
<!-- Hero / Banner -->
<div class="bg-gray-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-3">Portfolio</h1>
        <p class="text-gray-400">Karya-karya terbaik kami</p>
    </div>
</div>

<!-- Grid Konten -->
<div class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        @if($portfolios->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($portfolios as $portfolio)
                <div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition">
                    @if($portfolio->portfolio_gambar)
                        <img src="{{ asset('storage/' . $portfolio->portfolio_gambar) }}"
                             alt="{{ $portfolio->portfolio_judul }}"
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                            <i data-lucide="image" class="w-12 h-12 text-gray-300"></i>
                        </div>
                    @endif
                    <div class="p-5">
                        <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $portfolio->portfolio_judul }}</h3>
                        @if($portfolio->portfolio_deskripsi)
                            <p class="text-gray-600 text-sm line-clamp-3">{{ $portfolio->portfolio_deskripsi }}</p>
                        @endif
                        <a href="{{ route('frontend.portfolio.show', $portfolio) }}"
                           class="mt-4 inline-flex items-center gap-1 text-teal-600 font-semibold text-sm hover:text-teal-800">
                            Lihat Detail <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-10 flex justify-center">
                {{ $portfolios->links() }}
            </div>
        @else
            <div class="text-center py-16 text-gray-500">
                <i data-lucide="folder-open" class="w-12 h-12 mx-auto mb-3 text-gray-300"></i>
                <p>Belum ada portfolio.</p>
            </div>
        @endif
    </div>
</div>
@endsection
```

#### show.blade.php (detail)

```blade
@extends('frontend.layouts.app')

@section('title', $portfolio->portfolio_judul)

@section('content')
<div class="py-16">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-6">
            <a href="{{ route('frontend.home') }}" class="hover:text-teal-600">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('frontend.portfolio.index') }}" class="hover:text-teal-600">Portfolio</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">{{ $portfolio->portfolio_judul }}</span>
        </nav>

        <!-- Konten -->
        <div class="bg-white rounded-xl shadow p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $portfolio->portfolio_judul }}</h1>

            @if($portfolio->portfolio_gambar)
                <img src="{{ asset('storage/' . $portfolio->portfolio_gambar) }}"
                     alt="{{ $portfolio->portfolio_judul }}"
                     class="w-full rounded-lg mb-6 object-cover max-h-96">
            @endif

            @if($portfolio->portfolio_deskripsi)
                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($portfolio->portfolio_deskripsi)) !!}
                </div>
            @endif
        </div>

        <a href="{{ route('frontend.portfolio.index') }}"
           class="mt-6 inline-flex items-center gap-2 text-teal-600 font-semibold hover:text-teal-800">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Portfolio
        </a>
    </div>
</div>
@endsection
```

---

### 8d — Link di Navigasi / Footer

Setelah frontend aktif, tambahkan link di:

**Header** (`resources/views/frontend/layouts/header.blade.php`):
```blade
<a href="{{ route('frontend.portfolio.index') }}"
   class="... {{ request()->routeIs('frontend.portfolio.*') ? 'text-teal-600 font-semibold' : 'text-gray-700' }}">
    Portfolio
</a>
```

**Footer** (`resources/views/frontend/layouts/footer.blade.php`):
```blade
<li><a href="{{ route('frontend.portfolio.index') }}" class="text-sm hover:text-white transition">Portfolio</a></li>
```

---

### Checklist Tambahan untuk Frontend

- [ ] Buat `Controllers/Frontend/PortfolioController.php`
- [ ] Update `routes.php` — tambahkan alias import + route publik
- [ ] Buat folder `Views/Frontend/` dan view `index.blade.php`
- [ ] (Opsional) Buat `Views/Frontend/show.blade.php` untuk halaman detail
- [ ] Tambahkan link ke header dan/atau footer

---

## Konvensi Penamaan

| Item | Pola | Contoh |
|---|---|---|
| Nama folder modul | PascalCase | `Portfolio` |
| Nama ServiceProvider | `{Modul}ServiceProvider` | `PortfolioServiceProvider` |
| Namespace modul | `App\Modules\{Modul}` | `App\Modules\Portfolio` |
| Nama tabel DB | snake_case | `portfolio` |
| Nama kolom DB | `{prefix}_{nama}` | `portfolio_judul` |
| Primary key | `{prefix}_id` | `portfolio_id` |
| Nama route resource | plural lowercase | `portfolios` |
| View namespace | lowercase | `portfolio` |
| Akses view | `{namespace}::backend.{view}` | `portfolio::backend.index` |
| Path upload gambar | `uploads/{modul}` | `uploads/portfolio` |

---

## Kesalahan Umum dan Solusinya

### Error 1: `BindingResolutionException: Target class [XxxController] does not exist`

**Penyebab:** `use` import di `routes.php` salah namespace atau tidak ada.

```php
// SALAH ❌ — namespace salah (copy-paste dari modul lain)
use App\Modules\Hero\Http\Controllers\Backend\HeroController;
Route::resource('portfolios', PortfolioController::class); // PortfolioController tidak di-import!

// BENAR ✅
use App\Modules\Portfolio\Http\Controllers\Backend\PortfolioController;
Route::resource('portfolios', PortfolioController::class);
```

---

### Error 2: `View [portfolio::backend.index] not found`

**Penyebab:** Namespace view di ServiceProvider tidak cocok dengan yang dipakai controller.

```php
// ServiceProvider
$this->loadViewsFrom(__DIR__ . '/Views', 'portfolio'); // namespace = 'portfolio'

// Controller — harus cocok persis
return view('portfolio::backend.index', ...); // ✅ benar
return view('Portfolio::backend.index', ...); // ❌ salah (case sensitive)
```

---

### Error 3: Gambar tidak tampil setelah upload

**Penyebab:** Storage symlink belum dibuat.

```bash
php artisan storage:link  # jalankan sekali saja
```

---

### Error 4: Modul tidak terdeteksi / route 404

**Penyebab:** Nama class atau namespace ServiceProvider tidak sesuai nama folder.

```
# Harus konsisten:
Folder:    app/Modules/Hero/
File:      app/Modules/Hero/HeroServiceProvider.php
Class:     class HeroServiceProvider extends ServiceProvider
Namespace: namespace App\Modules\Hero;
```

---

### Error 5: Kolom tidak tersimpan

**Penyebab:** Kolom tidak ada di `$fillable` model.

```php
protected $fillable = [
    'portfolio_judul',
    'portfolio_kolom_baru', // ← harus ditambahkan agar bisa diisi
];
```

---

### Error 6: `Column 'slug' not found` atau `SQLSTATE: Column not found`

**Penyebab:** Model punya `boot()` yang set `$model->slug`, tapi tabel tidak punya kolom `slug`.

**Solusi:** Hapus `boot()`, `getRouteKeyName()`, dan `use Str` dari model jika tabel tidak punya kolom `slug`.

---

## Helper yang Tersedia

### `setting($key, $default = null)`

Ambil nilai dari tabel `site_settings`. Bisa dipakai di controller, view, atau mana saja.

```php
setting('site_name')         // nama website
setting('site_email')        // email
setting('site_phone')        // nomor telepon
setting('site_mobile')       // nomor HP
setting('site_address')      // alamat
setting('site_logo')         // path logo
setting('site_description')  // deskripsi singkat
setting('site_whatsapp')     // nomor WhatsApp
setting('site_instagram')    // URL Instagram
setting('site_youtube')      // URL YouTube
setting('site_tiktok')       // URL TikTok
setting('site_twitter')      // URL Twitter/X

// Dengan default value jika kosong:
setting('site_name', config('app.name'))
```

Di view Blade:
```blade
{{ setting('site_name') }}

@if(setting('site_logo'))
    <img src="{{ asset('storage/' . setting('site_logo')) }}" alt="logo">
@endif

@if(setting('site_phone'))
    <a href="tel:{{ setting('site_phone') }}">{{ setting('site_phone') }}</a>
@endif
```

---

## Tips Tambahan

1. **Flash message otomatis** — Gunakan `->with('success', '...')` atau `->with('error', '...')`. Sudah tampil otomatis oleh layout, tidak perlu kode tambahan di view.

2. **Pagination** — Gunakan `->paginate(10)` di controller dan `{{ $items->links() }}` di view.

3. **Form upload wajib enctype** — Setiap form yang punya `<input type="file">` harus ada `enctype="multipart/form-data"` di tag `<form>`.

4. **Hapus file lama saat update** — Selalu `Storage::disk('public')->delete($path)` sebelum simpan file baru agar storage tidak penuh.

5. **`old()` di form edit** — Selalu `old('field', $model->field)`, bukan hanya `$model->field`, agar nilai lama tetap muncul saat validasi gagal dan user harus mengisi ulang.

6. **Nama field = nama kolom** — `name="portfolio_judul"` di HTML harus sama persis dengan nama kolom di `$fillable` model. Kesalahan nama field adalah penyebab umum data tidak tersimpan.
