@extends('layouts.app')
@section('title', $pageTitle)
@section('og_url', url($poll->slug))
@section('og_title', $poll->title)
@section('og_description', $poll->description)
@section('og_image', asset('media/images/ads/medium/'.$poll->image))
@section('content')
    <div class="main-content col-md-6">
        <div class="poll-content-wrapper">
            <div class="polls">
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
            @if($ads)
                <div class="ads hidden">
                    <div class="ads-wrapper">
                        <div class="ads-image">
                            <a href="{{url($ads->url)}}" target="_blank"><img src="{{asset('media/images/ads/medium/'.$ads->image)}}" id="ads" /></a>
                        </div>
                        <div class="time-bar"></div>
                    </div>
                </div>
            @endif
        </div>
        <div class="content-items col-md-12">
            <div class="poll-comment">
                <h4><i class="fa fa-comments-o" aria-hidden="true"></i> Comments</h4>
                <form name="poll-comment-frm" action="{{route('comment.store')}}" method="post" id="poll-comment-frm">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="hidden" name="poll_id" value="{{$poll->id}}" />
                    </div>
                    <div class="form-group">
                        <textarea name="comment" class="form-control" cols="5" rows="5" placeholder="comment here..." required></textarea>
                    </div>
                    <div class="form-group">
                        <button name="submit" class="btn btn-success" id="add-comment"><i class="fa fa-comments-o" aria-hidden="true"></i> Comment Now</button>
                    </div>
                </form>
                <div class="comments-container small">
                    @foreach($poll->pollComment()->orderBy('created_at','DESC')->get() as $pollComment)
                        <div class="header">
                            <strong class="primary-font">{{$pollComment->user->first_name.' '.$pollComment->user->last_name}}</strong>
                            <small class="pull-right text-muted">
                                <i class="fa fa-clock-o fa-fw"></i> {{$pollComment->created_at->diffForHumans()}}
                            </small>
                        </div>
                        <span class="poll-comment">{{$pollComment->comment}}</span>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">

        $('document').ready(function(){

            $("#poll-comment-frm").submit(function(event){
                event.preventDefault();
                $.ajax({
                    url: $("#poll-comment-frm").attr('action'),
                    type: 'POST',
                    data: $("#poll-comment-frm").serialize(),
                    statusCode: {
                        401: function(){
                            swal({
                                title: "Warning",
                                text: "Please login",
                                type: "warning"
                            });
                        },
                        200: function (result) {
                            $('.comments-container').prepend(result);
                        }
                    }
                })
            });

            $('.ads-image').click(function(){
                $.ajax({
                    url: "{{route('ad-impression-count', $ads->id)}}"
                })
            })
        });

        function castVote(pollId)
        {
            var pollOptionName = "poll_option_"+pollId;

            var pollOptionId = $("input[name="+pollOptionName+"]:checked").val();

            var dataString = '_token={{csrf_token()}}'+'&poll_option_id='+pollOptionId;

            $('.polls').addClass('hidden');

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
                        $('.ads').removeClass('hidden');
                        $('.time-bar').circleProgress({
                            value: 1,
                            size: 30,
                            fill: {color: "#ff1e41"},
                            animation: {duration:10000}
                        }).on('circle-animation-end', function() {
                            $('.ads').addClass('hidden');
                            $('.polls').removeClass('hidden');
                        });
                    }
                }
            });
        }
    </script>
@endsection