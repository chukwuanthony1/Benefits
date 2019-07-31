@extends('layouts.loginlayout')

@section('content')
<body class=" login">
    <!-- BEGIN : LOGIN PAGE 5-1 -->
    <div class="user-login-5">
        <div class="row bs-reset">
            <div class="col-md-6 bs-reset">
                <div class="login-bg" style="background-image:url(/img/login/bg1.jpg)">
                    <!-- <img class="login-logo" src="/img/login/logo.png" /> -->
                </div>
            </div>
            <div class="col-md-6 login-container bs-reset">
                <div class="login-content">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('warning'))
                        <div class="alert alert-danger">
                            {{ session('warning') }}
                        </div>
                    @endif
                    <h1>Benefit App Login</h1>
                    
                    <form method="POST" action="{{ route('login') }}" class="login-form">
                        @csrf
                        <!-- <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            <span>Enter any username and password. </span>
                        </div> -->
                        <div class="row">
                            <div class="col-xs-6">
                                <label>Email Address</label>
                                <input id="email" type="email" class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus autocomplete="off" autocomplete="false">

                                @if ($errors->has('email'))
                                    <span class="alert alert-danger invalid-feedback" role="alert" style="display: inline-flex;">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-6">
                                <label>Password</label>
                                <input id="password" type="password" class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

                                @if ($errors->has('password'))
                                    <span class="alert alert-danger invalid-feedback" role="alert" style="display: inline-flex;">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="checkbox rem-password">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me 
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-8 text-right">
                                <div class="forgot-password">
                                    @if (Route::has('password.request'))
                                        <a class="forget-password" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                                <button class="btn blue" type="submit">Sign In</button>
                            </div>
                        </div>
                    </form>
                    <br/>
                    <br/>
                    <div class="col-sm-8 text-right">
                        <div class="forgot-password">
                            <a class="btn btn-danger btn-lg" href="{{ route('user.register') }}">
                                {{ __('New User Signup') }}
                            </a>
                        </div>
                    </div>
                    <!-- BEGIN FORGOT PASSWORD FORM -->
                </div>
                <!-- <div class="login-footer">
                    <div class="row bs-reset">
                        <div class="col-xs-5 bs-reset">
                            <ul class="login-social">
                                <li>
                                    <a href="javascript:;">
                                        <i class="icon-social-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="icon-social-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="icon-social-dribbble"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xs-7 bs-reset">
                            <div class="login-copyright text-right">
                                <p>Copyright &copy; Keenthemes 2015</p>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</body>
@endsection
