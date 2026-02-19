@extends('frontend.layouts.dashboardLayout')
@section('title', 'ShopX - Orders')
@section('dashboard_content')
{{-- <H1>hELLO</H1> --}}
    @include('frontend.dashboard.components.orders')
   
@endsection
