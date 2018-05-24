@extends('layouts.admin-dashboard')

@section('content')
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Rss Feed List</h1>
            </div>
        </div>
        @include('notification')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Enter Feed URL</div>
                    <div class="panel-body">
                        <form class="form-horizontal " role="form" method="POST" name="feedReader" action="{{ route('admin.rss-feed-url.store') }}" encryption="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                                <div class="form-group">
                                    <label for="gender" class="col-md-3 control-label">Feed Url</label>

                                    <div class="col-md-8">
                                        <input id="title" type="text" class="form-control" name="url" value="{{ old('url') }}" placeholder="feed url">

                                        @if ($errors->has('url'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('url') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @if (Auth::user()->role == 'admin')
                                    <div class="form-group">
                                        <label for="user" class="col-md-3 control-label">Select User</label>

                                        <div class="col-md-8">
                                            <select name="user_id" class="form-control">
                                                <option value="">Select User</option>
                                                @foreach($users as $key => $user)
                                                    <option value="{{$key}}">{{$user}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}" >
                                @endif
                                <div class="form-group">
                                    <div class="col-md-2 col-md-offset-6">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-rss-square"></i> Add Feed
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        List Of Feed
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Url</th>
                                        @if (Auth::user()->role =='admin')
                                            <th>User</th>
                                        @endif
                                        <th>Created Date</th>
                                        <th>Controlles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rssFeedUrls as $rssFeedUrl)
                                        <tr class="odd gradeX">
                                            <td>{{$rssFeedUrl->url}}</td>
                                            @if (Auth::user()->role =='admin')
                                                <td><a href="{{route('admin.user.edit', $rssFeedUrl->user->id)}}">{{$rssFeedUrl->user->first_name.' '.$rssFeedUrl->user->last_name}}</a></td>
                                            @endif
                                            <td>{{$rssFeedUrl->created_at->diffForHumans()}}</td>
                                            <td>
                                                <a href="{{route('admin.rss-feed-url.show', ['id' => $rssFeedUrl->id])}}" class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                <a onclick="deleteUrl('{{$rssFeedUrl->id}}')" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">

    $('document').ready(function() {
        $('#dataTables-example').DataTable();
    });

    function deleteUrl(id) {

        var formData = {"_token": "{{csrf_token()}}"};

        swal({
            title: "Are you sure?",
            text: "You want to delete",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel pls!",
            closeOnConfirm: false,
            closeOnCancel: false,
            allowEscapeKey: false,
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "{{ url('admin/rss-feed-url/') }}/" + id,
                    type: 'DELETE',
                    data: formData,
                    success: function (data) {
                        data = JSON.parse(data);
                        if (data['status']) {
                            swal({
                                    title: data['message'],
                                    text: "Press ok to continue",
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText: "Ok",
                                    closeOnConfirm: false,
                                    allowEscapeKey: false,
                                },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        window.location.reload();
                                    }
                                });
                        } else {
                            swal("Error", data['message'], "error");
                        }
                    }
                });
            } else {
                swal("Cancelled", "Feed will not be deleted.", "error");
            }
        });
    }

</script>
@endsection
