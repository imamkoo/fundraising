@props([
    'label' => 'Upload Gambar',
    'name' => 'image',
    'src' => '',
    'id' => 'imageInput',
    'previewId' => 'imagePreview',
])

<div class="mt-4">
    <label for="{{ $id }}" class="block font-medium mb-2">{{ $label }}</label>
    <img id="{{ $previewId }}" src="{{ $src }}" alt="preview" class="rounded-2xl object-cover w-[90px] h-[90px] mb-2">
    <input id="{{ $id }}" class="block mt-1 w-full" type="file" name="{{ $name }}" {{ $attributes }}>
    @error($name)
        <div class="mt-2 text-red-500 text-sm">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
<script>
document.getElementById('{{ $id }}').addEventListener('change', function(e){
    if (e.target.files && e.target.files[0]) {
        let reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('{{ $previewId }}').src = ev.target.result;
        }
        reader.readAsDataURL(e.target.files[0]);
    }
});
</script>
@endpush
