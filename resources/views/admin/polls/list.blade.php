@extends('layouts.admin-dashboard')

@section('content')
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Polls</h1>
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
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$polls->count()}}</div>
                                <div>Total Polls!</div>
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
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$activePollCount}}</div>
                                <div>Active Polls!</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$inActivePollCount}}</div>
                                <div>Total Inactive Polls!</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        List Of Polls
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Category</th>
                                    <th>Is Active</th>
                                    <th>Channel Display</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Controller</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($polls as $poll)
                                        <tr class="odd gradeX">
                                            <td>{{$poll->title}}</td>
                                            @if($poll->image == '')
                                                <td><img src="{{asset('images/no-image.png')}}" width="150px"></td>
                                            @else
                                                <td><img src="{{asset('media/images/ads/verysmall/'.$poll->image)}}"></td>
                                            @endif
                                            <td>{{$poll->pollCategory->title}}</td>
                                            <td>{{$poll->is_active ==1 ? 'Yes' : 'No'}}</td>
                                            <td>{{$poll->is_display_on_channel ==1 ? 'Yes' : 'No'}}</td>
                                            <td>{{$poll->poll_start_date}}</td>
                                            <td>{{$poll->poll_end_date}}</td>
                                            <td>
                                                <a href="{{route('admin.poll.edit', ['id' => $poll->id])}}" class="btn btn-info"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <a href="{{route('admin.poll.show', ['id' => $poll->id])}}" class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                <a onclick="deletePoll('{{$poll->id}}')" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
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

    function deletePoll(id) {

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
                    url: "{{ url('admin/poll/') }}/" + id,
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
