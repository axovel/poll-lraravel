@extends('layouts.admin-dashboard')

@section('content')
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Poll Details</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-eye fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$poll->PollDisplayHistory->count()}}</div>
                                    <div>Total Views!</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$poll->PollComment->count()}}</div>
                                    <div>Total Comments!</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bar-chart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$poll->PollVote->count()}}</div>
                                    <div>Total Reply</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Poll Engagement Statistic ({{$poll->pollEngagementPercentage()}}%)</div>
                        <div class="panel-body">
                            <div class="panel-body">
                                <canvas id="pollEngagementChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Poll Opinion Statistic</div>
                        <div class="panel-body">
                            <div class="panel-body">
                                <canvas id="pollOpinionChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Poll Details</div>
                        <div class="panel-body">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 control-label">Poll Title</label>

                                <div class="col-md-6">
                                    <span id="title" class="control-label">{{ $poll->title }}</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 control-label">Poll Category</label>

                                <div class="col-md-6">
                                    <span class="control-label">{{ $poll->pollCategory->title }}</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 control-label">Poll Start Date</label>

                                <div class="col-md-6">
                                    <span class="control-label">{{ $poll->poll_start_date }}</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 control-label">Poll End Date</label>

                                <div class="col-md-6">
                                    <span class="control-label">{{ $poll->poll_end_date }}</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 control-label">Description</label>

                                <div class="col-md-6">
                                    <span class="control-label">{{ $poll->description }}</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 control-label">Ad Banner Image</label>

                                <div class="col-md-6">
                                    <div class="image-preview">
                                        @if($poll->image == '')
                                            <img src="{{asset('images/no-image.png')}}" class="img-responsive">
                                        @else
                                            <img src="{{asset('media/images/ads/medium/'.$poll->image)}}" class="img-responsive">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 control-label">Is Multiselect ?</label>

                                <div class="col-md-8">
                                    <span class="control-label">{{$poll->is_multichoice==1 ? 'Yes' : 'No'}}</span>
                                </div>
                            </div>

                            @if($poll->is_multichoice==1)
                                <div class="form-group row">
                                    <label class="col-md-4 control-label">Options</label>
                                    <ul>
                                        @foreach($poll->pollOption->lists('value','id') as  $index => $pollOption)
                                            <li><span class="control-label">{{$pollOption}}</span></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('document').ready(function(){
            var pollEngagementChart = document.getElementById("pollEngagementChart");
            var pollOpinionChart = document.getElementById("pollOpinionChart");
            // For poll engagement chart

            jsonData = jQuery.parseJSON('<?php echo $pollData ?>');
            var pollEngagementData = {
                labels: [
                    "Total Vote",
                    "Poll Vote",
                ],
                datasets: [
                {
                    data: ["{{$poll->pollEngagementCount()}}", "{{$poll->pollVote->count()}}"],
                    backgroundColor: [
                        "#FF6384",
                        "#36A2EB",
                    ],
                    hoverBackgroundColor: [
                        "#FF6384",
                        "#36A2EB",
                    ]
                }]
            };

            //for poll opinion chart
            var pollOpinionData = {
                labels: jsonData.label,
                datasets: [
                    {
                        data: jsonData.data,
                        backgroundColor: [
                            "#FF6384",
                            "#36A2EB",
                        ],
                        hoverBackgroundColor: [
                            "#FF6384",
                            "#36A2EB",
                        ]
                    }]
            };

            var myPieChart = new Chart(pollEngagementChart,{
                type: 'pie',
                data: pollEngagementData,
            });

            var myPieChart = new Chart(pollOpinionChart,{
                type: 'pie',
                data: pollOpinionData,
            });
        })
    </script>
@endsection
