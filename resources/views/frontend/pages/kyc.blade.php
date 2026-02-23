@extends('frontend.layouts.webLayout')
@section('title', 'Kyc - ShopX')
@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ url('/') }}" rel="nofollow">Home</a>
            <span></span> KYC Setup
        </div>
    </div>
</div>
<section class="pt-50 pb-50">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                <div class="login_wrap widget-taber-content p-30 background-white border-radius-5">
                    <div class="padding_eight_all bg-white">
                        <div class="heading_s1">
                            <h3 class="mb-30">Submit KYC Verification</h3>
                        </div>

                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form method="post" action="{{ route('vendor.kyc.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6 mb-3">
                                    <label>Full Name <span class="text-danger">*</span></label>
                                    <input required="" class="form-control" name="full_name" type="text" value="{{ old('full_name') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label>Date of Birth <span class="text-danger">*</span></label>
                                    <input required="" class="form-control" name="date_of_birth" type="date" value="{{ old('date_of_birth') }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label>Gender <span class="text-danger">*</span></label>
                                    <select class="form-control" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <label>Document Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="document_type" required>
                                        <option value="">Select Document Type</option>
                                        <option value="passport" {{ old('document_type') == 'passport' ? 'selected' : '' }}>Passport</option>
                                        <option value="driving_license" {{ old('document_type') == 'driving_license' ? 'selected' : '' }}>Driving License</option>
                                        <option value="national_id" {{ old('document_type') == 'national_id' ? 'selected' : '' }}>National ID</option>
                                        <option value="other" {{ old('document_type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12 mb-3">
                                    <label>Full Address <span class="text-danger">*</span></label>
                                    <textarea required="" class="form-control" name="full_address" rows="3">{{ old('full_address') }}</textarea>
                                </div>
                                <div class="form-group col-md-12 mb-3">
                                    <label>Document Scan Copy <span class="text-danger">*</span></label>
                                    <input required="" class="form-control" name="document_scan_copy" type="file" accept="image/*">
                                </div>
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-fill-out submit" name="submit" value="Submit">Submit KYC Verification</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection