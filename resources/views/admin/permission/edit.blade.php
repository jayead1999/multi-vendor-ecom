@extends('admin.layouts.app')

@push('title', 'Edit Permission')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Edit Permission
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="{{ route('admin.permission.index') }}" class="btn btn-secondary">
                    Back to Permissions
                </a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <form action="{{ route('admin.permission.update', $permission->id) }}" method="POST" class="card">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4 class="card-title">Permission Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Permission Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $permission->name) }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Group Name</label>
                                <input type="text" class="form-control @error('group_name') is-invalid @enderror" name="group_name" value="{{ old('group_name', $permission->group_name) }}">
                                <small class="form-hint">Used to group related permissions together in the UI.</small>
                                @error('group_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Update Permission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
