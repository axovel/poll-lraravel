<?php

namespace App\Http\Controllers;

use App\RssFeedData;
use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;

use Event;

use App\Events\OnRegisterEvent;

use App\User;

use App\Poll;

use Auth;

use Validator;

use App\PollComment;

class UsersController extends Controller
{

    public $user;

    public $message;

    public function __construct()
    {
        $this->user    = new User();
        $this->message = 'User';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $totalUsers = $this->user->totalUser();
        $totalTodayUsers  = $this->user->totalTodayUser();
        return view('admin.users.list', compact('users', 'totalUsers', 'totalTodayUsers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // make a new validator object
        $validation = Validator::make($data, $this->user->rules('', $data));

        if (!$validation->fails()) {
            $this->user->addUser($data);
            return Redirect::route('admin.user.index')->with('success', trans('messages.added successfully', ['message' => $this->message]));
        }

        return Redirect::route('admin.user.create')->with('error', $validation->messages());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->find($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user       = $this->user->find($id);
        $data       = $request->all();
        $validation = Validator::make($data, $this->user->rules($id, $data));

        if (!$validation->fails()) {
            $this->user->editUser($user, $data);
            return Redirect::route('admin.user.edit', $id)->with('success', trans('messages.information updated successfully', ['message'=>$this->message]));
        }

        return Redirect::route('admin.user.edit', $id)->with('error', $validation->messages());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->user->find($id);

        if ($user->delete()) {
            $result['status']  = true;
            $result['message'] = trans("messages.user has been deleted.");
            return json_encode($result);
        } else {
            $result['status'] = false;
            $result['message'] = trans("messages.user could not deleted.");
            return json_encode($result);
        }
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {
        $user = User::whereEmail($request->input('email'))->first();
        if ($user) {
            if (!$user->is_confirmed) {

                $user->confirmation_code = md5(time());
                $user->save();

                Event::fire(new OnRegisterEvent($user));

                auth()->logout();
                return back()->with('warning', trans('messages.You need to confirm your account. We have again sent you an activation code on your registered email. Kindly check it.'));
            }

            if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
                return Redirect::route('admin.dashboard');
            }
        }

        return back()->with('error', trans('These credentials do not match our records.'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDashboard(Request $request)
    {
        $data         = $request->all();
        $pageTitle    = 'Dashboard - User';
        $poll         = new Poll();
        $polls        = $poll->where('user_id', Auth::user()->id);
        $pollComments = PollComment::whereIn('poll_id',$polls->lists('id'))->count();
        $feeds        = RssFeedData::where('user_id', Auth::user()->id);
        $pollData     = $poll->getPollData($data);

        return view('users.dashboard', compact('pageTitle', 'polls', 'pollComments', 'feeds', 'pollData'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getResetPassword()
    {
        return view('admin.auth.reset-password');
    }

    /**
     * @param Request $request
     */
    public function postResetPassword(Request $request)
    {
        $data       = $request->all();
        $validation = Validator::make($data, ['password' => 'required|confirmed',]);

        if (!$validation->fails()) {
            Auth::user()->password =  bcrypt($data['password']);
            Auth::user()->save();
            return Redirect::route('reset-password')->with('success', trans('messages.Password has been changed'));
        }

        return Redirect::route('reset-password')->with('error', $validation->messages());
    }
}
