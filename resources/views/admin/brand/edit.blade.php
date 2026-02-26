@extends('admin.layouts.app')

@push('title', 'Edit Brand')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Brand: {{ $brand->name }}</h5>
                    <a href="{{ route('admin.brand.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Back to Brands</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.brand.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Brand Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $brand->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                            <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $brand->slug) }}" required>
                            @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="imag" class="form-label">Brand Image</label>
                            <input type="file" name="imag" id="imag" class="form-control @error('imag') is-invalid @enderror" accept="image/*">
                            @error('imag')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if($brand->imag)
                            <div class="mt-2">
                                <p class="mb-1 text-muted">Current Image:</p>
                                <img src="{{ asset($brand->imag) }}" alt="Current Image" style="max-height: 100px; border-radius: 5px; border: 1px solid #ddd;">
                            </div>
                            @endif
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $brand->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Active</label>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update Brand</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection