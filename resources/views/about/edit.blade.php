@extends('core::dashboard-layout')

@section('header')
    Edit About Page
@endsection

@section('content')
<x-forms.crud-form 
    title="Edit About Page"
    :action="route('abouts.update', $about->id)"
    method="POST"
    submit-text="Update About Page"
    :cancel-url="route('abouts.index')"
    enctype="multipart/form-data">

    @method('PUT')

    <!-- Basic Information Section -->
    <x-forms.form-section title="About Information">
        <div class="grid grid-cols-1 gap-6">
            <x-forms.form-input 
                name="title"
                label="Title"
                icon="type"
                placeholder="Enter about title"
                :required="true"
                value="{{ old('title', $about->title) }}" />

            <x-forms.form-input 
                name="content"
                label="Content"
                type="textarea"
                icon="file-text"
                placeholder="Write about page content..."
                :rows="6"
                :required="true"
                value="{{ old('content', $about->content) }}"
                help="You can use basic formatting or a WYSIWYG editor if integrated." />
        </div>
    </x-forms.form-section>

    <!-- Image Upload Section -->
    <x-forms.form-section title="Featured Image (Optional)">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <!-- Preview container -->
                <div class="mb-4 relative" id="image-preview-container">
                    <p class="text-sm text-gray-700 font-medium mb-2">Image Preview:</p>
                    <button type="button" id="remove-preview" class="absolute top-0 right-0 text-white bg-red-600 hover:bg-red-700 rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold shadow">
                        ×
                    </button>
                    <img id="image-preview" src="{{ $about->image ? asset('storage/' . $about->image) : '#' }}" 
                         alt="About Image" class="h-40 w-auto rounded-lg shadow-sm border border-gray-200">
                </div>

                <x-forms.form-input 
                    name="image"
                    label="Change Image"
                    type="file"
                    icon="image"
                    accept="image/*"
                    placeholder="Upload new image"
                    help="Selecting a new image will replace the current one (max 2MB)" />
            </div>
        </div>
    </x-forms.form-section>

</x-forms.crud-form>
@endsection

@push('scripts')
<script>
    lucide.createIcons();

    document.addEventListener("DOMContentLoaded", function () {
        const imageInput = document.querySelector('input[name="image"]');
        const previewImage = document.getElementById('image-preview');
        const removePreviewBtn = document.getElementById('remove-preview');

        // Simpan src gambar lama
        const oldSrc = previewImage.src;

        // Event: pilih file baru
        if(imageInput){
            imageInput.addEventListener('change', function(e){
                const file = e.target.files[0];
                if(file){
                    const reader = new FileReader();
                    reader.onload = function(event){
                        previewImage.src = event.target.result; // ganti preview dengan file baru
                    }
                    reader.readAsDataURL(file);
                } else {
                    previewImage.src = '#'; // kosongkan preview jika tidak ada file
                }
            });
        }

        // Event: hapus preview / gambar
        if(removePreviewBtn){
            removePreviewBtn.addEventListener('click', function(){
                imageInput.value = '';          // hapus input file
                previewImage.src = '#';          // kosongkan preview
                // Tambahkan hidden input agar backend tahu hapus gambar lama
                let form = imageInput.closest('form');
                if(!form.querySelector('input[name="remove_current_image"]')){
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'remove_current_image';
                    input.value = '1';
                    form.appendChild(input);
                }
            });
        }
    });
</script>
@endpush
