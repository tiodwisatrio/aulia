@extends('core::dashboard-layout')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Post</h1>
            <p class="text-gray-600 mt-1">{{ $post->posts_judul }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            {!! formField('posts_judul', 'text', 'Judul', $post->posts_judul, [], [
                'required' => true,
                'placeholder' => 'Masukkan judul post'
            ]) !!}

            {!! formField('posts_kategori_id', 'select', 'Kategori', $post->posts_kategori_id, $categories->pluck('kategori_nama', 'kategori_id')->toArray(), [
                'required' => true,
                'placeholder' => 'Pilih Kategori'
            ]) !!}

            {!! formCKEditor('posts_konten', 'Konten', $post->posts_konten, ['required' => true]) !!}


            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Gambar Utama</label>
                @if($post->posts_gambar_utama)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $post->posts_gambar_utama) }}" alt="{{ $post->posts_judul }}" class="h-32 w-auto rounded-lg">
                        <p class="text-xs text-gray-600 mt-2">Gambar saat ini</p>
                    </div>
                @endif
                {!! formField('posts_gambar_utama', 'file', '', null, [], [
                    'accept' => 'image/*',
                    'help' => 'Format: JPEG, PNG, JPG, GIF, WebP (Max 2MB)'
                ]) !!}
            </div>

            <div class="grid grid-cols-2 gap-6">
                {!! formField('posts_status', 'select', 'Status', $post->posts_status, ['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif'], [
                    'required' => true
                ]) !!}

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="posts_unggulan" value="1" {{ old('posts_unggulan', $post->posts_unggulan) ? 'checked' : '' }}
                            class="w-4 h-4 text-teal-600 rounded border-gray-300 focus:ring-2 focus:ring-teal-500">
                        <span class="ml-2 text-sm font-semibold text-gray-900">Tampilkan di Featured</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Perbarui Post
                </button>
                <a href="{{ route('posts.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    let editorInstance = null;

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') lucide.createIcons();

        const contentTextarea = document.querySelector('#posts_konten');
        const form = document.querySelector('form');

        if (contentTextarea && typeof ClassicEditor !== 'undefined') {
            ClassicEditor
                .create(contentTextarea, {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'blockQuote', 'bulletedList', 'numberedList', 'undo', 'redo'],
                })
                .then(editor => {
                    editorInstance = editor;
                    contentTextarea.style.display = 'none';
                    contentTextarea.removeAttribute('required');

                    if (form) {
                        form.addEventListener('submit', function(e) {
                            const editorContent = editor.getData().trim();
                            if (!editorContent) {
                                e.preventDefault();
                                alert('Konten artikel wajib diisi.');
                                editor.ui.view.editable.editable.element.focus();
                                return false;
                            }
                            contentTextarea.value = editorContent;
                            return true;
                        });
                    }
                })
                .catch(error => {
                    console.error('CKEditor error:', error);
                });
        }
    });
</script>
<style>
    .ck-editor__main { min-height: 400px !important; }
    .ck.ck-editor { width: 100% !important; }
    .ck-content { min-height: 350px !important; font-size: 14px; line-height: 1.6; }
</style>
@endpush

@endsection
