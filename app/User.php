<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Event;

use App\Events\OnRegisterEvent;

use Carbon\Carbon;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role', 'first_name', 'slug', 'last_name', 'email', 'password','gender','born','address','city','country','confirmation_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pollComment()
    {
        return $this->hasMany('App\PollComment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poll()
    {
        return $this->hasMany('App\Poll');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rssFeedUrl()
    {
        return $this->hasMany('App\RssFeedUrl');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rssFeedData()
    {
        return $this->hasMany('App\RssFeedData');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ads()
    {
        return $this->hasMany('App\Ad');
    }

    /**
     * @param string $userId
     * @param $data
     * @return array
     */

    public function rules($userId = '', $data)
    {
        $rules = [
            'first_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$userId,
            'password' => 'required|min:6|confirmed',
            'role'  => 'required',
        ];
        if ($data['password']=='') {
            unset($rules['password']);
        }
        return $rules;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function addUser($data)
    {
        $user = User::create([
            'first_name'        => $data['first_name'],
            'last_name'         => $data['last_name'],
            'email'             => $data['email'],
            'address'           => $data['address'],
            'gender'            => $data['gender'],
            'born'              => $data['born'],
            'city'              => $data['city'],
            'country'           => $data['country'],
            'role'              => $data['role'],
            'password'          => bcrypt($data['password']),
            'confirmation_code' => md5(time()),
        ]);

        $user->slug = mt_rand('100000', '999999').$user->id;
        $user->save();

        Event::fire(new OnRegisterEvent($user));

        return true;
    }

    /**
     * @param $user
     * @param $data
     */
    public function editUser($user, $data)
    {
        $user->first_name = $data['first_name'];
        $user->last_name  = $data['last_name'];
        $user->email      = $data['email'];
        $user->address    = $data['address'];
        $user->gender     = $data['gender'];
        $user->born       = $data['born'];
        $user->city       = $data['city'];
        $user->country    = $data['country'];
        $user->role       = $data['role'];
        if ($data['password']!='') {
            $user->password = bcrypt($data['password']);
        }
        $user->save();
    }

    /**
     * @return mixed
     */
    public static function totalUser()
    {
        $user = User::all();
        return $user->count();
    }

    /**
     * @return mixed
     */
    public static function totalTodayUser()
    {
        $user = PollComment::whereDate('created_at', '=', Carbon::today()->toDateString());
        return $user->count();
    }
}
