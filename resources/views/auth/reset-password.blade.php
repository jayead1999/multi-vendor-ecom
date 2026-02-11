{{-- <x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

@extends('frontend.layouts.webLayout')
@section('title', 'ShopX - Login')
@section('content')

    <x-frontend.breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Login', 'url' => route('login')]]" />

    <!-- Login Start    -->
    <div class="page-content pt-150 pb-135">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                    <div class="row">
                        <div class="col-lg-6 pr-30 d-none d-lg-block">
                            <img class="border-radius-15" src="assets/imgs/page/login-1.png" alt="" />
                        </div>
                        <div class="col-lg-6 col-md-8">
                            <div class="login_wrap widget-taber-content background-white">
                                <div class="padding_eight_all bg-white">
                                    <div class="heading_s1">
                                        <h1 class="mb-5">Reset Password</h1>
                                        <p class="mb-30">Go to home page <a href="{{ route('home') }}">Home</a></p>
                                    </div>
                                    <form method="post" action="{{ route('password.store') }}">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                        <div class="form-group">
                                            <input type="text" required id="email" name="email" value="{{ old('email', $request->email) }}"
                                                placeholder=" Email *" />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />

                                        </div>
                                        <div class="form-group">
                                            <input required="" type="password" name="password" id="password"
                                                placeholder="Your password *" />
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />

                                        </div>
                                        {{-- password_confirmation --}}
                                        <div class="form-group">
                                            <input required="" type="password" name="password_confirmation" id="password_confirmation"
                                                placeholder="Confirm your password *" />
                                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                                        </div>

                                       
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-heading btn-block hover-up"
                                                name="login">Reset Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
