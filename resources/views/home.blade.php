@extends('layouts.home')

@section('title','Home')

@section('css_imports')
    <link rel="stylesheet" href="/css/app.css" type="text/css" />
    <link rel="stylesheet" href="/css/home_page.css" type="text/css" />
@endsection

@section('content')

<div class="image-wrapper">
    <div class="polaroid-image"></div>
</div>

<div class="login-form-area">
    <h1>Login</h1>

    <vue-typed-js :type-speed="65" :strings="['Welcome back.']">
        <p><span class="typing"></span></p>
    </vue-typed-js>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="input-section">
            <label>E-mail:</label>
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="input-section">
            <label>Password:</label>
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="input-section">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

            <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
            </label>
        </div>

        <div class="input-section">
            <button type="submit" class="btn-login">Login</button>
        </div>
    </form>
</div>

@endsection
