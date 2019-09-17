@extends('layouts.login')
@section('cssContent')
    @include('partials.login.loginpartials')
@endsection
@section('content')

    <div class="limiter">

        <div class="container-login100" style="background-image: url('img/bg-01.jpg');">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                <form class="login100-form validate-form" method="POST" action="{{ route('register') }}">
                    @csrf

                    <span class="login100-form-title p-b-49">
						Register
					</span>


                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }} </label>

                        <div class="col-md-8">
                            <input id="name" type="text"
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                   value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email"
                               class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-8">
                            <input id="email" type="email"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                   value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-8">
                            <input id="password" type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm"
                               class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-8">
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation" required>
                        </div>
                    </div>

                    {{--<div class="container-login100-form-btn">--}}
                    <div class="wrap-register00-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="register100-form-btn">
                            Register
                        </button>
                    </div>
                    {{--</div>--}}

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
                </form>
            </div>

        </div>


    </div>
    </div>
@endsection
@section('jsContent')
    @include('partials.login.loginJs')
@endsection

