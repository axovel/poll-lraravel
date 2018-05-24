@extends('layouts.admin-dashboard')

@section('content')
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit User</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            @include('notification')
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Edit</div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.user.update',['id' => $user->id]) }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="_method" value="PUT">

                                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">First Name</label>

                                    <div class="col-md-6">
                                        <input id="first_name" type="text" class="form-control" name="first_name" value="{{$user->first_name}}">

                                        @if ($errors->has('first_name'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Last Name</label>

                                    <div class="col-md-6">
                                        <input id="first_name" type="text" class="form-control" name="last_name" value="{{$user->last_name}}">

                                        @if ($errors->has('last_name'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" value="{{$user->email}}">

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                    <label for="gender" class="col-md-4 control-label">Gender</label>

                                    <div class="col-md-6">
                                        <input id="male" type="radio" class="" name="gender" value="M" <?php if($user->gender=='M') echo 'checked';?>><label for="male"> Male</label>
                                        <input id="female" type="radio" class="" name="gender" value="F" <?php if($user->gender=='F') echo 'checked';?>><label for="female">Female</label>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('born') ? ' has-error' : '' }}">
                                    <label id="born" class="col-md-4 control-label">Born</label>

                                    <div class="col-md-6">
                                        <input data-provide="datepicker" name="born" value="{{$user->born}}" class="form-control datepicker">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                    <label for="address" class="col-md-4 control-label">Address</label>

                                    <div class="col-md-6">
                                        <textarea rows="10" cols="50" name="address" class="form-control">{{$user->address}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                    <label for="city" class="col-md-4 control-label">City</label>

                                    <div class="col-md-6">
                                        <input type="text" name="city" value="{{$user->city}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                    <label for="country" class="col-md-4 control-label">Country</label>

                                    <div class="col-md-6">
                                        <input type="text" name="country" value="{{$user->country}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password">

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">User Role</label>

                                    <div class="col-md-6">
                                        <select id="role" class="form-control" name="role" value="{{$user->role}}">
                                            <option value="admin" <?php if($user->role=='admin') {echo 'selected';}?>>Admin</option>
                                            <option value="company" <?php if($user->role=='company') {echo 'selected';}?>>Company</option>
                                            <option value="user" <?php if($user->role=='user') {echo 'selected';}?>>User</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-user"></i> Update User
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('document').ready(function(){
            $('.datepicker').datetimepicker({
                format:'YYYY-MM-DD'
            });
        })
    </script>
@endsection
