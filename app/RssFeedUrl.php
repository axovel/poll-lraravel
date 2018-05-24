<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

class RssFeedUrl extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['url','user_id'];

    /**
     * @param $userId
     * @return array
     */
    public function rules($userId)
    {
        // Url is unique per user
        $rules = ['url' => 'url|required|unique:rss_feed_urls,url,NULL,id,user_id,'.$userId];
        return $rules;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @param $data
     * @return bool
     */
    public function addRssFeedUrl($data)
    {
        if (isset($data['user_id'])) {
            RssFeedUrl::create(['url' => $data['url'], 'user_id' => $data['user_id']]);
        } else {
            RssFeedUrl::create(['url' => $data['url'], 'user_id' => Auth::user()->id]);
        }
        return true;
    }
}
