<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','is_active'];

    /**
     * @param string $pollCategoryId
     * @return array
     */
    public function rules($pollCategoryId = '')
    {
        $rules = [
            'title' => 'required|max:255|unique:poll_categories,id,'.$pollCategoryId,
        ];

        return $rules;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ads()
    {
        return $this->belongsTo('App\Ad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poll()
    {
        return $this->belongsTo('App\Poll');
    }

    /**
     * @param $data
     * @return mixed
     */
    public function addPollCategory($data)
    {
        $pollCategory = PollCategory::create([
            'title'     => $data['title'],
            'is_active' => $data['is_active']
        ]);

        $pollCategory->slug = Helper::slug($data['title']);
        $pollCategory->save();
    }

    /**
     * @param $data
     * @param $pollCategory
     */
    public function editPollCategory($data, $pollCategory)
    {
        $pollCategory->title     = $data['title'];
        $pollCategory->slug      = Helper::slug($data['title']);
        $pollCategory->is_active = Helper::slug($data['is_active']);

        $pollCategory->save();
    }
}
