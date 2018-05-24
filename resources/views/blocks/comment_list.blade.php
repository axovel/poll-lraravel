<div class="header">
    <strong class="primary-font">{{$pollComment->user()->first()->first_name.' '.$pollComment->user()->first()->last_name}}</strong>
    <small class="pull-right text-muted">
        <i class="fa fa-clock-o fa-fw"></i> {{$pollComment->created_at->diffForHumans()}}
    </small>
</div>
<span class="poll-comment">{{$pollComment->comment}}</span>
<hr>