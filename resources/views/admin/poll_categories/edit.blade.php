@extends('layouts.admin-dashboard')

@section('content')
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Poll Category</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            @include('notification')
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Edit</div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.poll-category.update', ['id' => $pollCategory->id]) }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="_method" value="PUT">

                                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Category Name</label>

                                    <div class="col-md-6">
                                        <input id="title" type="text" class="form-control" name="title" value="{{$pollCategory->title}}">

                                        @if ($errors->has('title'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }}">
                                    <label for="gender" class="col-md-4 control-label">Is Active ?</label>

                                    <div class="col-md-6">
                                        <input id="yes" type="radio" class="" name="is_active" value="1" <?php if($pollCategory->is_active==1) echo 'checked';?>><label for="yes">Yes</label>
                                        <input id="no" type="radio" class="" name="is_active" value="0" <?php if($pollCategory->is_active==0) echo 'checked';?>><label for="no">No</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-user"></i> Edit Category
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
