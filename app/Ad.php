<?php

namespace App;

use Carbon\Carbon;

use App\AdDisplayHistory;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Ad extends Model
{
    protected $table = 'ad';

    protected $fillable = ['title','user_id','ad_category_id','image','url','code','is_active','start_date','end_date'];

    /**
     * @var array
     */
    public $rules = ['title' => 'required|max:255',
        'url' => 'required',
        'start_date' => 'required',
        'end_date' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function AdCategory()
    {
        return $this->belongsTo('App\PollCategory');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adDisplayHistory()
    {
        return $this->hasMany('App\AdDisplayHistory');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adVisitor()
    {
        return $this->hasMany('App\AdVisitor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @param $data
     */
    public function addAd($data)
    {
        $imageProcessor = new ImageProcessor();
        $imageProcessor->generateThumbnail($data['image']);
        Ad::create([
            'title'          => $data['title'],
            'user_id'        => Auth::user()->id,
            'ad_category_id' => $data['ad_category_id'],
            'url'            => $data['url'],
            'is_active'      => $data['is_active'],
            'start_date'     => $data['start_date'],
            'end_date'       => $data['end_date'],
            'image'          =>$data['image'],
        ]);
    }

    /**
     * @param $data
     * @param $ads
     */
    public function editAd($data, $ads)
    {
        $ads->title          = $data['title'];
        $ads->ad_category_id = $data['ad_category_id'];
        $ads->url            = $data['url'];
        $ads->is_active      = $data['is_active'];
        $ads->start_date     = $data['start_date'];
        $ads->end_date       = $data['end_date'];

        if ($ads->image!=$data['image']) {
            $ads->image     = $data['image'];
            $imageProcessor = new ImageProcessor();
            $imageProcessor->generateThumbnail($data['image']);
        }

        $ads->save();
    }

    /**
     * @return string
     */
    public function getAdDisplayGraphData($adId)
    {
        $adData               = [];
        $adData['data'][0]    = '';
        $adData['label'][0]   = '';
        $adDisplayHistoryData = AdDisplayHistory::select(DB::raw("DATE(created_at) as created_at"))->where('ad_id', $adId)->distinct()->get();

        foreach ($adDisplayHistoryData as $key => $adDisplayHistoryInfo) {
            $adData['data'][$key]  = $adDisplayHistoryInfo->where('ad_id', $adId)->whereDate(DB::raw("DATE(created_at)"), '=', $adDisplayHistoryInfo->created_at)->count();
            $adData['label'][$key] = $adDisplayHistoryInfo->created_at->toFormattedDateString();
        }
        
        $adData['total'] = $this->adDisplayHistory->count()+5;

        return \GuzzleHttp\json_encode($adData);
    }

    /**
     * @return string
     */
    public function getAdImpressionGraphData($adId)
    {
        $adData             = [];
        $adData['data'][0]  = '';
        $adData['label'][0] = '';
        $adVisitorData      = AdVisitor::select(DB::raw("DATE(created_at) as created_at"))->where('ad_id', $adId)->distinct()->get();

        foreach ($adVisitorData as $key => $adVisitorInfo) {
            $adData['data'][$key]  = $adVisitorInfo->where('ad_id', $adId)->whereDate(DB::raw("DATE(created_at)"), '=', $adVisitorInfo->created_at)->count();
            $adData['label'][$key] = $adVisitorInfo->created_at->toFormattedDateString();
        }

        $adData['total'] = $this->adVisitor->count()+5;

        return \GuzzleHttp\json_encode($adData);
    }

    /**
     * @return mixed
     */
    public function getTopAds()
    {
        $topAds =  Ad::where('is_active', 1)->withCount('adVisitor')->orderBy('ad_visitor_count', 'DESC')->take(5)->get();

        return $topAds;
    }

    /**
     * @return string
     */
    public function adEngagementPercentage()
    {
        $engagementPercentage = 0;
        $totalAddVisitorCount = PollVote::all()->count();
        if ($totalAddVisitorCount) {
            $engagementPercentage = number_format(($this->add_visitor_count * 100 / $totalAddVisitorCount), 2);
        }
        return $engagementPercentage;
    }

    /**
     * @return array
     */
    public function getAdData($data)
    {
        $adData = [];
        $months   = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        if (empty($data) || $data['action'] == 'y') {
            $i=0;
            for ($month = 1; $month <=12; $month++) {
                $adData['data'][$i] = Ad::whereMonth('created_at', '=', $month)->count();
                $i++;
            }
            foreach($months as $key => $month)
            {
                $adData['label'][$key] = $month;
            }
        } else {
            $dates = $this->generateDateRange($data['start_date'], $data['end_date']);
            foreach($dates as $key => $date) {
                $adData['data'][$key]  = $this->whereDate('created_at', '=', $date)->count();
                $adData['label'][$key] = Carbon::parse($date)->toFormattedDateString();
            }
        }

        return \GuzzleHttp\json_encode($adData);
    }

    /**
     * @return array
     */
    public function getAdImpressionData($data)
    {
        $adData = [];
        $months   = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        if (empty($data) || $data['action'] == 'y') {
            $i=0;
            for ($month = 1; $month <=12; $month++) {
                if (Auth::user()->role == 'admin') {
                    $adData['data'][$i] = AdVisitor::whereMonth('created_at', '=', $month)->count();
                } else {
                    $addIds  = Auth::user()->ads->lists('id');
                    $adData['data'][$i] = AdVisitor::whereIn('ad_id', $addIds)->whereMonth('created_at', '=', $month)->count();
                }
                $i++;
            }
            foreach($months as $key => $month)
            {
                $adData['label'][$key] = $month;
            }
        } else {
            $dates = $this->generateDateRange($data['start_date'], $data['end_date']);
            foreach($dates as $key => $date) {
                if (Auth::user()->role == 'admin') {
                    $adData['data'][$key] = AdVisitor::whereDate('created_at', '=', $date)->count();
                } else {
                    $addIds  = Auth::user()->ads->lists('id');
                    $adData['data'][$key] = AdVisitor::whereIn('ad_id', $addIds)->whereDate('created_at', '=', $date)->count();
                }
                $adData['label'][$key] = Carbon::parse($date)->toFormattedDateString();
            }
        }

        return \GuzzleHttp\json_encode($adData);
    }

    /**
     * @return array
     */
    public function getAdDisplayHistory($data)
    {
        $adData = [];
        $months   = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        if (empty($data) || $data['action'] == 'y') {
            $i=0;
            for ($month = 1; $month <=12; $month++) {
                if (Auth::user()->role == 'admin') {
                    $adData['data'][$i] = AdDisplayHistory::whereMonth('created_at', '=', $month)->count();
                } else {
                    $adIds              = Auth::user()->ads->lists('id');
                    $adData['data'][$i] = AdDisplayHistory::whereIn('ad_id', $adIds)->whereMonth('created_at', '=', $month)->count();
                }
                $i++;
            }

            foreach($months as $key => $month) {
                $adData['label'][$key] = $month;
            }
        } else {
            $dates = $this->generateDateRange($data['start_date'], $data['end_date']);
            foreach($dates as $key => $date) {
                if (Auth::user()->role == 'admin') {
                    $adData['data'][$key] = AdDisplayHistory::whereDate('created_at', '=', $date)->count();
                } else {
                    $adIds                = Auth::user()->ads->lists('id');
                    $adData['data'][$key] = AdDisplayHistory::whereIn('ad_id', $adIds)->whereDate('created_at', '=', $date)->count();
                }
                $adData['label'][$key] = Carbon::parse($date)->toFormattedDateString();
            }
        }

        return \GuzzleHttp\json_encode($adData);
    }

    /**
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array
     */
    private function generateDateRange($startDate, $endDate)
    {
        $startDate = Carbon::parse($startDate);
        $endDate   = Carbon::parse($endDate);
        $dates = [];

        while ($startDate->lte($endDate)) {
            $dates[] = $startDate->toDateString();
            $startDate->addDay();
        }

        return $dates;
    }
}
