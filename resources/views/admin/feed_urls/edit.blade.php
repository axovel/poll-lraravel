@extends('layouts.admin-dashboard')

@section('content')
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Poll</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            @include('notification')
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Poll Details</div>
                        <div class="panel-body">
                            <form class="form-horizontal " role="form" method="POST" name="addPoll" action="{{ route('admin.poll.update',['id' => $poll->id]) }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="_method" value="PUT">

                                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Poll Title</label>

                                    <div class="col-md-6">
                                        <input id="title" type="text" class="form-control" name="title" value="{{ $poll->title }}">

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
                                        <select id="poll_category_id" class="form-control" required name="poll_category_id" value="{{$poll->poll_category_id}}">
                                            <option value="">Select Category</option>
                                            @foreach($pollCategories as $index => $pollCategory)
                                                <option value="{{$index}}" <?php if($poll->poll_category_id==$index){ echo 'selected';}?>>{{$pollCategory}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('poll_start_date') ? ' has-error' : '' }}">
                                    <label id="poll_start_date" class="col-md-4 control-label">Poll Start Date</label>

                                    <div class="col-md-6">
                                        <input data-provide="datepicker" name="poll_start_date" class="form-control datepicker" value="{{$poll->poll_start_date}}">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('poll_end_date') ? ' has-error' : '' }}">
                                    <label id="poll_start_date" class="col-md-4 control-label">Poll End Date</label>

                                    <div class="col-md-6">
                                        <input data-provide="datepicker" name="poll_end_date" class="form-control datepicker" value="{{$poll->poll_end_date}}">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Description</label>

                                    <div class="col-md-6">
                                        <textarea name="description" id="description" class="form-control" rows="5">{{$poll->description}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                    <label for="gender" class="col-md-4 control-label">Ad Banner Image</label>

                                    <div class="col-md-6">
                                        <label class="btn btn-block btn-primary btn-file">
                                            Browse <input type="file" style="display: none;" id="btn-upload-banner">
                                        </label>
                                        <div class="image-preview">
                                            <img src="{{asset('media/images/ads/medium/'.$poll->image)}}" class="img-responsive">
                                            <input type="hidden" name="image" value="{{$poll->image}}" >
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('is_multiselect') ? ' has-error' : '' }}">
                                    <label for="gender" class="col-md-4 control-label">Is Multiselect ?</label>

                                    <div class="col-md-6">
                                        <input id="no" type="radio" class="" name="is_multichoice" value="0" <?php if($poll->is_multichoice==0) echo 'checked';?>><label for="no">No</label>
                                        <input id="yes" type="radio" class="" name="is_multichoice" value="1" <?php if($poll->is_multichoice==1) echo 'checked';?>><label for="yes">Yes</label>
                                    </div>
                                </div>

                                @if($poll->is_multichoice==1)
                                    <?php $i=0;?>
                                    @foreach($poll->pollOption->lists('value','id') as  $index => $pollOption)
                                        @if($i==0)
                                            <div class="form-group" id="optionContainer">
                                                <label class="col-md-4 control-label">Options</label>
                                                <div class="col-xs-5">
                                                    <input type="text" class="form-control" name="pollOptions[]" value="{{$pollOption}}" />
                                                </div>
                                                <div class="col-xs-3">
                                                    <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        @else
                                            <!-- The option field template containing an option field and a Remove button -->
                                            <div class="form-group additional-field" id="optionTemplate">
                                                <div class="col-xs-5 col-md-offset-4">
                                                    <input class="form-control" type="text" name="pollOptions[]" value="{{$pollOption}}" />
                                                </div>
                                                <div class="col-xs-3">
                                                    <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                                                </div>
                                            </div>
                                        @endif
                                    <?php $i++ ?>
                                    @endforeach
                                @else
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
                                            <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-user"></i> Update Poll
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
            $("input:radio[name=is_multichoice]").on('change',function(){
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
            })
            // Remove button click handler
            $(document).on( 'click', '.removeButton', function() {
                var $row = $(this).parents('.form-group'),
                $option = $row.find('[name="option[]"]');
                // Remove element containing the option
                $row.remove();
                // Remove field
                $('#addPoll').formValidation('removeField', $option);
            })

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
