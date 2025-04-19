<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Register</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('style/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('style/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Form Registrasi Vendor</h1>
                            </div>
                            <form class="user" method="POST" action="{{ route('register') }}">
                                @csrf
                                <input type="hidden" name="role_id" value="2">
                                <div class="form-group">
                                    <label for="name">Nama Vendor/Toko</label>
                                    <input id="name" type="text"
                                        class="form-control form-control-user @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required autocomplete="name"
                                        autofocus placeholder="Name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email"
                                        class="form-control form-control-user @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="Email Address">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="password">Password</label>
                                        <input id="password" type="password"
                                            class="form-control form-control-user @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="new-password" placeholder="Password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="password-confirm">Repeat Password</label>
                                        <input id="password-confirm" type="password"
                                            class="form-control form-control-user" name="password_confirmation" required
                                            autocomplete="new-password" placeholder="Repeat Password">
                                    </div>
                                </div>
                                {{-- vendor --}}
                                <div class="form-group">
                                    <label for="address">Alamat</label>
                                    <input id="address" type="address"
                                        class="form-control form-control-user @error('address') is-invalid @enderror"
                                        name="address" value="{{ old('address') }}" required autocomplete="address"
                                        placeholder="Address">

                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="city">Kota</label>
                                    <select id="city" name="city"
                                        class="form-control form-control-user @error('city') is-invalid @enderror"
                                        required>
                                        <option value="" disabled selected>Pilih Kota</option>
                                        <option value="Jakarta" {{ old('city') == 'Jakarta' ? 'selected' : '' }}>
                                            Jakarta</option>
                                        <option value="Surabaya" {{ old('city') == 'Surabaya' ? 'selected' : '' }}>
                                            Surabaya</option>
                                        <option value="Bandung" {{ old('city') == 'Bandung' ? 'selected' : '' }}>
                                            Bandung</option>
                                        <option value="Yogyakarta"
                                            {{ old('city') == 'Yogyakarta' ? 'selected' : '' }}>Yogyakarta</option>
                                    </select>
                                    @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="phone">Kontak</label>
                                    <input id="phone" type="text"
                                        class="form-control form-control-user @error('phone') is-invalid @enderror"
                                        name="phone" value="{{ old('phone') }}" required autocomplete="phone"
                                        placeholder="Nomor Telepon atau WhatsApp">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="paypal_id">PayPal ID</label>
                                    <input id="paypal_id" type="string"
                                        class="form-control form-control-user @error('paypal_id') is-invalid @enderror"
                                        name="paypal_id" value="{{ old('paypal_id') }}" required
                                        autocomplete="paypal_id" placeholder="PayPal Email">
                                    @error('paypal_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                                {{-- <hr> --}}
                                {{-- <a href="index.html" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a> --}}
                            </form>
                            <hr>
                            {{-- <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div> --}}
                            <div class="text-center">
                                <a class="small" href="{{ route('login') }}">Sudah punya akun? Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('style/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('style/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('style/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('style/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
