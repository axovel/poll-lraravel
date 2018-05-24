<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\PollCategory;

use Illuminate\Support\Facades\Redirect;

use Validator;

class PollCategoriesController extends Controller
{

    public $pollCategory;

    public $message;

    /**
     * AdminPollCategoriesController constructor.
     */
    public function __construct()
    {
        $this->pollCategory = new PollCategory();
        $this->message      = "Poll Category";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pollCategories = $this->pollCategory->all();
        return view('admin.poll_categories.list', compact('pollCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.poll_categories.add');
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
        $validation = Validator::make($data, $this->pollCategory->rules());

        if (!$validation->fails()) {
            $this->pollCategory->addPollCategory($data);
            return Redirect::route('admin.poll-category.index')->with('success', trans('messages.added successfully', ['message' => $this->message]));
        }

        return Redirect::route('admin.poll-category.create')->with('error', $validation->messages());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pollCategory = $this->pollCategory->find($id);
        return view('admin.poll_categories.edit', compact('pollCategory'));
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
        $pollCategory = $this->pollCategory->find($id);
        $data         = $request->all();
        $validation   = Validator::make($data, $this->pollCategory->rules($id));

        if (!$validation->fails()) {
            $this->pollCategory->editPollCategory($data, $pollCategory);
            return Redirect::route('admin.poll-category.edit', $id)->with('success', trans('messages.information updated successfully', ['message' => $this->message]));
        }

        return Redirect::route('admin.poll-category.edit', $id)->with('error', $validation->messages());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pollCategory = $this->pollCategory->find($id);

        if ($pollCategory->delete()) {
            $result['status']  = true;
            $result['message'] = trans("messages.Category has been deleted.");
            return json_encode($result);
        } else {
            $result['status'] = false;
            $result['message'] = trans("messages.Category could not deleted.");
            return json_encode($result);
        }
    }
}
