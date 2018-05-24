@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
    <div class="main-content col-md-6">
        @foreach($polls as $poll)
            <div class="poll-content-wrapper">
                <div class="col-md-12 poll-header">
                    <span><strong>Question :</strong> {{$poll->title}}</span>
                </div>
                <div class="col-md-12 poll-answers">
                    <ol class="poll-opinion-list">
                        @foreach($poll->pollOption as $pollOpinion)
                            <li>
                                <input type="radio" value="{{$pollOpinion->id}}" name="poll_option_{{$poll->id}}" id="poll_option_{{$pollOpinion->id}}"/><label for="poll_option_{{$pollOpinion->id}}">{{$pollOpinion->value}}</label>
                            </li>
                        @endforeach
                    </ol>
                </div>
                <div class="col-md-12" id="poll-results-{{$poll->id}}">

                </div>
                <div class="col-md-12 poll-footer">
                    <button class="btn btn-success" onclick="castVote('{{$poll->id}}')"><i class="fa fa-bell" aria-hidden="true"></i> Mark Your Vote</button>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
//        $('document').ready(function(){
//            $('.poll-option-radio').iCheck({
//                checkboxClass: 'icheckbox_square',
//                radioClass: 'iradio_square',
//                increaseArea: '20%' // optional
//            });
//            $('.poll-option-radio').on('ifChecked', function(event){
//                pollOptionId = $(this).val();
//                pollId = $(this).attr('id');
//                castVote(pollId,pollOptionId);
//            });
//        });

        function castVote(pollId)
        {
            var pollOptionName = "poll_option_"+pollId;

            var pollOptionId = $("input[name="+pollOptionName+"]:checked").val();

            var dataString = '_token={{csrf_token()}}'+'&poll_option_id='+pollOptionId;

            $.ajax({
                url: "{{url('cast-vote')}}/"+pollId,
                type: 'POST',
                data: dataString,
                success: function (result) {
                    if(result==0)
                    {
                        swal({
                            title: "Error",
                            text: "You you have already casted your vote. Please try different polls",
                            type: "error"
                        });
                    }
                    else {
                        $('#poll-results-'+pollId).html(result);
                    }
                }
            });
        }
    </script>
@endsection