<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdDisplayHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ip','ad_id'];

    /**
     * @var array
     */
    public $rules = [
        'ad_id'=>'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ads()
    {
        return $this->belongsTo('App\Ad');
    }

    /**
     * @param $adId
     * @param $request
     */
    public function addDisplayHistory($adId, $request)
    {
        $this->create([
            'ad_id' => $adId,
            'ip'    => $request->ip()
        ]);
    }
}


