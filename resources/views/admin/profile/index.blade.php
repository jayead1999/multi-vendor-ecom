@extends('admin.layouts.app')

@push('title', 'Admin - Admin Profile')

@section('content')
<!-- Profile Update Form -->
<div class="container-xl">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Update Profile</h3>
        </div>
        <div class="card-body">
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-3">
                        {{-- Image --}}
                        <div class="col-md-3">
                            <x-input-image name="profile_picture"
                                image="{{ auth()->user()->profile_picture ? asset(auth()->user()->profile_picture) : asset('assets/imgs/avatar.jpeg') }}" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Name --}}

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label required" for="name">Name</label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <!-- SVG icon: user -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                    </svg>
                                </span>
                                <input type="text" id="name" name="name" class="form-control"
                                    placeholder="Enter your name" value="{{ auth('admin')->user()->name ?? '' }}">
                            </div>
                            @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label required" for="email">Email</label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <!-- SVG icon: mail -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path
                                            d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z">
                                        </path>
                                        <path d="M3 7l9 6l9 -6"></path>
                                    </svg>
                                </span>
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="Enter your email" value="{{ auth('admin')->user()->email ?? '' }}">
                            </div>
                            @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            Update Profile
                            <!-- SVG icon: arrow-right -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-right icon-2">
                                <path d="M5 12l14 0"></path>
                                <path d="M13 18l6 -6"></path>
                                <path d="M13 6l6 6"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Password Update Form -->
<div class="container-xl mt-4">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Update Password</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.update.password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    {{-- Old Password --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label required" for="current_password">Old Password</label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <!-- SVG icon: lock -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path
                                            d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z">
                                        </path>
                                        <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0"></path>
                                        <path d="M8 11v-4a4 4 0 1 1 8 0v4"></path>
                                    </svg>
                                </span>
                                <input type="password" id="current_password" name="current_password"
                                    class="form-control" placeholder="Enter old password">
                            </div>
                            @error('current_password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- New Password --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label required" for="password">New Password</label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <!-- SVG icon: lock -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path
                                            d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z">
                                        </path>
                                        <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0"></path>
                                        <path d="M8 11v-4a4 4 0 1 1 8 0v4"></path>
                                    </svg>
                                </span>
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Enter new password">
                            </div>
                            @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label required" for="password_confirmation">Confirm Password</label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <!-- SVG icon: lock-check -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path
                                            d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z">
                                        </path>
                                        <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0"></path>
                                        <path d="M8 11v-4a4 4 0 1 1 8 0v4"></path>
                                    </svg>
                                </span>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control" placeholder="Confirm new password">
                            </div>
                            @error('password_confirmation')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            Update Password
                            <!-- SVG icon: arrow-right -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="icon icon-right icon-2">
                                <path d="M5 12l14 0"></path>
                                <path d="M13 18l6 -6"></path>
                                <path d="M13 6l6 6"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
{{-- image upload preview (vanilla JS - no jQuery needed) --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var imageUpload = document.getElementById('image-upload');
        var imagePreview = document.getElementById('image-preview');
        var imageLabel = document.getElementById('image-label');

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

                        if (imageLabel) {
                            imageLabel.textContent = 'Change File';
                        }
                    } else {
                        alert('Please select an image file.');
                    }
                } else {
                    if (imageLabel) {
                        imageLabel.textContent = 'Choose File';
                    }
                    imagePreview.style.backgroundImage = 'none';
                }
            });
        }
    });
</script>
@endpush