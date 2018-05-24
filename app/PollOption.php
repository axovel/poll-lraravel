<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['poll_id','value'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poll()
    {
        return $this->belongsTo('App\Poll');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pollVote()
    {
        return $this->hasMany('App\PollVote');
    }


    /**
     * @param $pollOptions
     * @param $pollId
     */
    public function addPollOptions($pollOptions, $pollId)
    {
        foreach ($pollOptions as $pollOption) {
            $pollOptions::create([
                'poll_id' => $pollId,
                'value' => $pollOption
            ]);
        }
    }
}
