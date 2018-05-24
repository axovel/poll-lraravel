<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\PollComment;

use Illuminate\Support\Facades\Redirect;

use Validator;

class PollCommentsController extends Controller
{

    public $pollComment;

    public $message;

    /**
     * PollCommentsController constructor.
     */
    public function __construct()
    {
        $this->pollComment = new PollComment();
        $this->message     = "Comment";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pollComments = $this->pollComment->getPollComment();
        $totalComment = $this->pollComment->totalComment();
        $totalTodayComment = $this->pollComment->totalTodayComment();
        return view('admin.poll_comments.list', compact('pollComments','totalComment','totalTodayComment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pollId      = $request->input('poll_id');
        $pollComment = $this->pollComment->addComment($pollId, $request);

        return view('blocks.comment_list', compact('pollComment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pollComment = $this->pollComment->find($id);

        return view('admin.poll_comments.edit', compact('pollComment'));
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
        $pollComment = $this->pollComment->find($id);
        $validation  = Validator::make($request->all(), $this->pollComment->rules);

        if (!$validation->fails()) {
            $this->pollComment->editPollComment($request, $pollComment);
            return Redirect::route('admin.poll-comments.edit', $id)->with('success', trans('messages.updated successfully', ['message' => $this->message]));
        }

        return Redirect::route('admin.poll-comments.edit', $id)->with('error', $validation->messages());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pollComment = $this->pollComment->find($id);

        if ($pollComment->delete()) {
            $result['status']  = true;
            $result['message'] = trans("messages.comment has been deleted.");
            return json_encode($result);
        } else {
            $result['status'] = false;
            $result['message'] = trans("messages.comment could not deleted.");
            return json_encode($result);
        }
    }
}
