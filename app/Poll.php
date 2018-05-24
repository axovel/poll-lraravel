<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class Poll extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','poll_category_id','is_private','poll_code','title','slug','description','image','is_multichoice','is_approved','is_active','poll_start_date','poll_end_date'];

    public $activePollCount;

    public $inActivePollCount;

    /**
     * @param $userId
     * @return array
     */
    public function rules($userId)
    {
        $ruels = ['poll_category_id' => 'required',
                  'title'            => 'required|unique:polls,user_id,' . $userId
        ];

        return $ruels;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pollCategory()
    {
        return $this->belongsTo('App\PollCategory');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pollOption()
    {
        return $this->hasMany('App\PollOption');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pollVote()
    {
        return $this->hasMany('App\PollVote');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pollComment()
    {
        return $this->hasMany('App\PollComment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pollDisplayHistory()
    {
        return $this->hasMany('App\PollDisplayHistory');
    }

    /**
     * @param $data
     */
    public function addPoll($data)
    {
        if(!isset($data['image'])) {
            $data['image'] = '';
        }

        $poll = Poll::create([
            'user_id'          => Auth::user()->id,
            'poll_category_id' => $data['poll_category_id'],
            'title'            => $data['title'],
            'description'      => $data['description'],
            'is_multichoice'   => $data['is_multichoice'],
            'is_active'        => 1,
            'is_approved'      => 1,
            'is_private'       => $data['is_private'],
            'poll_start_date'  => $data['poll_start_date'],
            'poll_end_date'    => $data['poll_end_date'],
            'image'            => $data['image']
        ]);

        if($data['image'] !='') {
            $imageProcessor = new ImageProcessor();
            $imageProcessor->generateThumbnail($data['image']);
        }

        $poll->slug = Helper::slug($data['title']);
        $poll->save();

        if ($data['is_multichoice']==1) {
            foreach (array_filter($data['pollOptions']) as $pollOptionValue) {
                PollOption::create([
                    'poll_id' => $poll->id,
                    'value'   => $pollOptionValue
                ]);
            }
        } else {
            $pollOptions = [['poll_id' => $poll->id, 'value' => 'Yes'], ['poll_id' => $poll->id, 'value' => 'No']];

            foreach ($pollOptions as $pollOption) {
                PollOption::create($pollOption);
            }
        }
    }

    /**
     * @param $data
     * @param $poll
     */
    public function editPoll($data, $poll)
    {
        $poll->title            = $data['title'];
        $poll->poll_category_id = $data['poll_category_id'];
        $poll->description      = $data['description'];
        $poll->poll_start_date  = $data['poll_start_date'];
        $poll->poll_end_date    = $data['poll_end_date'];
        $poll->is_private       = $data['is_private'];

        if ($data['is_multichoice']==1) {
            if ($data['pollOptions']!==$poll->pollOption()->lists('value')->toArray()) {
                $poll->pollVote()->delete();
                $poll->pollOption()->delete();
                foreach (array_filter($data['pollOptions']) as $pollOption) {
                    PollOption::create([
                        'poll_id' => $poll->id,
                        'value'   => $pollOption
                    ]);
                }
            }
        } else {
            if ($poll->is_multichoice!=$data['is_multichoice']) {
                $poll->pollVote()->delete();
                $poll->pollOption()->delete();
                $pollOptions = [['poll_id' => $poll->id, 'value' => 'Yes'], ['poll_id' => $poll->id, 'value' => 'No']];
                foreach ($pollOptions as $pollOption) {
                    PollOption::create($pollOption);
                }
            }
        }

        $poll->slug           = Helper::slug($data['title']);
        $poll->is_multichoice = $data['is_multichoice'];

        if ($data['is_banner'] == 0)
        {
            $poll->image = '';
        }

        if ($poll->image != $data['image'] && $data['image'] != '') {

            $poll->image    = $data['image'];
            $imageProcessor = new ImageProcessor();
            $imageProcessor->generateThumbnail($data['image']);
        }

        $poll->save();
    }

    /**
     * @param $poll
     * @param $pollOption
     * @return float
     */
    public function getPollVotePercentage($poll, $pollOption)
    {
        $pollVotePercentage = 0;

        if ($poll->pollVote->count()) {
            $pollVotePercentage = $pollOption->pollVote->count() * 100 / $poll->pollVote->count();
            return number_format($pollVotePercentage, 2);
        }

        return $pollVotePercentage;
    }

    /**
     * @param $poll
     * @return array
     */
    public function getPollOpinionGraphData($poll)
    {
        $pollData             = [];
        $pollVotePercentage   = 0;
        $pollData['data'][0]  = '';
        $pollData['label'][0] = '';

        foreach ($poll->pollOption as $key => $pollOption) {
            $pollData['data'][$key] = 0;

            if ($poll->pollVote->count()) {
                $pollData['data'][$key] = $pollOption->pollVote->count();
                $pollVotePercentage     = number_format($pollOption->pollVote->count() * 100 / $poll->pollVote->count(), 2);
            }

            $pollData['label'][$key] = $pollOption->value.' ('.$pollVotePercentage.'%)';
        }

        return \GuzzleHttp\json_encode($pollData);
    }

    /**
     * @return mixed
     */
    public function getActivePollsCount()
    {
        if (Auth::user()->role=='admin') {
            $this->activePollCount = Poll::where('is_active', '1')->whereDate('poll_end_date', '>=', Carbon::today()->toDateString())->count();
            return $this->activePollCount;
        }

        $this->activePollCount = Poll::where('is_active', '1')->where('user_id', Auth::user()->id)->whereDate('poll_end_date', '>=', Carbon::today()->toDateString())->count();

        return $this->activePollCount;
    }

    /**
     * @return mixed
     */
    public function getInactivePollsCount()
    {
        if (Auth::user()->role=='admin') {
            $this->inActivePollCount = Poll::where('is_active', '0')->orWhereDate('poll_end_date', '<', Carbon::today()->toDateString())->count();
            return $this->activePollCount;
        }

        $this->inActivePollCount = Poll::where('is_active', '0')->orWhere('is_active', '1')->where('user_id', Auth::user()->id)->whereDate('poll_end_date', '<', Carbon::today()->toDateString())->count();

        return $this->inActivePollCount;
    }

    /**
     * @return array
     */
    public function getPollData($data)
    {
        $pollData             = [];
        $months               = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        $pollData['data'][0]  = '';
        $pollData['label'][0] = '';

        if (empty($data) || $data['action'] == 'y') {
            $i=0;
            for ($month = 1; $month <=12; $month++) {
                if (Auth::user()->role == 'admin') {
                    $pollData['data'][$i] = Poll::whereMonth('created_at', '=', $month)->count();
                } else {
                    $pollData['data'][$i] = Poll::where('user_id', Auth::user()->id)->whereMonth('created_at', '=', $month)->count();
                }
                $i++;
            }
            foreach($months as $key => $month)
            {
                $pollData['label'][$key] = $month;
            }
        } else {
            $dates = $this->generateDateRange($data['start_date'], $data['end_date']);
            foreach($dates as $key => $date) {
                if (Auth::user()->role == 'admin') {
                    $pollData['data'][$key] = $this->whereDate('created_at', '=', $date)->count();
                } else {
                    $pollData['data'][$key] = $this->where('user_id', Auth::user()->id)->whereDate('created_at', '=', $date)->count();
                }
                $pollData['label'][$key] = Carbon::parse($date)->toFormattedDateString();
            }
        }

        return \GuzzleHttp\json_encode($pollData);
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
        $dates     = [];

        while ($startDate->lte($endDate)) {
            $dates[] = $startDate->toDateString();
            $startDate->addDay();
        }

        return $dates;
    }

    /**
     * @param $take
     * @return mixed
     */
    public function getTopPolls($take)
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                $topPolls = Poll::where('is_active', 1)->withCount('pollVote')->orderBy('poll_vote_count', 'DESC')->take($take)->get();
                return $topPolls;
            } else {
                $topPolls = Poll::where('is_active', 1)->where('user_id', Auth::user()->id)->withCount('pollVote')->orderBy('poll_vote_count', 'DESC')->take($take)->get();
                return $topPolls;
            }
        } else {
            $topPolls = Poll::where('is_active', 1)->where('is_private', 0)->withCount('pollVote')->orderBy('poll_vote_count', 'DESC')->take($take)->get();
            return $topPolls;
        }
    }

    /**
     * @return string
     */
    public function pollEngagementPercentage()
    {
        $engagementPercentage = 0;
        $totalPollVoteCount   = $this->pollEngagementCount();
        if ($totalPollVoteCount) {
            $engagementPercentage = number_format(($this->pollVote->count() * 100 / $totalPollVoteCount), 2);
        }
        return $engagementPercentage;
    }

    /**
     * @return mixed
     */
    public function pollEngagementCount()
    {
        $totalPollVoteCount = PollVote::whereDate('created_at', '>=', $this->poll_start_date )->whereDate('created_at', '<=', $this->poll_end_date)->count();

        return $totalPollVoteCount;
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        if (Carbon::today()->toDateString() > $this->poll_end_date) {
            return true;
        }
        return false;
    }

    /**
     * @param $data
     * @return string
     */
    public function getPollEngagementData($data)
    {
        $pollData = [];
        $months   = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        if (empty($data) || $data['action'] == 'y') {
            $i=0;
            for ($month = 1; $month <=12; $month++) {
                if (Auth::user()->role == 'admin') {
                    $pollData['data'][$i] = PollVote::whereMonth('created_at', '=', $month)->count();
                } else {
                    $pollData['data'][$i] = PollVote::where('user_id', Auth::user()->id)->whereMonth('created_at', '=', $month)->count();
                }
                $i++;
            }
            foreach($months as $key => $month)
            {
                $pollData['label'][$key] = $month;
            }
        } else {
            $dates = $this->generateDateRange($data['start_date'], $data['end_date']);
            foreach($dates as $key => $date) {
                if (Auth::user()->role == 'admin') {
                    $pollData['data'][$key] = PollVote::whereDate('created_at', '=', $date)->count();
                } else {
                    $pollData['data'][$key] = PollVote::where('user_id', Auth::user()->id)->whereDate('created_at', '=', $date)->count();
                }
                $pollData['label'][$key] = Carbon::parse($date)->toFormattedDateString();
            }
        }

        return \GuzzleHttp\json_encode($pollData);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getPolls()
    {
        if (Auth::user()->role=='admin') {
            $polls = $this->all();
            return $polls;
        } else {
            $polls = $this->where('user_id', Auth::user()->id);
            return $polls;
        }
    }
}
