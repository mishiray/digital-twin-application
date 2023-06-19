<script src="https://kit.fontawesome.com/3950222864.js" crossorigin="anonymous"></script>
<!--   Core JS Files   -->
<script src="{{ $web_source }}/assets/js/core/popper.min.js"></script>
<script src="{{ $web_source }}/assets/js/core/bootstrap.min.js"></script>
<script src="{{ $web_source }}/assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="{{ $web_source }}/assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="{{ $web_source }}/assets/js/plugins/chartjs.min.js"></script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ $web_source }}/assets/js/argon-dashboard.min.js?v=2.0.4"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>

<script>
    function padTo2Digits(num) {
        return num.toString().padStart(2, '0');
    }

    function formatDate(date) {
        return (
            [
                date.getFullYear(),
                padTo2Digits(date.getMonth() + 1),
                padTo2Digits(date.getDate()),
            ].join('-') +
            'T' + [
                padTo2Digits(date.getHours()),
                padTo2Digits(date.getMinutes()),
                padTo2Digits(date.getSeconds()),
            ].join(':')
        );
    }

    @if (Session::has('message'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.success("{{ session('message') }}");
    @endif

    @if (Session::has('error'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.error("{{ session('error') }}");
    @endif

    @if (Session::has('info'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.info("{{ session('info') }}");
    @endif

    @if (Session::has('warning'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.warning("{{ session('warning') }}");
    @endif

    // Add event listeners to all links and forms that will trigger the loader
    document.querySelectorAll('.loader-link, .loader-form').forEach(function(element) {
        element.addEventListener('click', function() {
            document.getElementById('loader').style.display = 'block';
        });
    });

    // Hide the loader when the page is fully loaded
    window.addEventListener('load', function() {
        document.getElementById('loader').style.display = 'none';
    });
</script>
