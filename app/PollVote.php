<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

class PollVote extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','ip','poll_option_id','poll_id'];

    /**
     * @var array
     */
    public $rules = [
                        'poll_id'=>'required'
                    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poll()
    {
        return $this->belongsTo('App\Poll');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pollOption()
    {
        return $this->belongsTo('App\PollVot');
    }

    /**
     * @param $poll
     * @param $request
     * @return bool
     */
    public function addVote($poll, $request)
    {
        $data     = $request;
        $pollVote = PollVote::where(['poll_id'=>$poll->id,'ip'=> $request->ip()])->count();
        if ($pollVote==0) {
            PollVote::create([
                'poll_id' => $poll->id,
                'poll_option_id' => $data['poll_option_id'],
                'ip' => $request->ip(),
                'user_id' => Auth::check() ? Auth::user()->id : null,
            ]);
            return true;
        }

        return false;
    }
}
