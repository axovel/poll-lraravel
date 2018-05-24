@extends('layouts.admin-dashboard')

@section('content')
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Comment List</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        @include('notification')
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-comments-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$totalComment}}</div>
                                <div>Total Comments!</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-comments-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$totalTodayComment}}</div>
                                <div>Total Comment Today!</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        List Of Comments
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Content</th>
                                    <th>Poll</th>
                                    @if(Auth::user()->role =='admin')
                                        <th>User</th>
                                    @endif
                                    <th>Date Created</th>
                                    <th>Date Modified</th>
                                    <th>Controlles</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($pollComments as $pollComment)
                                        <tr class="odd gradeX">
                                            <td>{{$pollComment->comment}}</td>
                                            <td><a href="{{route('admin.poll.show',['id' => $pollComment->poll_id])}}" target= "_blank">{{$pollComment->poll->title}}</a></td>
                                            @if(Auth::user()->role =='admin')
                                                <td><a href="{{route('admin.user.edit',['id' => $pollComment->user_id])}}" target= "_blank">{{$pollComment->user->first_name}}</a></td>
                                            @endif
                                            <td>{{$pollComment->created_at->toDateString()}}</td>
                                            <td>{{$pollComment->updated_at->toDateString()}}</td>
                                            <td>
                                                <a href="{{route('admin.poll-comments.edit',['id' => $pollComment->id])}}" class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                <a onclick="deleteComment('{{$pollComment->id}}')" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
        function deleteComment(id) {

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
                        url: "{{ url('admin/poll-comments/') }}/" + id,
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
                    swal("Cancelled", "Comment will not be deleted.", "error");
                }
            });
        }
    </script>
@endsection
