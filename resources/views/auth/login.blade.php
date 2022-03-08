@extends('layouts.master-without-nav')
@section('title')
@lang('translation.signin')
@endsection
@section('content')
<div class="auth-page-wrapper pt-5">
    <!-- auth page bg -->
    <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
        <div class="bg-overlay"></div>

        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div>

    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mt-sm-5 text-white-50 mb-4 text-center">
                        <div>
                            <a href="index" class="d-inline-block auth-logo">
                                <img src="{{ URL::asset('assets/images/dark_logo.png') }}" alt="" height="39">
                            </a>
                        </div>
                        <p class="fs-15 fw-medium mt-3">Zeberced Consration ERP</p>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="mt-2 text-center">
                                <h5 class="text-primary">Hoşgeldiniz !!!</h5>
                                <p class="text-muted">Zeberced ERP Giriş Sayfası</p>
                                @if (session()->has('message'))
                                <div class="alert alert-danger alert-dismissible fade show mb-xl-0 shadow" role="alert">
                                    <strong> Hata! </strong> {{ session()->get('message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                @endif

                            </div>
                            <div class="mt-4 p-2">
                                <form action="{{ route('login.post') }}" id="#login_form" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="user_name" class="form-label">Kullanıcı Adı & Kodu</label>
                                        <input type="text" class="form-control" id="user_name" name="user_name"
                                            value="{{Cookie::get('user_name')}}" placeholder="Enter username">
                                        @error('user_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">

                                        <label class="form-label" for="password-input">Şifre</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password"
                                                class="form-control pe-5 @error('password') is-invalid @enderror"
                                                name="password" value="{{ Cookie::get('password') }}"
                                                placeholder="Enter password" id="password-input">
                                            <button
                                                class="btn btn-link position-absolute end-0 text-decoration-none text-muted top-0"
                                                type="button" id="password-addon"><i
                                                    class="ri-eye-fill align-middle"></i></button>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                    </div>

                                    <div class="form-check">
                                        @if(Cookie::get('rememberme'))
                                        <input class="form-check-input" type="checkbox" id="rememberme"
                                            name="rememberme" checked>
                                        @else
                                        <input class="form-check-input" type="checkbox" id="rememberme"
                                            name="rememberme">

                                        @endif

                                        <label class="form-check-label" for="auth-remember-check">Beni Hatırla</label>
                                    </div>


                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit">Giriş Yap</button>
                                    </div>


                                </form>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->



                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> Velzon. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
</div>
@endsection

@section('script')
<script src="assets/libs/particles.js/particles.js.min.js"></script>
<script src="assets/js/pages/particles.app.js"></script>
<script src="assets/js/pages/password-addon.init.js"></script>

@endsection