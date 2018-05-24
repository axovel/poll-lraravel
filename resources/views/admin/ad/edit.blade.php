@extends('layouts.admin-dashboard')

@section('content')
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Ad</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            @include('notification')
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Ad Details</div>
                        <div class="panel-body">
                            <form class="form-horizontal " role="form" method="POST" name="addPoll" action="{{ route('admin.ad.update',['id' =>$ads->id]) }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="_method" value="PUT">

                                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Ad Title</label>

                                    <div class="col-md-6">
                                        <input id="title" type="text" class="form-control" name="title" value="{{$ads->title}}">

                                        @if ($errors->has('title'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('ad_category_id') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Poll Category</label>

                                    <div class="col-md-6">
                                        <select id="ad_category_id" class="form-control" required name="ad_category_id" value="{{$ads->ad_category_id}}">
                                            <option value="">Select Category</option>
                                            @foreach($adCategories as $index => $adCategory)
                                                <option value="{{$index}}" <?php if($ads->ad_category_id==$index){ echo 'selected';}?>>{{$adCategory}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">URL</label>

                                    <div class="col-md-6">
                                        <input type="text" name="url" id="url" class="form-control" value="{{$ads->url}}">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                                    <label id="ad_start_date" class="col-md-4 control-label">Ad Start Date</label>

                                    <div class="col-md-6">
                                        <input data-provide="datepicker" name="start_date" class="form-control datepicker" value="{{$ads->start_date}}">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
                                    <label id="ad_start_date" class="col-md-4 control-label">Ad End Date</label>

                                    <div class="col-md-6">
                                        <input data-provide="datepicker" name="end_date" id="end_date" class="form-control datepicker" value="{{$ads->end_date}}">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }}">
                                    <label for="gender" class="col-md-4 control-label">Is Active ?</label>

                                    <div class="col-md-6">
                                        <input id="yes" type="radio" class="" name="is_active" value="1" <?php if($ads->is_active==1) echo 'checked';?>><label for="yes">Yes</label>
                                        <input id="no" type="radio" class="" name="is_active" value="0" <?php if($ads->is_active==0) echo 'checked';?>><label for="no">No</label>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                    <label for="gender" class="col-md-4 control-label">Ad Banner Image</label>

                                    <div class="col-md-6">
                                        <label class="btn btn-block btn-primary btn-file">
                                            Browse <input type="file" style="display: none;" id="btn-upload-banner">
                                        </label>
                                        <div class="image-preview">
                                            <img src="{{asset('media/images/ads/medium/'.$ads->image)}}" class="img-responsive">
                                            <input type="hidden" name="image" value="{{$ads->image}}" >
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-user"></i> Update Ad
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
@section('scripts')
    <script type="text/javascript">
        $('document').ready(function(){
            $('.datepicker').datetimepicker({
                sideBySide:true,
                format: 'YYYY-MM-DD HH:mm:ss'
            });
            $('#btn-upload-banner').change(function(){
                var formData = new FormData();
                formData.append("image", $("#btn-upload-banner")[0].files[0]);
                formData.append("_token","{{csrf_token()}}");
                $.ajax({
                    url: "{{url('upload-image')}}",
                    type: 'POST',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $('.image-preview').html(data);
                    }
                });
            })
        })
    </script>
@endsection
