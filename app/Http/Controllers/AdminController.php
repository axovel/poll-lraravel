<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use Illuminate\Support\Facades\Redirect;

use App\Poll;

use App\PollComment;

use App\User;

use App\Ad;

class AdminController extends Controller
{
    public $poll;

    public $ads;

    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->poll = new Poll();
        $this->ads   = new  Ad();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        $pageTitle = "Admin";
        return view('admin.auth.login', compact('pageTitle'));
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'role' => 'admin'])) {
            // Authentication passed...
            return Redirect::route('admin.dashboard');
        }

        return back()->with('error', trans('messages.These credentials do not match our records.'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDashboard(Request $request)
    {
        $data                   = $request->all();
        $pageTitle              = 'Dashboard - Admin';

        $polls                  = $this->poll->getPolls();
        $pollComments           = PollComment::getPollComment();
        $pollData               = $this->poll->getPollData($data);
        $pollEngagementData     = $this->poll->getPollEngagementData($data);
        $adImpressionData       = $this->ads->getAdImpressionData($data);

        $adDisplayHistoryData   = $this->ads->getAdDisplayHistory($data);
        $topPolls               = $this->poll->getTopPolls(5);
        $totalUsers             = User::all()->count();
        $totalAd                = $this->ads->all()->count();
        $topAds                 = $this->ads->getTopAds();
        $adData                 = $this->ads->getAdData($data);

        return view('admin.dashboard', compact('pageTitle', 'polls', 'pollComments', 'pollData', 'topPolls', 'totalUsers', 'totalAd', 'topAds', 'adData', 'pollEngagementData', 'adImpressionData', 'adDisplayHistoryData'));
    }
}
