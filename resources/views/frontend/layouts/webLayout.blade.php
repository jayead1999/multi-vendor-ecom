<!DOCTYPE html>
<html class="no-js" lang="en">

@include('frontend.layouts.components.head')

<body>
    <!-- Quick view -->
    @include('frontend.layouts.components.quickview')
    
    <!-- Header  -->
    @include('frontend.layouts.components.header')

   <!-- Mobile Header -->
   @include('frontend.layouts.components.mobile_header')


    <main class="main">
        @yield('content')
    </main>


    @include('frontend.layouts.components.footer')

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
    @include('frontend.layouts.components.script')
</body>

</html>
