@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
    <div class="main-content col-md-6">
        @foreach($polls as $poll)
            <div class="content-items col-md-12" id="poll-section-{{$poll->id}}">
                <div class="poll-content-wrapper row">
                    <img src="{{asset('media/images/ads/medium/'.$poll->image)}}" />
                    {{ csrf_field() }}
                    <div class="poll-category row">
                        <a href="{{url($poll->pollCategory->slug)}}" class="btn politics-btn">{{$poll->pollCategory->title}}</a>
                    </div>
                    <div class="poll-options-wrapper row">
                        <div class="poll-title">
                            <h4><a href="{{url($poll->slug)}}">{{$poll->title}}</a></h4>
                            <div class="poll-title">
                                <h4><a href="{{url($poll->slug)}}">{{$poll->title}}</a></h4>
                                <div class="social-share col-md-offset-6 row">
                                    <div class="col-md-4">
                                        votes {{$poll->pollVote->count()}}
                                    </div>
                                    <div class="col-md-4">
                                        <i class="fa fa-comments-o" aria-hidden="true"></i> {{$poll->pollComment->count()}}
                                    </div>
                                    <div class="col-md-4">
                                        <span class="dropdown">
                                            <a data-toggle="dropdown" href="#"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
                                            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                                <p>Share this poll</p>
                                                <span id="shareBtn"><i class="fa fa-facebook-square fa-3x" aria-hidden="true"></i></span>
                                                {{--<a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{$poll->slug}}"><i class="fa fa-facebook-square fa-3x" aria-hidden="true"></i></a>--}}
                                                <i class="fa fa-twitter-square fa-3x" aria-hidden="true"></i>
                                                <i class="fa fa-google-plus-square fa-3x" aria-hidden="true"></i>
                                            </ul>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('document').ready(function(){
            $('.poll-option-radio').iCheck({
                checkboxClass: 'icheckbox_square',
                radioClass: 'iradio_square',
                increaseArea: '20%' // optional
            });
            $('.poll-option-radio').on('ifChecked', function(event){
                pollOptionId = $(this).val();
                pollId = $(this).attr('id');
                castVote(pollId,pollOptionId);
            });
        });

        function castVote(pollId,pollOptionId)
        {
            var dataString = '_token={{csrf_token()}}'+'&poll_option_id='+pollOptionId;
            $.ajax({
                url: $('#poll-' + pollId).attr('action'),
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
                        $('#poll-section-'+pollId).html(result);
                    }
                }
            });
        }
    </script>
@endsection