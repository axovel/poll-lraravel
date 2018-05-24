<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Poll;

use App\Http\Requests;

use App\PollCategory;

use App\PollVote;

use Carbon\Carbon;

use Validator;


class PollsController extends Controller
{

    public $poll;

    public $message;

    public function __construct()
    {
        $this->poll    = new Poll();
        $this->message = 'Poll';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $polls = $this->poll->all();
        } else {
            $polls = $this->poll->where('user_id', Auth::user()->id)->get();
        }

        $activePollCount   = $this->poll->getActivePollsCount();
        $inActivePollCount = $this->poll->getInactivePollsCount();

        return view('admin.polls.list', compact('polls', 'activePollCount', 'inActivePollCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pollCategories = PollCategory::where('is_active', 1)->lists('title', 'id');
        $today = Carbon::today()->toDateTimeString();

        return view('admin.polls.add', compact('pollCategories', 'today'));
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

        if ($data['is_banner']==1 && !isset($data['image'])) {
            return Redirect::back()->with('error', trans('Please Upload Image'));
        }

        $validation = Validator::make($data, $this->poll->rules(Auth::user()->id));

        if (!$validation->fails()) {

            $this->poll->addPoll($data);

            return Redirect::route('admin.poll.index')->with('success', trans('messages.added successfully', ['message'=>$this->message]));
        }

        return Redirect::route('admin.poll.create')->with('error', $validation->messages());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $poll          = $this->poll->find($id);
        $pollData      = $this->poll->getPollOpinionGraphData($poll);

        return view('admin.polls.view', compact('poll', 'pollVoteCount', 'pollData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $poll           = $this->poll->find($id);
        $pollCategories = PollCategory::lists('title', 'id');

        return view('admin.polls.edit', compact('poll', 'pollCategories'));
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
        $poll       = $this->poll->find($id);
        $data       = $request->all();

        $validation = Validator::make($data, $this->poll->rules(Auth::user()->id));

        if ($data['is_banner']==1 && !isset($data['image'])) {
            return Redirect::back()->with('error', trans('Please Upload Image'));
        }

        if($data['is_banner']==0)
        {
            $data['image'] = '';
        }

        if (!$validation->fails()) {
            $this->poll->editPoll($data, $poll);
            return Redirect::route('admin.poll.edit', $id)->with('success', trans('messages.updated successfully', ['message' => $this->message]));
        }

        return Redirect::route('admin.poll.edit', $id)->with('error', $validation->messages());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $poll = $this->poll->find($id);
        $poll->pollOption()->delete();

        if ($poll->pollComment()) {
            $poll->pollComment()->delete();
        }

        if ($poll->pollVote()) {
            $poll->pollVote()->delete();
        }

        if ($poll->pollDisplayHistory()) {
            $poll->pollDisplayHistory()->delete();
        }

        if ($poll->delete()) {
            $result['status']  = true;
            $result['message'] = trans("messages.poll has been deleted.");
            return json_encode($result);
        } else {
            $result['status'] = false;
            $result['message'] = trans("messages.poll could not deleted.");
            return json_encode($result);
        }
    }

    /**
     * @param $pollId
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postCastVote($pollId, Request $request)
    {
        $poll             = Poll::find($pollId);
        $pollVote         = new PollVote();
        $pollVoteResponse = $pollVote->addVote($poll, $request);
        return view('blocks.poll', compact('poll'));
    }
}
