<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use App\PollCategory;

use App\Poll;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $pollCategories = PollCategory::where('is_active', '1')->get();
        $poll           = new Poll();
        $topPolls       = $poll->getTopPolls(10);
        view()->share(['pollCategories' => $pollCategories, 'topPolls' => $topPolls]);
    }
}
