# Membuat Modul CRUD Baru dengan Kategori

Dokumentasi ini adalah lanjutan dari [membuat-modul-crud-baru.md](./membuat-modul-crud-baru.md). Diasumsikan kamu sudah memahami cara membuat modul CRUD dasar.

Contoh kasus: membuat modul **`Portfolio`** yang memiliki kategori.

---

## Konsep Sistem Kategori

Proyek ini menggunakan **satu tabel kategori terpusat** (`kategori`) yang dibedakan dengan kolom `kategori_tipe`. Setiap modul yang membutuhkan kategori cukup menambahkan tipe baru ke kolom tersebut.

| Tipe (`kategori_tipe`) | Digunakan Oleh |
|---|---|
| `post` | Modul Post |
| `product` | Modul Product |
| `team` | Modul Team |
| `portfolio` | Modul Portfolio (contoh baru) |

Kategori dikelola dari menu **Categories** yang sudah ada di sidebar. Saat membuat kategori baru, user memilih tipe dari dropdown.

---

## Langkah-langkah

### Langkah 1: Tambah Tipe Baru ke Dropdown Kategori

Buka controller kategori dan tambahkan tipe baru ke array pilihan tipe:

**`app/Modules/Category/Http/Controllers/Backend/CategoryController.php`**

```php
// Cari array $types di method create() dan store()
$types = [
    'post'      => 'Post',
    'product'   => 'Product',
    'team'      => 'Team',
    'portfolio' => 'Portfolio', // ← tambahkan ini
];
```

Lakukan hal yang sama di method `edit()` dan `update()`.

---

### Langkah 2: Tambahkan Scope ke Model Category

Buka model kategori dan tambahkan scope untuk tipe baru:

**`app/Modules/Category/Models/Category.php`**

```php
// Tambahkan di bawah scopeForProducts()
public function scopeForPortfolios()
{
    return $this->where('kategori_tipe', 'portfolio');
}
```

---

### Langkah 3: Buat Migration Modul Portfolio

```bash
php artisan make:migration create_portfolios_table
```

Isi migration dengan foreign key ke tabel `kategori`:

```php
public function up(): void
{
    Schema::create('portfolios', function (Blueprint $table) {
        $table->id('portfolio_id');
        $table->string('portfolio_judul');
        $table->string('portfolio_slug')->unique();
        $table->longText('portfolio_konten')->nullable();
        $table->string('portfolio_deskripsi')->nullable();
        $table->unsignedBigInteger('portfolio_kategori_id')->nullable(); // ← foreign key
        $table->string('portfolio_gambar')->nullable();
        $table->enum('portfolio_status', ['aktif', 'nonaktif'])->default('aktif');
        $table->integer('portfolio_urutan')->default(0);
        $table->timestamps();

        // ← foreign key constraint ke tabel kategori
        $table->foreign('portfolio_kategori_id')
              ->references('kategori_id')
              ->on('kategori')
              ->onDelete('set null');
    });
}

public function down(): void
{
    Schema::dropIfExists('portfolios');
}
```

Jalankan migration:

```bash
php artisan migrate
```

---

### Langkah 4: Buat Model Portfolio

**`app/Modules/Portfolio/Models/Portfolio.php`**

```php
<?php

namespace App\Modules\Portfolio\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use App\Modules\Category\Models\Category;

class Portfolio extends Model
{
    protected $table = 'portfolios';
    protected $primaryKey = 'portfolio_id';

    protected $fillable = [
        'portfolio_judul',
        'portfolio_slug',
        'portfolio_konten',
        'portfolio_deskripsi',
        'portfolio_kategori_id',
        'portfolio_gambar',
        'portfolio_status',
        'portfolio_urutan',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($portfolio) {
            if (empty($portfolio->portfolio_slug)) {
                $portfolio->portfolio_slug = Str::slug($portfolio->portfolio_judul);
            }
        });
    }

    // ← Relasi ke model Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'portfolio_kategori_id', 'kategori_id');
    }

    public function getRouteKeyName()
    {
        return 'portfolio_slug';
    }
}
```

