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
                                        <th>title</th>
                                        <th>Description</th>
                                        <th>Publish Date</th>
                                        <th>Controller</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rssFeeds as $rssFeedData)
                                        <tr class="odd gradeX">
                                            <td><a href="{{$rssFeedData->url}}" target="_blank">{{$rssFeedData->title}}</a></td>
                                            <td>{{$rssFeedData->description}}</td>
                                            <td>{{$rssFeedData->pubDate}}</td>
                                            <td>
                                                <form method="post" action="{{route('create-poll')}}">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="title" value="{{ $rssFeedData->title }}">
                                                    <input type="hidden" name="description" value="{{ $rssFeedData->description }}">
                                                    <button class="btn btn-success" title="create poll"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                                    <a class="btn btn-danger" onclick="deleteFeed('{{$rssFeedData->id}}')" title="Create Poll"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                </form>
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

    function deleteFeed(id)
    {
        var formData = {"_token":"{{csrf_token()}}"};

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
        function(isConfirm){
            if(isConfirm) {
                $.ajax({
                    url: "{{ url('admin/rss-feed-data/') }}/" + id,
                    type: 'DELETE',
                    data:formData,
                    success: function(data) {
                        data = JSON.parse(data);
                        if(data['status']) {
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
                            function(isConfirm){
                                if(isConfirm) {
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
