@extends('admin.layouts.app')

@push('title', 'View KYC Request')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">

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

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">KYC Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="datagrid">
                            <div class="datagrid-item">
                                <div class="datagrid-title">User Name</div>
                                <div class="datagrid-content">{{ $kycRequest->user->name ?? 'N/A' }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Full Name</div>
                                <div class="datagrid-content">{{ $kycRequest->full_name }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Email</div>
                                <div class="datagrid-content">{{ $kycRequest->user->email ?? 'N/A' }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Date of Birth</div>
                                <div class="datagrid-content">{{ $kycRequest->date_of_birth }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Gender</div>
                                <div class="datagrid-content text-capitalize">{{ $kycRequest->gender }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Status</div>
                                <div class="datagrid-content">
                                    <span class="badge {{ $kycRequest->status == 'approved' ? 'bg-success' : ($kycRequest->status == 'rejected' ? 'bg-danger' : 'bg-warning') }} text-white text-capitalize">
                                        {{ $kycRequest->status }}
                                    </span>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Submitted At</div>
                                <div class="datagrid-content">{{ $kycRequest->created_at->format('d M Y, h:i A') }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Full Address</div>
                                <div class="datagrid-content">{{ $kycRequest->full_address }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Document Type</div>
                                <div class="datagrid-content text-capitalize">{{ str_replace('_', ' ', $kycRequest->document_type) }}</div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h4 class="mb-3">Submitted Document</h4>
                            @if($kycRequest->document_scan_copy)
                            <a href="{{ asset('storage/' . $kycRequest->document_scan_copy) }}" target="_blank">
                                <img src="{{ asset('storage/' . $kycRequest->document_scan_copy) }}" alt="Document Scan Copy" class="img-fluid rounded border" style="max-height: 400px; width: 100%; object-fit: contain;">
                            </a>
                            @else
                            <div class="text-secondary">No document uploaded.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Actions</h3>
                    </div>
                    <div class="card-body">
                        @if($kycRequest->status == 'pending')

                        <a href="{{ route('admin.kyc.request.approve', $kycRequest->id) }}" class="btn btn-success w-100 mb-3" onclick="return confirm('Are you sure you want to approve this request?')">
                            Approve Request
                        </a>

                        <hr>

                        <h4 class="mb-3 text-warning">Reject Request</h4>
                        <form action="{{ route('admin.kyc.request.reject', $kycRequest->id) }}" method="POST" class="mb-3">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Reason for Rejection <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="rejected_reason" rows="3" required placeholder="Enter the reason here..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-warning w-100">Reject Request</button>
                        </form>

                        <hr>

                        <h4 class="mb-3 text-danger">Delete Request</h4>
                        <form action="{{ route('admin.kyc.request.delete', $kycRequest->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Are you sure you want to permanently delete this request?')">
                                Delete Request
                            </button>
                        </form>

                        @else
                        <div class="alert alert-info py-2">
                            This request is currently marked as <strong>{{ $kycRequest->status }}</strong>. Action can no longer be taken.
                        </div>

                        @if($kycRequest->status == 'rejected')
                        <div class="mb-3">
                            <strong>Rejected Reason:</strong>
                            <p class="text-secondary mt-1">{{ $kycRequest->rejected_reason }}</p>
                        </div>
                        @endif

                        <hr>

                        <h4 class="mb-3 text-danger">Delete Request</h4>
                        <form action="{{ route('admin.kyc.request.delete', $kycRequest->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Are you sure you want to permanently delete this request?')">
                                Delete Request
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection