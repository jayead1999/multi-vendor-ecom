<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@stack('title')</title>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" href="{{ asset('assets/global/plugin/upload-preview.css') }}" />

    <link href="{{ asset('assets/admin/css/tabler.css') }}" rel="stylesheet" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@v3.37.1/dist/tabler-icons.min.css" />
    <style>
        @import url("https://rsms.me/inter/inter.css");
    </style>
    <!-- END CUSTOM FONT -->

    {{ $slot ?? '' }}
</head>
