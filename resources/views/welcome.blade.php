@extends('layouts.app')
@section('title')
    Login
@endsection
@section('content')
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-8 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h1 class="font-weight-bolder">Resource Manager Login</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Sign In</h4>
                                    <p class="mb-0">Enter your email and password to sign in</p>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('authenticate') }}" id="login_form" method="POST"
                                        role="form">
                                        @csrf @method('POST')
                                        <div class="mb-3">
                                            <input type="email" id="email" name="email"
                                                class="form-control form-control-lg" required placeholder="Email"
                                                aria-label="Email">
                                        </div>
                                        <div class="mb-3">
                                            <input type="password" id="password" name="password"
                                                class="form-control form-control-lg" required placeholder="Password"
                                                aria-label="Password">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn loader-link btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign
                                                in</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-sm mx-auto">
                                        Don't have an account?
                                        <a href="{{ route('register') }}"
                                            class="text-primary loader-link text-gradient font-weight-bold">Sign
                                            up</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg');
          background-size: cover;">
                                <span class="mask bg-gradient-primary opacity-6"></span>
                                <h4 class="mt-5 text-white font-weight-bolder position-relative">"Digital Twin Technology"
                                </h4>
                                <p class="text-white position-relative">"... are not just a technological revolution, but a
                                    new way of thinking about innovation and collaboration."</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@section('custom-script')
    <script>
        // $('#login_form').submit(function(e) {
        //     //e.preventDefault();

        //     var email = $('#email').val().trim();
        //     var password = $('#password').val();

        //     let jsonData = {
        //         'userName': email,
        //         'password': password
        //     }

        //     $.ajax({
        //         url: `{{ env('API_URL') }}Authentication/login`,
        //         type: 'POST',
        //         data: JSON.stringify(jsonData),
        //         headers: {
        //             'Content-Type': 'application/json',
        //             'Accept': 'application/json'
        //         },
        //         success: function(response) {
        //             toastr.success('Login Successful');
        //             var _userResponse = response.data

        //         },
        //         error: function(xhr, status, error) {
        //             var _error = JSON.parse(xhr.responseText).errors
        //             _error.map(e => {
        //                 toastr.error(e.errorMessages.toString());
        //             })
        //         }
        //     });
        // });
    </script>
@endsection
