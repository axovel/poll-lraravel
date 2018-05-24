<div class="poll-options">
    <p><span>Results of user vote</span></p>
    <ul>
        @foreach($poll->pollOption as $key => $pollOption)
            <?php $pollVotePercentage = $poll->getPollVotePercentage($poll, $pollOption);?>
            <li>
                <label for="{{$pollOption->id}}">{{$pollOption->value}}<span>({{$pollVotePercentage}}%</span>)</label>
                <div class="progress progress-striped active">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$pollVotePercentage}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$pollVotePercentage.'%'}}"></div>
                </div>
            </li>
        @endforeach
    </ul>
</div>

