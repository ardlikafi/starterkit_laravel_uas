@extends('adminlte::auth.auth-page', ['auth_type' => 'password_reset'])

@section('auth_header', __('Lupa Password'))

@section('auth_body')
    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Kirim Link Reset Password</button>
    </form>
@endsection

@section('auth_footer')
    <p class="my-0">
        <a href="{{ route('login') }}">Kembali ke Login</a>
    </p>
@endsection
