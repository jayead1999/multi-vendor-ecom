@extends('admin.layouts.app')

@push('title', 'Admin Users Setup')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Assign Roles (Admins)
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('admin.role-user.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Create admin user
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="col-12">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        {{ session('success') }}
                    </div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
            @endif

            <div class="card">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th class="w-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($users))
                            @forelse($users as $user)
                            <tr>
                                <td class="text-secondary">{{ $user->name }}</td>
                                <td class="text-secondary">{{ $user->email }}</td>
                                <td class="text-secondary">
                                    <span class="badge bg-primary-lt">{{ implode(', ', $user->getRoleNames()->toArray()) ?: 'No Role' }}</span>
                                </td>
                                <td class="text-secondary">{{ $user->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="{{ route('admin.role-user.edit', $user->id) }}">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.role-user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this user completely?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No other admin users found.</td>
                            </tr>
                            @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>

                @if(isset($users) && $users->hasPages())
                <div class="card-footer d-flex align-items-center">
                    {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection