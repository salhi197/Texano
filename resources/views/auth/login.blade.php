@extends('layouts.login')
@section('cssContent')
    @include('partials.login.loginpartials')
@endsection


@section('content')
    <div class="limiter">
        <div class="container-login100" style="background-image: url('img/bg-01.jpg');">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <span class="login100-form-title p-b-49">
						Login
					</span>
                    {{--<div class="wrap-input100 validate-input m-b-23" data-validate = "Username is reauired">--}}
                    <div class="wrap-input100 validate-input m-b-23">
                        <span class="label-input100">Username</span>
                        {{--<input class="input100" type="text" name="username" placeholder="Type your username">--}}
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} input100" name="email" value="{{ old('email') }}" laceholder="Type your username" required autofocus>
                        @if ($errors->has('email'))
                            <spegieran class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                         @endif
                        <span class="focus-input100" data-symbol="&#xf206;"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <span class="label-input100">Password</span>
                        {{--<input class="input100" type="password" name="pass" placeholder="Type your password">--}}
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} input100" name="password" placeholder="Type your password" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                        <span class="focus-input100" data-symbol="&#xf190;"></span>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8">

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}" style="align-content: right">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn">
                                Login
                            </button>
                        </div>
                    </div>

                    <div class="txt1 text-center p-t-54 p-b-20">
						<span>
							Or Sign Up Using
						</span>
                    </div>

                    <div class="flex-c-m">

                        <a href="login/google" class="btn-google m-b-20">
                            <img src="img/icons/icon-google.png" alt="GOOGLE" style="margin-right: 10px">
                             Google
                        </a>
                    </div>

                    <div class="flex-col-c p-t-155">

                        <a href="/register" class="txt2">
                            Or Sign Up
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<!-- Scripts -->
@section('jsContent')
    @include('partials.login.loginJs')
@endsection
