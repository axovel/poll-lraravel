<?php

namespace App\Http\Controllers\Auth;

use Event;

use App\Events\OnRegisterEvent;

use App\User;

use Validator;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\ThrottlesLogins;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;

use Socialite;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Overwrite default register method. Prevent loggging users in without confirmation
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = $this->create($request->all());

        return redirect('login')->with('success', trans('messages.We sent you an activation code. Check your email.'));
    }

    /**
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticated(Request $request, $user)
    {
        if (!$user->is_confirmed) {
            
            $user->confirmation_code = md5(time());
            $user->save();
            
            Event::fire(new OnRegisterEvent($user));

            auth()->logout();
            return back()->with('warning', trans('messages.You need to confirm your account. We have again sent you an activation code on your registered email. Kindly check it.'));
        }
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name'        => $data['first_name'],
            'last_name'         => $data['last_name'],
            'email'             => $data['email'],
            'password'          => bcrypt($data['password']),
            'role'              => 'user',
            'confirmation_code' => md5(time()),
        ]);

        $user->slug = mt_rand('100000', '999999').$user->id;
        $user->save();

        Event::fire(new OnRegisterEvent($user));

        return $user;
    }

    /**
     * @param $code
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function confirm($code)
    {
        if(!$code)
        {
            return redirect('login')->with('error', trans('messages.Invalid confirmation code'));
        }

        $user = User::where('confirmation_code', $code)->first();

        if (!$user)
        {
            return redirect('login')->with('error', trans('messages.Invalid user or confirmation code'));
        }

        $user->is_confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        return redirect('login')->with('success', trans('messages.You have successfully verified your account.'));
    }

    /**
     * Redirect the user to the social provider authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from social provider.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return Redirect::to('/auth/login');
        }

        $authUser = $this->findOrCreateUser($user, $provider);

        auth()->login($authUser, true);

        return redirect()->to('/');
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $socialLiteUser
     * @param $key
     * @return User
     */
    private function findOrCreateUser($socialLiteUser, $key)
    {
        $user = User::updateOrCreate([
            'email' => $socialLiteUser->email,
        ], [
            $key . '_id' => $socialLiteUser->id,
            'first_name' => $socialLiteUser->name
        ]);

        return $user;
    }
}
