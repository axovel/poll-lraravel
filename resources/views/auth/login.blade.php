@extends('layouts.blank')
@section('content')
<div class="main-content">
    <div class="bg-gray-light" id="frm-login">
        <div class="col-md-4 col-md-offset-4">
            @include('notification')
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/user/login') }}">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail Address">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password" placeholder="password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <a class="btn btn-link forgot-password-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" id="btn-login">
                                    <i class="fa fa-btn fa-sign-in"></i>&nbsp;Login
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label class="small-text">
                                        <input type="checkbox" name="remember" checked> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="text-strikethru">
                        <div class="line"></div>
                        <div class="text"><span class="translation_missing" title="translation missing: en.user_sessions.login.or">Or</span></div>
                    </div>
                    <a href="{{route('social.login.redirect',['provider' => 'facebook'])}}" class="btn btn-primary btn-lg btn-block"><i class="fa fa-facebook"></i> | Login with Facebook</a>
                    <a href="{{route('social.login.redirect',['provider' => 'google'])}}" class="btn btn-danger btn-lg btn-block"><i class="fa fa-google-plus"></i> | Login with Google+</a>
                    <p class="info-text">
                        We'll never post anything on your social account
                        <br>
                        without your permission.
                    </p>
                    <div class="rounded-content-frame__footer">
                        <span class="translation_missing" title="translation missing: en.user_sessions.login.New_to_Kansanaani">New To Kansanaani</span>
                        <a classes="bold js-switch-to-signup" href="{{url('register')}}"><span class="translation_missing" title="translation missing: en.user_sessions.login.Sign_up">Sign Up</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
