<?php

namespace App\Http\Controllers;

use App\RssFeedData;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\PollCategory;

use Auth;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Validator;

use Validate;

use Carbon\Carbon;

class RssFeedDataController extends Controller
{
    public $rssFeedData;

    public function __construct()
    {
        $this->rssFeedData = new RssFeedData();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rssFeeds = $this->rssFeedData->where('user_id', Auth::user()->id)->get();

        return view('admin.feed_data.list', compact('rssFeeds'));
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
        $data       = $request->all();
        $userId     = Auth::user()->id;
        $validation = Validator::make($data, $this->rssFeedData->rules($userId));

        if (!$validation->fails()) {
            $this->rssFeedData->addRssFeedData($data);
            return Redirect::back()->with('success', trans('messages.Feed saved'));
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
        //
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
        $rssFeed = $this->rssFeedData->find($id);

        if ($rssFeed->delete()) {
            $result['status']  = true;
            $result['message'] = trans("messages.feed has been deleted.");
            return json_encode($result);
        } else {
            $result['status'] = false;
            $result['message'] = trans("messages.feed could not deleted.");
            return json_encode($result);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createPoll(Request $request)
    {
        $input = $request->input();
        $pollCategories = PollCategory::where('is_active', 1)->lists('title', 'id');
        $today = Carbon::today()->toDateString();

        return view('admin.polls.add', compact('pollCategories', 'input', 'today'));
    }
}
