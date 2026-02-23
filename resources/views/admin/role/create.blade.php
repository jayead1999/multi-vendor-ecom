@extends('admin.layouts.app')

@push('title', 'Create Role')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Create New Role
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="{{ route('admin.role') }}" class="btn btn-secondary">
                    Back to Roles
                </a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <form action="{{ route('admin.role.store') }}" method="POST" class="card">
                    @csrf
                    <div class="card-header">
                        <h4 class="card-title">Role Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required">Role Name</label>
                            <input type="text" class="form-control" name="name" placeholder="E.g. Super Admin" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Permissions</label>
                            @foreach ($permissions as $groupName => $permission)
                                <div class="mb-3">
                                    <label class="form-label">{{ $groupName }}</label>
                                    @foreach ($permission as $item)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $item->name }}">
                                            <label class="form-check-label">{{ $item->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Create Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection