@extends('layouts.login')
@section('auth')
<!-- loader -->
<div id="loader">
    <div class="spinner-border text-primary" role="status"></div>
</div>
<!-- * loader -->

<!-- App Capsule -->
<div id="appCapsule" class="pt-0">
    <div class="login-form mt-1">
        <div class="section">
            <img src="{{ asset('mobilekit/assets/img/logo.png') }}" alt="image" class="form-image mt-3 mb-1 mt-5 pt-5" style="width: 150px;">
        </div>
        <div class="section mt-1">
            <h2>Presensi Online</h2>
            <h3 class="mb-1">Sekolah Alam Bahriatul Ulum Pandeglang</h3>
            <hr>
            <p>Silakan Login menggunakan Username dan Password.</p>
        </div>
        <div class="section">
            @if(session()->has('success'))
            <div class="alert alert-outline-success">
            {{ session('success') }}
            </div>
            @endif
            @if(session()->has('loginError'))
                <div class="alert alert-outline-danger">
                {{ session('loginError') }}
                </div>
            @endif
            <form action="{{ url('/login-proses')}}" method="POST">
                @csrf
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <input type="text" name="username" class="form-control" placeholder="Username">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>

                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>

                <div class="form-links mt-2">
                    <div class="icheck-primary">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">
                            Ingat saya
                        </label>
                        </div>
                    <!--<div class="text-muted">Lupa Password?</div>-->
                </div>

                <div class="form-button-group">
                    <button type="submit" class="btn btn-success btn-block btn-lg">Login</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection