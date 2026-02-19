<div class="tab-pane fade active show" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
    <div class="card mb-20">
        <div class="card-header p-0">
            <h5>Account Details</h5>
        </div>
        <div class="card-body p-0">
            <p>Already have an account? <a href="page-login.html">Log in instead!</a></p>
            <form method="post" action="{{ route('user.account.update') }}" name="enq" class="contact-form-style"
                enctype="multipart/form-data">
                @csrf
                <div class="row mt-30">
                    <div class="col-md-12">
                        <x-input-image name="profile_picture"
                            image="{{ auth()->user()->profile_picture ? asset(auth()->user()->profile_picture) : asset('assets/imgs/avatar.png') }}" />


                    </div>
                    <div class="col-md-12">
 

                        <div class="input-style mb-20 mt-20">
                            <label>Name <span class="required">*</span></label>
                            <input required="" value="{{ auth()->user()->name }}" name="name" type="text"
                                class="square" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-style mb-20">
                            <label>Email Address <span class="required">*</span></label>
                            <input required="" value="{{ auth()->user()->email }}" name="email" type="email"
                                class="square" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />

                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit"
                            value="Submit">Save Change</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header p-0">
            <h5>Change Password</h5>
        </div>
        <div class="card-body p-0">
            <form method="post" action="{{ route('user.password.update') }}" name="enq_password"
                class="contact-form-style">
                @csrf
                <div class="row mt-30">
                    <div class="col-md-12">
                        <div class="input-style mb-20">
                            <label>Current Password <span class="required">*</span></label>
                            <input required="" name="current_password" type="password" class="square" />
                            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-style mb-20">
                            <label>New Password <span class="required">*</span></label>
                            <input required="" name="password" type="password" class="square" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-style mb-20">
                            <label>Confirm Password <span class="required">*</span></label>
                            <input required="" name="password_confirmation" type="password" class="square" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit"
                            value="Submit">Save Change</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
