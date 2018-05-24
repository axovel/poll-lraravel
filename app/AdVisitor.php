<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdVisitor extends Model
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
     * @param $id
     * @param $request
     */
    public function adVisitorHistory($id, $request)
    {
        $this->create([
            'ad_id' => $id,
            'ip'    => $request->ip()
         ]);
    }
}
