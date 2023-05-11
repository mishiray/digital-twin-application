@extends('layouts.app')
@section('title')
    Register
@endsection
@section('content')
    <!-- End Navbar -->
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
            style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signup-cover.jpg'); background-position: top;">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <h1 class="text-white mb-2 mt-5">Welcome!</h1>
                        <p class="text-lead text-white">Join our digital twin framework by registering today! As a member,
                            you'll get access to features, resources, and a community of users to help you get the most out
                            of your digital twin. Sign up now to start experiencing the full benefits of our framework.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-body">
                            <form id="first_form" role="form">
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="name" placeholder="Name"
                                        aria-label="Name">
                                    <span class="error d-none" id="name_err"></span>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="phone" placeholder="Phone Number"
                                        aria-label="Phone Number">
                                    <span class="error d-none" id="phone_err"></span>
                                </div>
                                <div class="mb-3">
                                    <input type="email" id="email" class="form-control" placeholder="Email"
                                        aria-label="Email">
                                    <span class="error d-none" id="email_err"></span>
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control" id="password" placeholder="Password"
                                        aria-label="Password">
                                    <span class="error d-none" id="password_err"></span>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Sign up</button>
                                    <span class="error d-none" id="submit_err"></span>
                                </div>
                                <p class="text-sm mt-3 mb-0">Already have an account? <a href="{{ route('login') }}"
                                        class="text-primary loader-link font-weight-bolder">Sign in</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row">
                <div class="col-8 mx-auto text-center mt-1">
                    <p class="mb-0 text-secondary">
                        Copyright ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script> <br> Mishael Abiola <br> 170805523
                    </p>
                </div>
            </div>
        </div>
    </footer>
@endsection

@section('custom-script')
    <script>
        let email_check = false,
            phone_check = false,
            password_check = false,
            name_check = false
        $("#email").on("input", function() {
            $('#email_err').html('');
            $('#email_err').addClass('d-none');
            var email = this.value;
            if (email.length < 1) {
                email_check = false;
                $('#email_err').removeClass('d-none');
                $('#email_err').html('This field is required');
            } else {
                var regEx = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            var validEmail = regEx.test(email);
            if (!validEmail) {
                email_check = false;
                $('#email_err').removeClass('d-none');
                $('#email_err').html('Enter a valid email');
            }
        }
        email_check = true;
    });
    $("#name").on("input", function() {
        $('#name_err').html('');
        $('#name_err').addClass('d-none');
        var name = this.value;
        if (name.length < 1) {
            name_check = false;
            $('#name_err').removeClass('d-none');
            $('#name_err').html('This field is required');
        }
        name_check = true;
    });
    $("#phone").on("input", function() {
        $('#phone_err').html('');
        $('#phone_err').addClass('d-none');
        var phone = this.value;
        if (phone.length < 1) {
            phone_check = false
            $('#phone_err').removeClass('d-none');
            $('#phone_err').html('This field is required');
        }
        phone_check = true;
    });
    $("#password").on("input", function() {
        $('#password_err').html('');
        $('#password_err').addClass('d-none');
        var password = this.value;
        if (password.length < 8) {
            password_check = false
            $('#password_err').removeClass('d-none');
            $('#password_err').html('This field must contain at least 8 characters');
        } else {
            var regEx = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,15}$/;
            var validPassword = regEx.test(password);
            if (!validPassword) {
                $('#password_err').removeClass('d-none');
                password_check = false
                $('#password_err').html(
                    'Password must be between 8 to 15 characters, which contain at least one lowercase letter, one uppercase letter, one digit'
                );
            }
        }
        password_check = true
    });


    $('#first_form').submit(function(e) {
        e.preventDefault();
        $('#submit_err').html('');
        $('#submit_err').addClass('d-none');
        if (email_check === true && name_check === true && password_check === true && phone_check === true) {

            var phone = $('#phone').val();
            var name = $('#name').val();
            var email = $('#email').val().trim();
            var password = $('#password').val();

            let jsonData = {
                'name': name,
                'phoneNumber': phone,
                'email': email,
                'password': password,
                'roleName': "User"
            }

            $.ajax({
                url: `{{ env('API_URL') }}Users/create`,
                    type: 'POST',
                    data: JSON.stringify(jsonData),
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        toastr.success('Registration successful, Please Login with credentials');
                        var _userResponse = JSON.parse(response.responseText)
                        console.log(_userResponse)
                    },
                    error: function(xhr, status, error) {
                        var _error = JSON.parse(xhr.responseText).errors
                        _error.map(e => {
                            toastr.error(e.errorMessages.toString());
                        })
                    }
                });

            } else {
                toastr.error(
                    'One or more validation errors occured'
                );
            }
        });

    </script>
@endsection
