<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ $web_source }}/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ $web_source }}/assets/img/favicon.png">
    <title>
        {{ env('APP_NAME') }} :: @yield('title')
    </title>
    @include('includes.styles')
</head>

<body class="g-sidenav-show bg-gray-100">
    <div id="loader">
        <div class="spinner"></div>
    </div>
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    @include('includes.sideBar')
    @yield('content')
    <div class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="fa fa-cog py-2"> </i>
        </a>
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3 ">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">{{ env('APP_NAME') }}</h5>
                    <p>See our dashboard options.</p>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="horizontal dark my-1">
            <div class="card-body pt-sm-3 pt-0 overflow-auto">
                <!-- Sidebar Backgrounds -->
                <div>
                    <h6 class="mb-0">Layout Settings</h6>
                </div>
                <!-- Sidenav Type -->
                <hr class="horizontal dark my-sm-4">
                <div class="mt-2 mb-5 d-flex">
                    <h6 class="mb-0">Light / Dark</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version"
                            onclick="darkMode(this)">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ $web_source }}/assets/js/core/popper.min.js"></script>
    <script src="{{ $web_source }}/assets/js/core/bootstrap.min.js"></script>
    <script src="{{ $web_source }}/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ $web_source }}/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="{{ $web_source }}/assets/js/plugins/chartjs.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ $web_source }}/assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

@include('includes.scripts')
@yield('custom-script')

</html>
