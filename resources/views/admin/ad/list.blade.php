@extends('layouts.admin-dashboard')

@section('content')
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Ads</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        @include('notification')
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        List Of Ads
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Url</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Impression Count</th>
                                    <th>Display Count</th>
                                    <th>Is Active</th>
                                    <th>Controles</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($ads as $ad)
                                        <tr class="odd gradeX">
                                            <td>{{$ad->title}}</td>
                                            <td><img src="{{asset('media/images/ads/verysmall/'.$ad->image)}}"></td>
                                            <td>{{$ad->url}}</td>
                                            <td>{{$ad->start_date}}</td>
                                            <td>{{$ad->end_date}}</td>
                                            <td>{{$ad->adVisitor->count()}}</td>
                                            <td>{{$ad->adDisplayHistory->count()}}</td>
                                            <td>{{$ad->is_active==1?'Yes':'No'}}</td>
                                            <td>
                                                <a href="{{route('admin.ad.edit', ['id' => $ad->id])}}" class="btn btn-info"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <a href="{{route('admin.ad.show', ['id' => $ad->id])}}" class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                <a onclick="deleteAd('{{$ad->id}}')" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
    $('document').ready(function(){
        $('#dataTables-example').DataTable();
    })

    function deleteAd(id) {

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
                    url: "{{ url('admin/ad/') }}/" + id,
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
