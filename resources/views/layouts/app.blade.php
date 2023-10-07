<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ env('APP_URL') }}/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ env('APP_URL') }}/assets/img/favicon.png">
    <title>
        {{ env('APP_NAME') }} :: @yield('title')
    </title>
    @include('includes.styles')
</head>

<body class="g-sidenav-show bg-gray-100">
    <div id="loader">
        <div class="spinner"></div>
    </div>
    @yield('content')
</body>
@include('includes.scripts')
@yield('custom-script')

</html>
