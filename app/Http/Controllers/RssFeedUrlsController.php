<?php

namespace App\Http\Controllers;

use App\RssFeedData;

use App\RssFeedUrl;

use App\User;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Auth;

use Validator;

use Feeds;

class RssFeedUrlsController extends Controller
{

    /**
     * @var
     */
    public $rssFeedUrl;

    public $user;

    /**
     * RssFeedUrlsController constructor.
     */
    public function __construct()
    {
        $this->rssFeedUrl = new RssFeedUrl();
        $this->user       = new User();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rssFeedUrls = '';
        $users = $this->user->where('id', '!=', Auth::user()->id)->lists('first_name', 'id');

        if (Auth::user()->role == 'admin') {
            $rssFeedUrls = $this->rssFeedUrl->all();
        } else {
            $rssFeedUrls = $this->rssFeedUrl->where('user_id', Auth::user()->id)->get();
        }

        return view('admin.feed_urls.list', compact('rssFeedUrls', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user       = Auth::user();
        $data       = $request->all();
        $validation = Validator::make($data, $this->rssFeedUrl->rules($data['user_id']));

        if (!$validation->fails()) {
            $this->rssFeedUrl->addRssFeedUrl($data);
            return Redirect::route('admin.rss-feed-url.index')->with('success', trans('messages.RSS feed url added'));
        }

        return Redirect::back()->with('error', $validation->messages());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rssFeedUrl = $this->rssFeedUrl->find($id);

        $feed = Feeds::make($rssFeedUrl->url);
        $data = array(
            'title'     => $feed->get_title(),
            'permalink' => $feed->get_permalink(),
            'items'     => $feed->get_items(),
        );

        $totalFeedCount = RssFeedData::totalFeedCount();
        $totalTodayFeedCount = RssFeedData::totalTodayFeedCount();
        return view('admin.feed_urls.view', compact('data', 'rssFeedUrl', 'totalFeedCount', 'totalTodayFeedCount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rssFeedUrl = $this->rssFeedUrl->find($id);

        if ($rssFeedUrl->delete()) {
            $result['status']  = true;
            $result['message'] = trans("messages.feed url has been deleted.");
            return json_encode($result);
        } else {
            $result['status'] = false;
            $result['message'] = trans("messages.feed url could not deleted.");
            return json_encode($result);
        }
    }
}
