<!DOCTYPE html>
<html lang="en">

<head>
    <base href="" />
    <title>{{ $title ? $title . ' | ' . config('app.name') : config('app.name') }}</title>
    <meta charset="utf-8" />
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <meta name="description" content="Portal Bansos." />
    <meta name="keywords" content="bantuan sosial, bansos, subsidi, bank-dki, dki, bank" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ config('app.name') }} | Portal Bansos" />
    <meta property="og:url" content="http://localhost" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />
    @include('layouts.styles')
    @yield('styles')

    <script src="{{ asset('js/theme.js') }}" defer></script>
</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">


    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                @include('layouts.header')
                @yield('content')
                @include('layouts.footer')
            </div>
        </div>
    </div>
    @include('layouts.scripts')
    @include('layouts.loading-dialog')
    @include('layouts.alert-dialog')

    @yield('scripts')

</body>

</html>
