@extends('layouts.admin-dashboard')

@section('content')
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Poll Comment</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            @include('notification')
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Edit</div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.poll-comments.update', ['id' => $pollComment->id]) }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="_method" value="PUT">

                                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Comment</label>

                                    <div class="col-md-6">
                                        <input id="comment" type="text" class="form-control" name="comment" value="{{$pollComment->comment}}">
                                    </div>
                                    <div class="col-md-6">
                                        <input id="poll-id" type="hidden" class="form-control" name="poll_id" value="{{$pollComment->poll_id}}">
                                    </div>
                                    <div class="col-md-6">
                                        <input id="user-id" type="hidden" class="form-control" name="user_id" value="{{$pollComment->user_id}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-user"></i> Edit Comment
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
@endsection
