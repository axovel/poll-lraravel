@extends('layouts.admin-dashboard')

@section('content')
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User List</h1>
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
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$totalUsers}}</div>
                                <div>Total Users!</div>
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
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$totalTodayUsers}}</div>
                                <div>Today's Registration!</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        List Of User
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Role</th>
                                    <th>Born</th>
                                    <th>City</th>
                                    <th>Country</th>
                                    <th>Controller</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr class="odd gradeX">
                                            <td>{{$user->first_name.' '.$user->last_name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->gender}}</td>
                                            <td>{{$user->role}}</td>
                                            <td>{{$user->born}}</td>
                                            <td>{{$user->city}}</td>
                                            <td>{{$user->country}}</td>
                                            <td>
                                                <a href="{{route('admin.user.edit', ['id' => $user->id])}}" class="btn btn-info"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <a onclick="deleteUser('{{$user->id}}')" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
<script type="text/javascript">
    $('document').ready(function() {
        $('#dataTables-example').DataTable();
    });

    function deleteUser(id) {

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
                    url: "{{ url('admin/user/') }}/" + id,
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
                swal("Cancelled", "User will not be deleted.", "error");
            }
        });
    }
</script>
@endsection
