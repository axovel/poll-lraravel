<?php

namespace App\Http\Controllers;

use App\Ad;

use App\AdDisplayHistory;
use App\AdVisitor;

use App\PollCategory;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use Carbon\Carbon;

use Illuminate\Support\Facades\Redirect;

class AdController extends Controller
{

    public $ads;

    public $message;

    /**
     * PollsController constructor.
     */
    public function __construct()
    {
        $this->ads     = new Ad();
        $this->message = "Ad";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = $this->ads->all();
        return view('admin.ad.list', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $adCategories = PollCategory::where('is_active', '1')->lists('title', 'id');
        $today        = Carbon::today()->toDateString();
        return view('admin.ad.add', compact('adCategories', 'today'));
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
        $validation = Validator::make($data, $this->ads->rules);

        if (!$validation->fails()) {
            $this->ads->addAd($data);
            return Redirect::route('admin.ad.index')->with('success', trans('messages.created successfully', ['message'=>$this->message]));
        }

        return Redirect::route('admin.ad.create')->with('error', $validation->messages());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->ads          = $this->ads->find($id);

        $adVisitorCount     = $this->ads->adVisitor->count();
        $adDisplayData      = $this->ads->getAdDisplayGraphData($this->ads->id);
        $adVisitorData      = $this->ads->getAdImpressionGraphData($this->ads->id);
        $ads                = $this->ads;

        return view('admin.ad.view', compact('ads', 'adVisitorCount', 'adDisplayData', 'adVisitorData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ads          = $this->ads->find($id);
        $adCategories = PollCategory::where('is_active', '1')->lists('title', 'id');
        return view('admin.ad.edit', compact('ads', 'adCategories'));
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
        $ads        = $this->ads->find($id);
        $data       = $request->all();
        $validation = Validator::make($data, $this->ads->rules);

        if (!$validation->fails()) {
            $this->ads->editAd($data, $ads);
            return Redirect::route('admin.ad.edit', $id)->with('success', trans('messages.updated successfully', ['message'=>$this->message]));
        }

        return Redirect::route('admin.ad.edit', $id)->with('error', $validation->messages());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ads = $this->ads->find($id);

        if ($ads->delete()) {
            $result['status']  = true;
            $result['message'] = trans("messages.Ad has been deleted.");
            return json_encode($result);
        } else {
            $result['status'] = false;
            $result['message'] = trans("messages.Ad could not deleted.");
            return json_encode($result);
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return string
     */
    public function addDisplayHistory($id, Request $request)
    {
        $adDisplayHistory = new AdDisplayHistory();
        $adDisplayHistory->addDisplayHistory($id, $request);
        $result['status'] = true;
        return json_encode($result);
    }

    /**
     * @param $id
     * @param Request $request
     * @return string
     */
    public function adVisitorHistory($id, Request $request)
    {
        $adVisitorHistory = new AdVisitor();
        $adVisitorHistory->adVisitorHistory($id, $request);
        $result['status'] = true;
        return json_encode($result);
    }
}
