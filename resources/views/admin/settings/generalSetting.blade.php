<div class="col-12 col-md-9 d-flex flex-column">
    <div class="card-body">
        @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <h2 class="mb-4">General Settings</h2>

        <form action="{{ route('admin.settings.general.update') }}" method="POST">
            @csrf
            @method('PUT')
            <h3 class="card-title mt-4">Site Information</h3>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="form-label required">Site Name</div>
                    <input type="text" name="site_name" class="form-control @error('site_name') is-invalid @enderror" value="{{ config('settings.site_name') }}">
                    @error('site_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <div class="form-label required">Site Email</div>
                    <input type="text" name="site_email" class="form-control @error('site_email') is-invalid @enderror" value="{{ config('settings.site_email') }}">
                    @error('site_email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <div class="form-label required">Site Phone Number</div>
                    <input type="text" name="site_phone_number" class="form-control @error('site_phone_number') is-invalid @enderror" value="{{ config('settings.site_phone_number') }}">
                    @error('site_phone_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary"> Save Settings</button>
            </div>
        </form>
    </div>
</div>