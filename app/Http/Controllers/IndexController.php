<?php

namespace App\Http\Controllers;

use App\AdDisplayHistory;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Poll;

use App\PollCategory;

use App\PollDisplayHistory;

use Carbon\Carbon;

use Mail;

use App\Ad;

use App\User;

class IndexController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $pageTitle = "Home Page";
        $polls     = Poll::where(['is_active' => '1', 'is_private' => 0])->orderBy('created_at', 'desc')->get();
        $today     = Carbon::today()->toDateString();
        return view('index', compact('pageTitle', 'polls', 'today'));
    }

    /**
     * @param $slug
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDetailPage($slug, Request $request)
    {
        $pollCategory = PollCategory::where('slug', $slug)->first();

        if ($pollCategory) {
            $pageTitle = $pollCategory->title;
            $polls     = Poll::where(['is_active' => 1, 'poll_category_id' => $pollCategory->id, 'is_private' => 0])->orderBy('created_at', 'desc')->get();
            return view('index', compact('polls', 'pageTitle'));
        }

        $user = User::where('slug', $slug)->first();
        if ($user) {
            $polls     = Poll::where(['is_active' => 1, 'user_id' => $user->id])->orderBy('created_at', 'desc')->get();
            $pageTitle = $user->first_name;
            return view('index', compact('polls', 'pageTitle'));
        }

        $poll               = Poll::where('slug', $slug)->first();
        $adCategoryId       = $poll->pollCategory->id;
        $ads                = Ad::where('ad_category_id', $adCategoryId)->where('is_active', 1)->whereDate('end_date', '>=', Carbon::today()->toDateString())->inRandomOrder()->first();
        $pageTitle          = $poll->title;

        $pollDisplayHistory = new PollDisplayHistory();
        $pollDisplayHistory->addPollView($poll->id, $request);

        if($ads) {
            $addDisplayHistory = new AdDisplayHistory();
            $addDisplayHistory->addDisplayHistory($ads->id, $request);
        }

        return view('view', compact('pageTitle', 'poll', 'ads'));
    }

    public function jsonCheck(Request $request)
    {
        return \GuzzleHttp\json_encode('hello');
    }
}
