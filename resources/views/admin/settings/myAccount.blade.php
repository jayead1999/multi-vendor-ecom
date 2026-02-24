<div class="col-12 col-md-9 d-flex flex-column">
                    <div class="card-body">
                        @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        <h2 class="mb-4">My Account</h2>

                        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <h3 class="card-title">Profile Details</h3>
                            <div class="row align-items-center mb-4">
                                <div class="col-auto">
                                    <span class="avatar avatar-xl" id="image-preview" style="background-image: url('{{ auth('admin')->user()->profile_picture ? asset(auth('admin')->user()->profile_picture) : asset('assets/imgs/avatar.jpeg') }}')"></span>
                                </div>
                                <div class="col-auto">
                                    <input type="file" id="image-upload" name="profile_picture" class="form-control" accept="image/*">
                                </div>
                            </div>
                            @error('profile_picture')
                            <div class="text-danger small mb-3">{{ $message }}</div>
                            @enderror

                            <h3 class="card-title mt-4">Personal Information</h3>
                            <div class="row g-3 mb-4">
                                <div class="col-md">
                                    <div class="form-label required">Name</div>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth('admin')->user()->name) }}">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md">
                                    <div class="form-label required">Username</div>
                                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', auth('admin')->user()->username) }}">
                                    @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <h3 class="card-title mt-4">Email</h3>
                            <p class="card-subtitle">This contact will be shown to others publicly, so choose it carefully.</p>
                            <div class="mb-4">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <input type="email" name="email" class="form-control w-auto @error('email') is-invalid @enderror" value="{{ old('email', auth('admin')->user()->email) }}">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Submit Changes</button>
                            </div>
                        </form>

                        <hr class="my-5">

                        <form action="{{ route('admin.settings.update-password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <h3 class="card-title">Password</h3>
                            <p class="card-subtitle">You can set a permanent password if you don't want to use temporary login codes.</p>

                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <div class="form-label required">Current Password</div>
                                    <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                                    @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="form-label required">New Password</div>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="form-label required">Confirm Password</div>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Update Password</button>
                            </div>
                        </form>

                    </div>
                </div>