---

### Langkah 5: Buat Controller

**`app/Modules/Portfolio/Http/Controllers/Backend/PortfolioController.php`**

```php
<?php

namespace App\Modules\Portfolio\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Modules\Portfolio\Models\Portfolio;
use App\Modules\Category\Models\Category;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $query = Portfolio::with('category');

        if ($request->filled('search')) {
            $query->where('portfolio_judul', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('portfolio_kategori_id', $request->category);
        }

        $portfolios = $query->latest()->paginate(10);

        // ← Load hanya kategori bertipe 'portfolio'
        $categories = Category::forPortfolios()->active()->ordered()->get();

        return view('portfolio::backend.index', compact('portfolios', 'categories'));
    }

    public function create()
    {
        // ← Load hanya kategori bertipe 'portfolio'
        $categories = Category::forPortfolios()->active()->ordered()->get();

        return view('portfolio::backend.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'portfolio_judul'       => 'required|string|max:255',
            'portfolio_deskripsi'   => 'nullable|string',
            'portfolio_konten'      => 'nullable|string',
            'portfolio_kategori_id' => 'nullable|exists:kategori,kategori_id',
            'portfolio_gambar'      => 'nullable|image|max:2048',
            'portfolio_status'      => 'required|in:aktif,nonaktif',
        ]);

        if ($request->hasFile('portfolio_gambar')) {
            $validated['portfolio_gambar'] = $request->file('portfolio_gambar')
                ->store('uploads/portfolio', 'public');
        }

        Portfolio::create($validated);

        return redirect()->route('portfolios.index')
            ->with('success', 'Portfolio berhasil ditambahkan!');
    }

    public function show(Portfolio $portfolio)
    {
        $portfolio->load('category');
        return view('portfolio::backend.show', compact('portfolio'));
    }

    public function edit(Portfolio $portfolio)
    {
        // ← Load hanya kategori bertipe 'portfolio'
        $categories = Category::forPortfolios()->active()->ordered()->get();

        return view('portfolio::backend.edit', compact('portfolio', 'categories'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'portfolio_judul'       => 'required|string|max:255',
            'portfolio_deskripsi'   => 'nullable|string',
            'portfolio_konten'      => 'nullable|string',
            'portfolio_kategori_id' => 'nullable|exists:kategori,kategori_id',
            'portfolio_gambar'      => 'nullable|image|max:2048',
            'portfolio_status'      => 'required|in:aktif,nonaktif',
        ]);

        if ($request->hasFile('portfolio_gambar')) {
            $validated['portfolio_gambar'] = $request->file('portfolio_gambar')
                ->store('uploads/portfolio', 'public');
        }

        $portfolio->update($validated);

        return redirect()->route('portfolios.index')
            ->with('success', 'Portfolio berhasil diperbarui!');
    }

    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();

        return redirect()->route('portfolios.index')
            ->with('success', 'Portfolio berhasil dihapus!');
    }
}
```

---

### Langkah 6: Buat Routes

**`app/Modules/Portfolio/routes.php`**

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Portfolio\Http\Controllers\Backend\PortfolioController;

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('portfolios', PortfolioController::class)
        ->middleware('can:admin-access');
});
```

---

### Langkah 7: Buat ServiceProvider

**`app/Modules/Portfolio/PortfolioServiceProvider.php`**

```php
<?php

namespace App\Modules\Portfolio;

use Illuminate\Support\ServiceProvider;

class PortfolioServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadViewsFrom(__DIR__ . '/Views', 'portfolio');
    }
}
```

Daftarkan di `bootstrap/providers.php`:

```php
App\Modules\Portfolio\PortfolioServiceProvider::class,
```

---

### Langkah 8: Buat Views

Buat folder `app/Modules/Portfolio/Views/Backend/`.

#### index.blade.php — Tabel dengan filter kategori

```blade
@extends('core::dashboard-layout')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between gap-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Portfolio</h1>
            <p class="text-gray-600 mt-1">Kelola semua portfolio</p>
            <div class="mt-4">
                <a href="{{ route('portfolios.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition inline-block">
                    + Tambah Portfolio
                </a>
            </div>
        </div>
        <div class="flex-shrink-0">
            <form method="GET" action="{{ route('portfolios.index') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari portfolio..."
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">

                {{-- ← Filter berdasarkan kategori --}}
                <select name="category" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->kategori_id }}" {{ request('category') == $cat->kategori_id ? 'selected' : '' }}>
                            {{ $cat->kategori_nama }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                    Cari
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Judul</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Kategori</th>
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
                        {{-- ← Tampilkan nama kategori dari relasi --}}
                        @if($portfolio->category)
                            <span class="text-gray-700">{{ $portfolio->category->kategori_nama }}</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $portfolio->portfolio_status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($portfolio->portfolio_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $portfolio->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-3 items-center">
                            <a href="{{ route('portfolios.show', $portfolio) }}" class="text-gray-600 hover:text-gray-900" title="Lihat">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </a>
                            <a href="{{ route('portfolios.edit', $portfolio) }}" class="text-blue-600 hover:text-blue-900" title="Edit">
                                <i data-lucide="edit" class="w-5 h-5"></i>
                            </a>
                            <form action="{{ route('portfolios.destroy', $portfolio) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-600">
                        Belum ada portfolio. <a href="{{ route('portfolios.create') }}" class="text-teal-600 font-semibold">Buat yang pertama</a>
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

#### create.blade.php — Form dengan dropdown kategori

```blade
@extends('core::dashboard-layout')
@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('portfolios.index') }}" class="text-gray-500 hover:text-gray-700">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Tambah Portfolio</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl">
        <form action="{{ route('portfolios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            {!! formField('portfolio_judul', 'text', 'Judul', null, [], ['required' => true]) !!}

            {{-- ← Dropdown kategori — gunakan data yang dikirim controller --}}
            {!! formField('portfolio_kategori_id', 'select', 'Kategori', null,
                $categories->pluck('kategori_nama', 'kategori_id')->toArray(),
                ['placeholder' => 'Pilih Kategori']
            ) !!}

            {!! formField('portfolio_deskripsi', 'textarea', 'Deskripsi', null, [], ['rows' => 3]) !!}

            {!! formField('portfolio_gambar', 'file', 'Gambar', null, [], ['accept' => 'image/*']) !!}

            {!! formField('portfolio_status', 'select', 'Status', 'aktif', ['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif'], ['required' => true]) !!}

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                    Simpan
                </button>
                <a href="{{ route('portfolios.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-semibold transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
```

#### edit.blade.php — Form edit dengan nilai yang sudah terisi

```blade
@extends('core::dashboard-layout')
@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('portfolios.index') }}" class="text-gray-500 hover:text-gray-700">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Edit Portfolio</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl">
        <form action="{{ route('portfolios.update', $portfolio) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            {!! formField('portfolio_judul', 'text', 'Judul', $portfolio->portfolio_judul, [], ['required' => true]) !!}

            {{-- ← Dropdown kategori dengan nilai yang sudah dipilih sebelumnya --}}
            {!! formField('portfolio_kategori_id', 'select', 'Kategori', $portfolio->portfolio_kategori_id,
                $categories->pluck('kategori_nama', 'kategori_id')->toArray(),
                ['placeholder' => 'Pilih Kategori']
            ) !!}

            {!! formField('portfolio_deskripsi', 'textarea', 'Deskripsi', $portfolio->portfolio_deskripsi, [], ['rows' => 3]) !!}

            {!! formField('portfolio_status', 'select', 'Status', $portfolio->portfolio_status, ['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif'], ['required' => true]) !!}

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                    Simpan
                </button>
                <a href="{{ route('portfolios.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-semibold transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
```

#### show.blade.php

```blade
@extends('core::dashboard-layout')
@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('portfolios.index') }}" class="text-gray-500 hover:text-gray-700">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Detail Portfolio</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl space-y-4">
        <div>
            <p class="text-xs text-gray-500 mb-0.5">Judul</p>
            <p class="font-medium text-gray-900">{{ $portfolio->portfolio_judul }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500 mb-0.5">Kategori</p>
            <p class="text-gray-700">{{ $portfolio->category?->kategori_nama ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500 mb-0.5">Status</p>
            <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $portfolio->portfolio_status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                {{ ucfirst($portfolio->portfolio_status) }}
            </span>
        </div>
        <div class="flex gap-3 pt-2">
            <a href="{{ route('portfolios.edit', $portfolio) }}" class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                Edit
            </a>
            <a href="{{ route('portfolios.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-semibold transition">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
```

---

### Langkah 9: Tambah Entry Navigasi di Sidebar

Jalankan tinker atau buat seeder untuk menambahkan navigasi:

```php
// Buat parent group (jika modul Portfolio berdiri sendiri)
$parent = \App\Modules\Navigation\Models\Navigation::create([
    'menu_label'     => 'Portfolio',
    'menu_route'     => '#',
    'menu_ikon'      => 'briefcase',
    'menu_urutan'    => 10,
    'menu_status'    => true,
    'menu_parent_id' => null,
]);

// Child: daftar portfolio
\App\Modules\Navigation\Models\Navigation::create([
    'menu_label'     => 'Semua Portfolio',
    'menu_route'     => 'portfolios.index',
    'menu_ikon'      => 'layout-grid',
    'menu_urutan'    => 1,
    'menu_status'    => true,
    'menu_parent_id' => $parent->menu_id,
]);

// Child: kelola kategori portfolio
// (mengarah ke halaman Categories yang sudah ada, dengan filter type=portfolio)
\App\Modules\Navigation\Models\Navigation::create([
    'menu_label'     => 'Kategori Portfolio',
    'menu_route'     => 'categories.index',
    'menu_ikon'      => 'tag',
    'menu_urutan'    => 2,
    'menu_status'    => true,
    'menu_parent_id' => $parent->menu_id,
]);
```

> **Catatan:** Menu "Kategori Portfolio" cukup mengarah ke `categories.index` karena halaman tersebut memiliki filter tipe. User bisa filter sendiri, atau kamu bisa tambahkan `?type=portfolio` ke URL jika ingin lebih spesifik.

Atau bisa juga dilakukan via UI: buka **Navigations** di dashboard, tambahkan item secara manual.

---

## Ringkasan Perbedaan dengan Modul Biasa

| Hal | Modul Biasa | Modul dengan Kategori |
|---|---|---|
| Migration | Tidak ada FK ke kategori | Tambah `kategori_id` + `foreign()` |
| Model | - | Tambah `category()` belongsTo |
| Controller | Tidak load kategori | Load `Category::forXxx()->active()->ordered()->get()` |
| View (create/edit) | - | Tambah dropdown `kategori_id` |
| View (index) | - | Tambah filter dropdown kategori |
| View (show) | - | Tampilkan `$item->category->kategori_nama` |
| Category Model | - | Tambah `scopeForXxx()` |
| Category Controller | - | Tambah tipe baru ke array `$types` |
| Navigasi | 1 item | 2 item: modul + link ke Categories |

---

## Tips

- **Kategori opsional atau wajib?** Gunakan `nullable` di migration dan `nullable|exists:...` di validasi jika kategori tidak wajib.
- **Menampilkan kategori di frontend:** Gunakan `Post::where('kategori_id', $id)->get()` atau scope `byCategory()` untuk memfilter konten berdasarkan kategori.
- **Lazy vs Eager loading:** Gunakan `with('category')` di query index untuk menghindari N+1 query.
- **Slug kategori:** Akses via `$item->category->kategori_slug` untuk keperluan URL frontend.
