<?php

namespace App;

use Auth;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class RssFeedData extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rss_feed_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','url','title','description','pubDate'];

    /**
     * @param $userId
     * @return array
     */
    public function rules($userId)
    {
        // Url is unique per user
        $rules = ['title' => 'required|unique:rss_feed_data,title,NULL,id,user_id,'.$userId];
        return $rules;
    }

    /**
     * @param $data
     * @return bool
     */
    public function addRssFeedData($data)
    {
        $pubDate =  Carbon::parse($data['pubDate']);
        RssFeedData::create([
            'url'         => $data['url'],
            'user_id'     => Auth::user()->id,
            'title'       => $data['title'],
            'description' => $data['description'],
            'pubDate'     => $pubDate->toDateTimeString()
        ]);
        return true;
    }

    /**
     * @return mixed
     */
    public static function totalFeedCount()
    {
        $totalFeedCount = 0;
        if (Auth::user()->role == 'admin') {
            $totalFeedCount = RssFeedData::all();
        } else {
            $totalFeedCount = RssFeedData::where('user_id', Auth::user()->id);
        }
        return $totalFeedCount->count();
    }

    /**
     * @return mixed
     */
    public static function totalTodayFeedCount()
    {
        $totalFeedCount = 0;
        if (Auth::user()->role == 'admin') {
            $totalFeedCount = RssFeedData::whereDate('created_at', '=', Carbon::today()->toDateString());
        } else {
            $totalFeedCount = RssFeedData::where('user_id', Auth::user()->id)->whereDate('created_at', '=', Carbon::today()->toDateString());
        }
        return $totalFeedCount->count();
    }
}
