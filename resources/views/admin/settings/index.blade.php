@extends('admin.layouts.app')

@push('title', 'Settings')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Settings
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="row g-0">
                @include('admin.settings.settingSidebar')
                @include('admin.settings.myAccount')
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var imageUpload = document.getElementById('image-upload');
        var imagePreview = document.getElementById('image-preview');

        if (imageUpload) {
            imageUpload.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    var file = this.files[0];

                    if (file.type.match('image')) {
                        var reader = new FileReader();
                        reader.addEventListener('load', function(e) {
                            imagePreview.style.backgroundImage = 'url(' + e.target.result + ')';
                            imagePreview.style.backgroundSize = 'cover';
                            imagePreview.style.backgroundPosition = 'center center';
                        });
                        reader.readAsDataURL(file);
                    } else {
                        alert('Please select an image file.');
                    }
                } else {
                    imagePreview.style.backgroundImage = 'url({{ auth("admin")->user()->profile_picture ? asset(auth("admin")->user()->profile_picture) : asset("assets/imgs/avatar.jpeg") }})';
                }
            });
        }
    });
</script>
@endpush