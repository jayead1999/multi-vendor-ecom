@extends('admin.layouts.app')

@push('title', 'Kyc Request')

@section('content')
<div class="page-body">
    <div class="container">
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.kyc.request') }}" method="GET" class="d-flex gx-2 align-items-center">
                        <label class="form-label me-2 mb-0">Filter by Status:</label>
                        <select name="status" class="form-select w-auto me-2">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Requests</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped">
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Full Name</th>
                                <th>Document Type</th>
                                <th>Status</th>
                                <th>Submitted At</th>
                                <th class="w-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kycRequests as $kyc)
                            <tr>
                                <td>{{ $kyc->user->name ?? 'N/A' }}</td>
                                <td class="text-secondary">{{ $kyc->full_name }}</td>
                                <td class="text-secondary text-capitalize">{{ str_replace('_', ' ', $kyc->document_type) }}</td>
                                <td>
                                    <span class="badge {{ $kyc->status == 'approved' ? 'bg-success' : ($kyc->status == 'rejected' ? 'bg-danger' : 'bg-warning') }} text-white text-capitalize">
                                        {{ $kyc->status }}
                                    </span>
                                </td>
                                <td class="text-secondary">{{ $kyc->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="{{ route('admin.kyc.request.show', $kyc->id) }}">
                                                View
                                            </a>

                                            @if($kyc->status == 'pending')
                                            <a class="dropdown-item text-success" href="{{ route('admin.kyc.request.approve', $kyc->id) }}" onclick="return confirm('Are you sure you want to approve this request?')">
                                                Approve
                                            </a>
                                            <a class="dropdown-item text-warning" href="#" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $kyc->id }}">
                                                Reject
                                            </a>
                                            @endif

                                            <form action="{{ route('admin.kyc.request.delete', $kyc->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this request?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    @if($kyc->status == 'pending')
                                    <!-- Reject Modal -->
                                    <div class="modal modal-blur fade" id="rejectModal{{ $kyc->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.kyc.request.reject', $kyc->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Reject KYC Request</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Reason for rejection <span class="text-danger">*</span></label>
                                                            <textarea class="form-control" name="rejected_reason" rows="3" required placeholder="Enter the reason for rejecting this KYC request..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-warning">Reject Request</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No KYC requests found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($kycRequests->hasPages())
                <div class="card-footer d-flex align-items-center">
                    {{ $kycRequests->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection