<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Default Title')</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    {{-- FAVICON --}}
    <link href="{{ asset('assets/images/favicon.ico') }}"/>

    {{-- NOUISLIDER --}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/nouislider/nouislider.min.css') }}">

    {{-- THEME CONFIG --}}
    <script src="{{ asset('assets/js/config.js') }}"></script>

    {{-- VENDOR CSS --}}
    <link href="{{ asset('assets/css/vendors.min.css') }}" rel="stylesheet" type="text/css" />

    {{-- CSS --}}
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    {{-- CUSTOM STYLES --}}
    @yield('styles')
</head>
<body>

    {{-- MAIN WRAPPER --}}
    <div class="wrapper">
        @include('layouts.client.sidebar')
        @include('layouts.client.topbar')
        @yield('content')
        @include('layouts.client.theme')
    </div>

    {{-- VENDOR JS --}}
    <script src="{{ asset('assets/js/vendors.min.js') }}"></script>

    {{-- APP JS --}}
    <script src="{{ asset('assets/js/app.js') }}"></script>

    {{-- NOUISLIDER --}}
    <script src="{{ asset('assets/plugins/nouislider/nouislider.min.js') }}"></script>

    {{-- ECOMMERCE PRODUCTS --}}
    <script src="{{ asset('assets/js/pages/ecommerce-products.js') }}"></script>

    {{-- YIELD SCRIPT --}}
    @yield('scripts')
</body>
</html>