@extends('layouts.admin-dashboard')

@section('content')
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Add New Poll</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        @include('notification')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Poll Details</div>
                    <div class="panel-body">
                        <form class="form-horizontal " role="form" method="POST" name="addPoll" action="{{ route('admin.poll.store') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Poll Title</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control" required name="title" value="{{ isset($input) ? $input['title'] : old('title') }}">

                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('poll_category_id') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Poll Category</label>

                                <div class="col-md-6">
                                    <select id="poll_category_id" class="form-control" required name="poll_category_id" value="{{ old('poll_category_id') }}">
                                            <option value="">Select Category</option>
                                        @foreach($pollCategories as $index => $pollCategory)
                                            <option value="{{$index}}">{{$pollCategory}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('poll_start_date') ? ' has-error' : '' }}">
                                <label id="poll_start_date" class="col-md-4 control-label">Poll Start Date</label>

                                <div class="col-md-6">
                                    <input data-provide="datepicker" name="poll_start_date" class="form-control datepicker" value="{{$today}}" required>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('poll_end_date') ? ' has-error' : '' }}">
                                <label id="poll_start_date" class="col-md-4 control-label">Poll End Date</label>

                                <div class="col-md-6">
                                    <input data-provide="datepicker" name="poll_end_date" id="poll_end_date" class="form-control datepicker" value="{{$today}}" required>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Description</label>

                                <div class="col-md-6">
                                    <textarea name="description" id="description" class="form-control" rows="5">{{ isset($input) ? $input['description'] : old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('is_display_on_channel') ? ' has-error' : '' }}">
                                <label for="gender" class="col-md-4 control-label">Is Display on Channel ?</label>

                                <div class="col-md-6">
                                    <input id="is_private_no" type="radio" class="" name="is_private" value="0" checked><label for="is_private_no">No</label>
                                    <input id="is_private_yes" type="radio" class="" name="is_private" value="1"><label for="is_private_yes">Yes</label>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label for="gender" class="col-md-4 control-label">Ad Banner Image</label>

                                <div class="col-md-6">
                                    <input id="no" type="radio" class="" name="is_banner" value="0" checked><label for="no">No</label>
                                    <input id="yes" type="radio" class="" name="is_banner" value="1"><label for="yes">Yes</label>
                                </div>

                                <div class="col-md-6 col-md-offset-4 hidden" id="ad_banner">
                                    <label class="btn btn-block btn-primary btn-file">
                                        Browse Image <input type="file" style="display: none;" id="btn-upload-banner"   >
                                    </label>
                                    <div class="image-preview">
                                        <div class="image-preview-section">
                                            <h2>Image Preview Here</h2>
                                        </div>
                                        <center>
                                            <img src="{{asset('images/loading.gif')}}" class="img-responsive hidden" id="loading-image">
                                        </center>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('is_multiselect') ? ' has-error' : '' }}">
                                <label for="gender" class="col-md-4 control-label">Is Multiselect ?</label>

                                <div class="col-md-6">
                                    <input id="no" type="radio" class="" name="is_multichoice" value="0" checked><label for="no">No</label>
                                    <input id="yes" type="radio" class="" name="is_multichoice" value="1"><label for="yes">Yes</label>
                                </div>
                            </div>

                            <div class="form-group hidden" id="optionContainer">
                                <label class="col-md-4 control-label">Options</label>
                                <div class="col-xs-5">
                                    <input type="text" class="form-control" name="pollOptions[]" />
                                </div>
                                <div class="col-xs-3">
                                    <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>

                            <!-- The option field template containing an option field and a Remove button -->
                            <div class="form-group hide additional-field" id="optionTemplate">
                                <div class="col-xs-5 col-md-offset-4">
                                    <input class="form-control" type="text" name="pollOptions[]" />
                                </div>
                                <div class="col-xs-3">
                                    <button type="button" class="btn btn-info btn-default removeButton"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-login btn-primary">
                                        <i class="fa fa-btn fa-user"></i> Add Poll
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

        $("input:radio[name=is_banner]").on('change', function() {
            if($(this).val()==1){
                $('#ad_banner').removeClass('hidden');
            }
            else {
                $('#ad_banner').addClass('hidden');
            }
        });

        $("input:radio[name=is_multichoice]").on('change', function() {
            if($(this).val()==1){
                $('#optionContainer').removeClass('hidden');
                $('.additional-field').removeClass('hidden');
            }
            else {
                $('#optionContainer').addClass('hidden');
                $('.additional-field').addClass('hidden');
            }
        });

        // Add button click handler
        $('.addButton').click(function(){
            var $template = $('#optionTemplate'),
            $clone = $template
                    .clone()
                    .removeClass('hide')
                    .removeAttr('id')
                    .insertBefore($template),
                $option = $clone.find('[name="option[]"]');
            // Add new field
            $('#addPoll').formValidation('addField', $option);
        });

        // Remove button click handler
        $(document).on( 'click', '.removeButton', function() {
            var $row = $(this).parents('.form-group'),
                    $option = $row.find('[name="option[]"]');
            // Remove element containing the option
            $row.remove();
            // Remove field
            $('#addPoll').formValidation('removeField', $option);
        });

        $('.datepicker').datetimepicker({
            sideBySide:true,
            format: 'YYYY-MM-DD HH:mm:ss'
        });

        $('#btn-upload-banner').change(function(){
            var formData = new FormData();
            formData.append("image", $("#btn-upload-banner")[0].files[0]);
            formData.append("_token","{{csrf_token()}}");
            $('#loading-image').removeClass('hidden');

            $.ajax({
                url: "{{url('upload-image')}}",
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('.image-preview-section').html(data);
                    $('#loading-image').addClass('hidden');
                }
            });
        })
    })
</script>
@endsection
