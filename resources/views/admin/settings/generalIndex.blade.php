@extends('admin.layouts.app')

@push('title', 'General Settings')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Settings
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="row g-0">
                @include('admin.settings.settingSidebar')
                @include('admin.settings.generalSetting')
            </div>
        </div>
    </div>
</div>
@endsection

