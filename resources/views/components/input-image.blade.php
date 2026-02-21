@props(['id', 'name', 'image'])
<div

    {{-- id="{{ $id }}" --}}
    id="image-preview"
    style="background-image:url({{ $image }}); background-size: cover; background-position: center;"
    class="image-preview">
    <label for="image-upload" id="image-label">Choose File</label>
    <input type="file" name="{{ $name }}" id="image-upload" />
</div>