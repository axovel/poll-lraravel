@extends('layouts.admin-dashboard')

@section('content')
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Category List</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        @include('notification')
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        List Of Categories
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Category Name</th>
                                    <th>Date Created</th>
                                    <th>Date Modified</th>
                                    <th>Is Active</th>
                                    <th>Controlles</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($pollCategories as $pollCategory)
                                        <tr class="odd gradeX">
                                            <td>{{$pollCategory->title}}</td>
                                            <td>{{$pollCategory->created_at}}</td>
                                            <td>{{$pollCategory->updated_at}}</td>
                                            <td>{{$pollCategory->is_active==1?'Yes':'No'}}</td>
                                            <td>
                                                <a href="{{route('admin.poll-category.edit', ['id' => $pollCategory->id])}}" class="btn btn-info"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <a onclick="deleteCategory('{{$pollCategory->id}}')" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
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

        function deleteCategory(id) {

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
                        url: "{{ url('admin/poll-category/') }}/" + id,
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
                    swal("Cancelled", "Category will not be deleted.", "error");
                }
            });
        }
    </script>
@endsection
