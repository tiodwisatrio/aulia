@extends('core::dashboard-layout')
@section('header', 'Menu')
@section('content')
<div class="space-y-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Kelola Menu Sidebar</h1>
        <p class="text-gray-500 text-sm mt-1">Drag & drop untuk atur urutan. Parent dan child bisa dipindah.</p>
    </div>

    <div class="flex gap-6 items-start">

        {{-- KIRI --}}
        <div class="w-72 flex-shrink-0 space-y-4">

            {{-- Tambah dari Modul --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-700 text-sm">Tambah Menu Modul</h3>
                </div>
                <div class="p-4">
                    <form action="{{ route('navigations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="menu_status" value="1">
                        <input type="hidden" name="menu_label" id="modulLabel">

                        <label class="block text-xs font-medium text-gray-600 mb-1">Pilih Modul <span class="text-red-500">*</span></label>
                        <select name="menu_route" id="modulSelect" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 mb-3">
                            <option value="">-- Pilih Modul --</option>
                            @foreach($availableModules as $mod)
                                <option value="{{ $mod['name'] }}" data-label="{{ $mod['label'] }}">{{ $mod['label'] }}</option>
                            @endforeach
                        </select>

                        @if($availableModules->isEmpty())
                            <p class="text-xs text-gray-400 italic mb-3">Semua modul sudah di menu.</p>
                        @endif

                        <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white py-2 rounded-lg text-sm font-semibold transition">
                            Tambah
                        </button>
                    </form>
                </div>
            </div>

            {{-- Tambah Custom --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-700 text-sm">Tambah Menu Custom</h3>
                </div>
                <div class="p-4">
                    <form action="{{ route('navigations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="menu_status" value="1">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Label <span class="text-red-500">*</span></label>
                        <input type="text" name="menu_label" required placeholder="Nama menu"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 mb-3">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Route</label>
                        <input type="text" name="menu_route" placeholder="posts.index"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 mb-3">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Icon <span class="text-xs text-gray-400">(Lucide)</span></label>
                        <input type="text" name="menu_ikon" placeholder="home, users..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 mb-3">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Parent <span class="text-xs text-gray-400">(opsional)</span></label>
                        <select name="menu_parent_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 mb-3">
                            <option value="">— Top Level —</option>
                            @foreach($navigations as $nav)
                                <option value="{{ $nav->menu_id }}">{{ $nav->menu_label }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white py-2 rounded-lg text-sm font-semibold transition">
                            Tambah
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 text-xs text-blue-700">
                <p class="font-semibold mb-1">Tips:</p>
                <p>Drag item untuk ubah urutan. Drag ke dalam item lain untuk jadikan child.</p>
            </div>
        </div>

        {{-- KANAN --}}
        <div class="flex-1">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-3 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-700 text-sm">Daftar Menu</h3>
                    <span class="text-xs text-gray-400">{{ $navigations->count() }} menu</span>
                </div>

                <div id="menu-list" class="p-3 space-y-1 min-h-16">
                    @forelse($navigations as $nav)
                    <div class="menu-item rounded-lg border border-gray-200 bg-white overflow-hidden" data-id="{{ $nav->menu_id }}">

                        {{-- Parent row --}}
                        <div class="flex items-center gap-2 px-3 py-2.5 bg-gray-50 hover:bg-gray-100 transition cursor-default">
                            <div class="drag-handle cursor-grab active:cursor-grabbing text-gray-300 flex-shrink-0">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM4 11.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM4 18a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM16 5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM16 11.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM16 18a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"/>
                                </svg>
                            </div>
                            @if($nav->menu_ikon)
                                <i data-lucide="{{ $nav->menu_ikon }}" class="w-4 h-4 text-gray-500 flex-shrink-0"></i>
                            @endif
                            <span class="flex-1 text-sm font-semibold text-gray-800">{{ $nav->menu_label }}</span>
                            @if(!$nav->menu_status)
                                <span class="text-xs bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded-full">Nonaktif</span>
                            @endif
                            <button onclick="toggleEdit({{ $nav->menu_id }})" title="Edit" class="text-gray-400 hover:text-teal-600 p-1 rounded hover:bg-teal-50 transition">
                                <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                            </button>
                            <form action="{{ route('navigations.destroy', $nav) }}" method="POST" class="inline" onsubmit="return confirm('Hapus {{ $nav->menu_label }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Hapus" class="text-gray-400 hover:text-red-500 p-1 rounded hover:bg-red-50 transition">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                </button>
                            </form>
                        </div>

                        {{-- Edit form parent --}}
                        <div id="edit-{{ $nav->menu_id }}" class="hidden px-4 py-3 border-t border-gray-100 bg-gray-50">
                            <form action="{{ route('navigations.update', $nav) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="text-xs text-gray-500 mb-0.5 block">Label</label>
                                        <input type="text" name="menu_label" value="{{ $nav->menu_label }}" required class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-teal-500">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 mb-0.5 block">Route</label>
                                        <input type="text" name="menu_route" value="{{ $nav->menu_route }}" class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-teal-500">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 mb-0.5 block">Icon</label>
                                        <input type="text" name="menu_ikon" value="{{ $nav->menu_ikon }}" placeholder="home" class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-teal-500">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 mb-0.5 block">Status</label>
                                        <select name="menu_status" class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-teal-500">
                                            <option value="1" {{ $nav->menu_status ? 'selected' : '' }}>Aktif</option>
                                            <option value="0" {{ !$nav->menu_status ? 'selected' : '' }}>Nonaktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex gap-2 mt-2">
                                    <button type="submit" class="bg-teal-600 text-white px-3 py-1 rounded text-xs font-semibold">Simpan</button>
                                    <button type="button" onclick="toggleEdit({{ $nav->menu_id }})" class="bg-gray-200 text-gray-700 px-3 py-1 rounded text-xs font-semibold">Batal</button>
                                </div>
                            </form>
                        </div>

                        {{-- Children (always render drop zone) --}}
                        <div class="child-list px-3 pb-2 pt-1 space-y-1 bg-white min-h-[8px]" data-parent="{{ $nav->menu_id }}">
                            @foreach($nav->children as $child)
                            <div class="child-item flex items-center gap-2 px-3 py-2 rounded border border-gray-100 bg-gray-50 hover:bg-gray-100 transition" data-id="{{ $child->menu_id }}">
                                <div class="drag-handle cursor-grab active:cursor-grabbing text-gray-300 flex-shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM4 11.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM4 18a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM16 5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM16 11.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM16 18a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"/>
                                    </svg>
                                </div>
                                @if($child->menu_ikon)
                                    <i data-lucide="{{ $child->menu_ikon }}" class="w-3.5 h-3.5 text-gray-400 flex-shrink-0"></i>
                                @endif
                                <span class="flex-1 text-sm text-gray-700">{{ $child->menu_label }}</span>
                                @if(!$child->menu_status)
                                    <span class="text-xs bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded-full">Nonaktif</span>
                                @endif
                                <button onclick="toggleEdit({{ $child->menu_id }})" title="Edit" class="text-gray-400 hover:text-teal-600 p-1 rounded hover:bg-teal-50 transition">
                                    <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                </button>
                                <form action="{{ route('navigations.destroy', $child) }}" method="POST" class="inline" onsubmit="return confirm('Hapus {{ $child->menu_label }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" title="Hapus" class="text-gray-400 hover:text-red-500 p-1 rounded hover:bg-red-50 transition">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </form>
                            </div>
                            {{-- Edit form child --}}
                            <div id="edit-{{ $child->menu_id }}" class="hidden px-3 py-2 border border-gray-200 rounded bg-white">
                                <form action="{{ route('navigations.update', $child) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label class="text-xs text-gray-500 mb-0.5 block">Label</label>
                                            <input type="text" name="menu_label" value="{{ $child->menu_label }}" required class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-teal-500">
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-500 mb-0.5 block">Route</label>
                                            <input type="text" name="menu_route" value="{{ $child->menu_route }}" class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-teal-500">
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-500 mb-0.5 block">Icon</label>
                                            <input type="text" name="menu_ikon" value="{{ $child->menu_ikon }}" placeholder="list" class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-teal-500">
                                        </div>
                                        <div>
                                            <label class="text-xs text-gray-500 mb-0.5 block">Status</label>
                                            <select name="menu_status" class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-teal-500">
                                                <option value="1" {{ $child->menu_status ? 'selected' : '' }}>Aktif</option>
                                                <option value="0" {{ !$child->menu_status ? 'selected' : '' }}>Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="flex gap-2 mt-2">
                                        <button type="submit" class="bg-teal-600 text-white px-3 py-1 rounded text-xs font-semibold">Simpan</button>
                                        <button type="button" onclick="toggleEdit({{ $child->menu_id }})" class="bg-gray-200 text-gray-700 px-3 py-1 rounded text-xs font-semibold">Batal</button>
                                    </div>
                                </form>
                            </div>
                            @endforeach
                        </div>

                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-400 text-sm">Belum ada menu.</div>
                    @endforelse
                </div>
                <div class="px-5 py-3 bg-gray-50 border-t border-gray-200 flex justify-end">
                    <button id="save-order-btn" onclick="saveOrderManual()"
                            class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                        Simpan Posisi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .sortable-ghost { opacity: 0.3; background: #f0fdfa; }
    .sortable-chosen { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
</style>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
function toggleEdit(id) {
    const el = document.getElementById('edit-' + id);
    el.classList.toggle('hidden');
}

function collectOrder() {
    const result = [];
    document.querySelectorAll('#menu-list > .menu-item').forEach(parent => {
        const obj = { id: parent.dataset.id, children: [] };
        const childList = parent.querySelector('.child-list');
        if (childList) {
            childList.querySelectorAll(':scope > .child-item').forEach(child => {
                obj.children.push(child.dataset.id);
            });
        }
        result.push(obj);
    });
    return result;
}

function saveOrderManual() {
    const btn = document.getElementById('save-order-btn');
    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    fetch('{{ route("navigations.reorder") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: 'items=' + encodeURIComponent(JSON.stringify(collectOrder()))
    })
    .then(r => r.json())
    .then(() => {
        btn.textContent = 'Tersimpan ✓';
        btn.classList.replace('bg-teal-600', 'bg-green-600');
        setTimeout(() => window.location.reload(), 800);
    })
    .catch(() => {
        btn.disabled = false;
        btn.textContent = 'Simpan Posisi';
    });
}

document.addEventListener('DOMContentLoaded', function () {
    // Auto-fill label dari modul
    const sel = document.getElementById('modulSelect');
    const lbl = document.getElementById('modulLabel');
    if (sel) sel.addEventListener('change', function () {
        lbl.value = this.options[this.selectedIndex].dataset.label || '';
    });

    function saveOrder() { /* perubahan menunggu simpan manual */ }

    // Parent list: items can be dragged out to child lists
    // Children promoted from child lists appear as .menu-item — we wrap them on drop
    new Sortable(document.getElementById('menu-list'), {
        group: { name: 'parents', pull: true, put: ['children'] },
        draggable: '.menu-item',
        handle: '.drag-handle',
        animation: 150,
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        // When a child-item is dropped onto the parent list, convert it to menu-item style
        onAdd: function (evt) {
            const el = evt.item;
            if (el.classList.contains('child-item')) {
                el.classList.remove('child-item');
                el.classList.add('menu-item');
                el.classList.add('rounded-lg', 'border', 'border-gray-200', 'bg-white', 'overflow-hidden');
                el.classList.remove('rounded', 'border-gray-100', 'bg-gray-50');
                // Wrap content in parent-row div and add empty child-list
                const inner = el.innerHTML;
                el.innerHTML = `<div class="flex items-center gap-2 px-3 py-2.5 bg-gray-50 hover:bg-gray-100 transition cursor-default">${inner}</div><div class="child-list px-3 pb-2 pt-1 space-y-1 bg-white min-h-[8px]" data-parent="${el.dataset.id}"></div>`;
                // Re-init child-list sortable
                initChildSortable(el.querySelector('.child-list'));
            }
            saveOrder();
        },
        onEnd: saveOrder
    });

    function initChildSortable(list) {
        new Sortable(list, {
            group: { name: 'children', pull: true, put: ['parents', 'children'] },
            draggable: '.child-item',
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            // When a .menu-item (parent) is dropped into a child list, flatten it
            onAdd: function (evt) {
                const el = evt.item;
                if (el.classList.contains('menu-item')) {
                    // Extract the inner row content (first child div)
                    const row = el.querySelector('.flex');
                    const id = el.dataset.id;
                    // Move any grandchildren back to parent list as top-level
                    const grandchildList = el.querySelector('.child-list');
                    if (grandchildList) {
                        const parentList = document.getElementById('menu-list');
                        grandchildList.querySelectorAll(':scope > .child-item').forEach(gc => {
                            gc.classList.remove('child-item');
                            gc.classList.add('menu-item', 'rounded-lg', 'border', 'border-gray-200', 'bg-white', 'overflow-hidden');
                            gc.classList.remove('rounded', 'border-gray-100', 'bg-gray-50');
                            const inner = gc.innerHTML;
                            gc.innerHTML = `<div class="flex items-center gap-2 px-3 py-2.5 bg-gray-50 hover:bg-gray-100 transition cursor-default">${inner}</div><div class="child-list px-3 pb-2 pt-1 space-y-1 bg-white min-h-[8px]" data-parent="${gc.dataset.id}"></div>`;
                            parentList.appendChild(gc);
                            initChildSortable(gc.querySelector('.child-list'));
                        });
                    }
                    // Flatten el to child-item
                    el.classList.remove('menu-item', 'rounded-lg', 'border-gray-200', 'bg-white', 'overflow-hidden');
                    el.classList.add('child-item', 'rounded', 'border-gray-100', 'bg-gray-50');
                    el.innerHTML = row ? row.innerHTML : el.innerHTML;
                }
                saveOrder();
            },
            onEnd: saveOrder
        });
    }

    // Init all existing child lists
    document.querySelectorAll('.child-list').forEach(initChildSortable);
});
</script>
@endsection
