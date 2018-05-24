<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class PollComment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','poll_id','comment','ip'];

    /**
     * @var array
     */
    public $rules = [
        'poll_id' => 'required',
        'user_id' => 'required',
        'comment' => 'required'
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
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @param $pollId
     * @param $request
     * @return mixed
     */
    public function addComment($pollId, $request)
    {
        $data        = $request->all();
        $pollComment = PollComment::create([
                        'poll_id' => $pollId,
                        'user_id' => Auth::user()->id,
                        'comment' => $data['comment'],
                        'ip' => $request->ip()
                    ]);
        return $pollComment;
    }

    /**
     * @param $request
     * @param $pollComment
     */

    public function editPollComment($request, $pollComment)
    {
        $data                 = $request->all();
        $pollComment->comment = $data['comment'];
        $pollComment->save();
    }

    /**
     * @return mixed
     */
    public static function totalComment()
    {
        if (Auth::user()->role == 'admin') {
            $totalComment = PollComment::all();
            return $totalComment->count();
        } else {
            $pollIds      = Auth::user()->poll->lists('id');
            $totalComment = PollComment::whereIn('poll_id', $pollIds);
            return $totalComment->count();
        }
    }

    /**
     * @return mixed
     */
    public static function totalTodayComment()
    {
        if (Auth::user()->role == 'admin') {
            $totalComment = PollComment::whereDate('created_at', '=', Carbon::today()->toDateString());
            return $totalComment->count();
        } else {
            $pollIds      = Auth::user()->poll->lists('id');
            $totalComment = PollComment::whereIn('poll_id', $pollIds)->whereDate('created_at', '=', Carbon::today()->toDateString());
            return $totalComment->count();
        }
    }

    /**
     * @return int
     */
    public static function getPollComment()
    {
        if (Auth::user()->role == 'admin') {
            return PollComment::all();
        } else {
            $pollIds = Auth::user()->poll->lists('id');
            $pollComments = PollComment::whereIn('poll_id', $pollIds)->get();
            return $pollComments;
        }
    }
}
