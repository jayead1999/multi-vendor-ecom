@extends('vendor_user.layouts.app')

@push('title', 'Store Profile')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Store Profile
                </h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <div class="d-flex">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l5 5l10 -10" />
                    </svg>
                </div>
                <div>{{ session('success') }}</div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
        @endif

        @if($store)
        <!-- Visual Store Preview -->
        <div class="card mb-3">
            <div class="card-img-top img-responsive img-responsive-21x9" style="background-image: url('{{ asset('storage/' . $store->banner) }}'); height: 250px; background-size: cover; background-position: center; border-radius: 4px 4px 0 0;"></div>
            <div class="card-body position-relative">
                <div class="d-flex flex-column flex-md-row align-items-center mb-4" style="margin-top: -60px;">
                    <span class="avatar avatar-xl rounded-circle me-md-4 mb-3 mb-md-0 shadow bg-white p-1" style="background-image: url('{{ asset('storage/' . $store->logo) }}'); width: 120px; height: 120px; border: 4px solid #fff; z-index: 1; background-size: cover; background-position: center;"></span>
                    <div class="text-center text-md-start pt-md-4">
                        <h2 class="m-0 mb-1" style="font-size: 1.5rem;">{{ $store->store_name }}</h2>
                        <div class="text-secondary text-truncate" style="max-width: 400px;" title="{{ $store->short_description }}">
                            @if($store->short_description) {{ $store->short_description }} @else <i>No short description available.</i> @endif
                        </div>
                    </div>
                </div>

                <div class="row gx-4 gy-3">
                    <div class="col-md-6 col-lg-4">
                        <div class="d-flex align-items-center">
                            <span class="bg-primary text-white avatar me-3 rounded-circle shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                </svg>
                            </span>
                            <div>
                                <div class="text-secondary small text-uppercase fw-bold">Phone Number</div>
                                <div class="fs-4">{{ $store->store_phone ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="d-flex align-items-center">
                            <span class="bg-azure text-white avatar me-3 rounded-circle shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                    <path d="M3 7l9 6l9 -6" />
                                </svg>
                            </span>
                            <div>
                                <div class="text-secondary small text-uppercase fw-bold">Email Address</div>
                                <div class="fs-4">{{ $store->store_email ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <h4 class="mb-2">About Our Store</h4>
                        <div class="text-secondary bg-light p-3 rounded" style="white-space: pre-line;">{{ $store->long_description ?? 'No detailed description provided.' }}</div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- No Store Banner Alert -->
        <div class="alert alert-info" role="alert">
            <h4 class="alert-title">Welcome!</h4>
            <div class="text-secondary">Please fill in the form below to initiate your store setup. Once complete, you will be able to see a beautiful visual preview of your store up here.</div>
        </div>
        @endif

        <!-- Edit / Create Form -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $store ? 'Update Profile Data' : 'Setup Your Store' }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('vendor.store.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Store Name</label>
                            <input type="text" class="form-control @error('store_name') is-invalid @enderror" name="store_name" value="{{ old('store_name', $store->store_name ?? '') }}" placeholder="Enter store name" required>
                            @error('store_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Store Phone Number</label>
                            <input type="text" class="form-control" name="store_phone" value="{{ old('store_phone', $store->store_phone ?? '') }}" placeholder="e.g. +1 234 567 8900">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Store Email</label>
                            <input type="email" class="form-control @error('store_email') is-invalid @enderror" name="store_email" value="{{ old('store_email', $store->store_email ?? '') }}" placeholder="contact@mystore.com">
                            @error('store_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Store Short Description</label>
                            <input type="text" class="form-control" name="short_description" value="{{ old('short_description', $store->short_description ?? '') }}" placeholder="A tagline or brief summary.">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Store Logo (Image)</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" accept="image/*">
                            <small class="form-hint">Format: JPG, PNG, WEBP. Max size: 2MB. Square image is recommended.</small>
                            @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Store Banner (Image)</label>
                            <input type="file" class="form-control @error('banner') is-invalid @enderror" name="banner" accept="image/*">
                            <small class="form-hint">Format: JPG, PNG, WEBP. Max size: 4MB. Ratio: 21:9 or 16:9 is recommended.</small>
                            @error('banner')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Store Long Description</label>
                            <textarea class="form-control" name="long_description" rows="5" placeholder="Detailed description of what your store provides to customers...">{{ old('long_description', $store->long_description ?? '') }}</textarea>
                        </div>
                    </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary bg-primary w-25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l5 5l10 -10" />
                    </svg>
                    {{ $store ? 'Save Changes' : 'Create Store' }}
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection