<!DOCTYPE html>
<html class="no-js" lang="en">

@include('frontend.body.head')

<body>
    <!-- Quick view -->
    @include('frontend.body.quickview')
    
    <!-- Header  -->
    @include('frontend.body.header')

   <!-- Mobile Header -->
   @include('frontend.body.mobile_header')


    <main class="main">
        @yield('content')
    </main>


    @include('frontend.body.footer')

    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src="{{ asset('assets/frontend/imgs/theme/loading.gif') }}" alt="" />
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor JS-->
    @include('frontend.body.script')
</body>

</html>
