@extends('layouts.blank')
@section('content')
<div class="main-content">
    <div class="bg-gray-light" id="frm-login">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="First Name">
                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name">
                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email Address">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password" placeholder="Password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Password">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" id="btn-login">
                                    <i class="fa fa-btn fa-user"></i>&nbsp;Register
                                </button>
                            </div>
                        </div>
                    </form>
                    <p class="info-text">
                        By signing up, you agree to our <a href="#" target="blank">terms or use</a>,<a href="#" target="blank"> privacy policy</a> and <a href="#" target="blank">cookie policy</a>
                    </p>
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
                        <span class="translation_missing" title="translation missing: en.user_sessions.login.New_to_Kickstarter">have an account ?</span>
                        <a classes="bold js-switch-to-signup" href="{{url('login')}}"><span class="translation_missing" title="translation missing: en.user_sessions.login.Sign_up">log in</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
