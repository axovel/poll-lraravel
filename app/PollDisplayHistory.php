<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PollDisplayHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ip','poll_id'];

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
     * @param $pollId
     * @param $request
     */
    public function addPollView($pollId, $request)
    {
        $pollDisplayHistory = PollDisplayHistory::where('poll_id', $pollId)->whereDate('created_at', '=', Carbon::today()->toDateString())->count();

        if ($pollDisplayHistory==0) {
            PollDisplayHistory::create([
                'poll_id' => $pollId,
                'ip' => $request->ip()
            ]);
        }
    }
}
