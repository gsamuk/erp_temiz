<div>
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
                            <p class="fs-15 fw-medium mt-3">Zeberced Ltd ERP</p>
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
                                    @if ($err)
                                    <div class="alert alert-danger">
                                        {{ $err }}
                                    </div>
                                    @endif

                                    @if(Session::has('error'))
                                    <div class="alert alert-danger">{{ Session::get("error") }}</div>
                                    @endif


                                </div>
                                <div class="mt-4 p-2">
                                    <form wire:submit.prevent="login()">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="user_name" class="form-label">Kullanıcı Adı & Kodu</label>
                                            <input type="text"
                                                class="form-control @error('user_name') is-invalid @enderror"
                                                wire:model="user_name" placeholder="Enter username">
                                            @error('user_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">

                                            <label class="form-label" for="password-input">Şifre </label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" wire:model="password" id="password-input"
                                                    class="form-control pe-5 @error('password') is-invalid @enderror"
                                                    placeholder="Enter password">

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
                                                wire:model="rememberme" name="rememberme" checked>
                                            @else
                                            <input class="form-check-input" type="checkbox" id="rememberme"
                                                wire:model="rememberme" name="rememberme">
                                            @endif
                                            <label class="form-check-label" for="auth-remember-check">Beni
                                                Hatırla</label>
                                        </div>


                                        <div class="mt-4">
                                            <button class="btn btn-success w-100">Giriş Yap</button>
                                        </div>
                                        <div wire:loading wire:target="login">

                                            Giriş Yaplıyor Lütfen Bekleyiniz...

                                        </div>

                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="alert alert-info   alert-borderless" role="alert">
                            Eğer şifrenizi unuttuysanız sistem yönetici ile iletişime geçiniz.
                        </div>



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
                            </script> Zeberced ERP </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>

</div>