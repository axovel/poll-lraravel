@extends('layouts.admin-dashboard')

@section('content')
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$pollComments->count()}}</div>
                                    <div>New Comments!</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('admin.poll-comments.index')}}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$polls->count()}}</div>
                                    <div>Total Polls!</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('admin.poll.index')}}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-film fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$totalAd}}</div>
                                    <div>Total Ads!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                @if (Auth::user()->role == 'admin')
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{$totalUsers}}</div>
                                        <div>Total Users!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{route('admin.user.index')}}">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="page-header"><i class="fa fa-bar-chart-o fa-fw"></i> Top 5 Polls</h3>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    @if($topPolls->count())
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Poll List
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Vote Count</th>
                                                <th>Poll Engagement</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $index=1;?>
                                            @foreach($topPolls as $topPoll)
                                                <tr>
                                                    <td>{{$index}}</td>
                                                    <td><a href="{{route('admin.poll.show', $topPoll->id)}}">{{$topPoll->title}}</a></td>
                                                    <td>{{$topPoll->poll_vote_count}}</td>
                                                    <td>{{$topPoll->pollEngagementPercentage().'%'}}</td>
                                                </tr>
                                                <?php $index++;?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                    <!-- /.panel -->
                    @else
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Poll List
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <h4 class="text-center">There is no poll</h4>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- /.col-lg-6 -->

                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="page-header"><i class="fa fa-image" aria-hidden="true"></i> Top 5 Ads</h3>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    @if($topAds->count())
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Ads List
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>View Count</th>
                                            <th>Impression Count</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $index=1;?>
                                            @foreach($topAds as $topAd)
                                                <tr>
                                                    <td>{{$index}}</td>
                                                    <td><a href="{{route('admin.ad.show', $topAd->id)}}">{{$topAd->title}}</a></td>
                                                    <td>{{$topAd->adDisplayHistory->count()}}</td>
                                                    <td>{{$topAd->ad_visitor_count}}</td>
                                                </tr>
                                                <?php $index++;?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                    @else
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Ads List
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <h4 class="text-center">There is no Ads</h4>
                            </div>
                        </div>
                    @endif
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Number of Polls</h3>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Number Of Polls
                            <div class="pull-right graph-element col-md-6">
                                <form name="total-polls-frm" action="{{route('admin.dashboard')}}" method="get">
                                    <div class="col-md-4">
                                        <select name="action" id="select-month">
                                            <option value="0">Action</option>
                                            <option value="m">Monthly</option>
                                            <option value="y">Yearly</option>
                                        </select>
                                    </div>
                                    <div class="month hidden col-md-6">
                                            <input data-provide="datepicker" name="start_date" class="datepicker" value="" size="12" placeholder="start date">
                                            <input data-provide="datepicker" name="end_date" class="datepicker" value="" size="12" placeholder="end date">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="submit" name="submit" value="Go">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <canvas id="pollChart"></canvas>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Number of Ads</h3>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Number Of Ads
                            <div class="pull-right graph-element col-md-6">
                                <form name="total-ads-frm" action="{{route('admin.dashboard')}}" method="get">
                                    <div class="col-md-4">
                                        <select name="action" id="select-ad-month">
                                            <option value="0">Action</option>
                                            <option value="m">Monthly</option>
                                            <option value="y">Yearly</option>
                                        </select>
                                    </div>
                                    <div class="ad-month hidden col-md-6">
                                        <input data-provide="datepicker" name="start_date" class="datepicker" value="" size="12" placeholder="start date">
                                        <input data-provide="datepicker" name="end_date" class="datepicker" value="" size="12" placeholder="end date">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="submit" name="submit" value="Go">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <canvas id="adChart"></canvas>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
             </div>

            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Poll Engagement Statistic</h3>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Poll Engagement Statistic Data
                            <div class="pull-right graph-element col-md-6">
                                <form name="poll-statistic-frm" action="{{route('admin.dashboard')}}" method="get">
                                    <div class="col-md-4">
                                        <select name="action" id="select-poll-engagement-month">
                                            <option value="0">Action</option>
                                            <option value="m">Monthly</option>
                                            <option value="y">Yearly</option>
                                        </select>
                                    </div>
                                    <div class="poll-engagement-month hidden col-md-6">
                                        <input data-provide="datepicker" name="start_date" class="datepicker" value="" size="12" placeholder="start date">
                                        <input data-provide="datepicker" name="end_date" class="datepicker" value="" size="12" placeholder="end date">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="submit" name="submit" value="Go">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <canvas id="pollEngagementChart"></canvas>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Ad Engagement Statistic</h3>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Ad Engagement Statistic Data
                            <div class="pull-right graph-element col-md-6">
                                <form name="poll-statistic-frm" action="{{route('admin.dashboard')}}" method="get">
                                    <div class="col-md-4">
                                        <select name="action" id="select-ad-engagement-month">
                                            <option value="0">Action</option>
                                            <option value="m">Monthly</option>
                                            <option value="y">Yearly</option>
                                        </select>
                                    </div>
                                    <div class="poll-engagement-month hidden col-md-6">
                                        <input data-provide="datepicker" name="start_date" class="datepicker" value="" size="12" placeholder="start date">
                                        <input data-provide="datepicker" name="end_date" class="datepicker" value="" size="12" placeholder="end date">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="submit" name="submit" value="Go">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <canvas id="adEngagementChart"></canvas>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Ad Display History Statistic</h3>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Ad Display History Statistic Data
                            <div class="pull-right graph-element col-md-6">
                                <form name="poll-statistic-frm" action="{{route('admin.dashboard')}}" method="get">
                                    <div class="col-md-4">
                                        <select name="action" id="select-ad-display-month">
                                            <option value="0">Action</option>
                                            <option value="m">Monthly</option>
                                            <option value="y">Yearly</option>
                                        </select>
                                    </div>
                                    <div class="poll-engagement-month hidden col-md-6">
                                        <input data-provide="datepicker" name="start_date" class="datepicker" value="" size="12" placeholder="start date">
                                        <input data-provide="datepicker" name="end_date" class="datepicker" value="" size="12" placeholder="end date">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="submit" name="submit" value="Go">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <canvas id="adDisplayHistoryChart"></canvas>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
            </div>
        <!-- /#page-wrapper -->
        </div>
    {{--{{dd($pollData)}}--}}
    <!-- /#wrapper -->
</div>
    <script>
        var pollJsonData             = jQuery.parseJSON('<?php echo $pollData;?>');
        var adJsonData               = jQuery.parseJSON('<?php echo $adData;?>');
        var pollEngagementJsonData   = jQuery.parseJSON('<?php echo $pollEngagementData;?>');
        var adEngagementJsonData     = jQuery.parseJSON('<?php echo $adImpressionData;?>');
        var adDisplayHistoryJsonData = jQuery.parseJSON('<?php echo $adDisplayHistoryData;?>');

        var ctxPoll                 = document.getElementById("pollChart");
        var ctxAd                   = document.getElementById("adChart");
        var ctxPollEngagement       = document.getElementById("pollEngagementChart");
        var ctxAdEngagement         = document.getElementById("adEngagementChart");
        var ctxAdDisplayHistory     = document.getElementById("adDisplayHistoryChart");

        var pollLabel               = pollJsonData.label;
        var adLabel                 = adJsonData.label;
        var pollEngagementLabel     = pollEngagementJsonData.label;
        var adEngagementLabel       = adEngagementJsonData.label;
        var adDisplayHistoryLabel   = adDisplayHistoryJsonData.label;

        var pollData = {
            labels: pollLabel,
            datasets: [
                {
                    label: "Total Polls Created",
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: pollJsonData.data,
                    spanGaps: false,
                }
            ]
        };
        var myLineChart = Chart.Line(ctxPoll, {
            data: pollData,
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero: true,
                            steps: 10,
                            stepValue: 5,
                            max: 50
                        }
                    }]
                },
            }
        });

        var adData = {
            labels: adLabel,
            datasets: [
                {
                    label: "Total Ad Created",
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: adJsonData.data,
                    spanGaps: false,
                }
            ]
        };
        var myLineChart = Chart.Line(ctxAd, {
            data: adData,
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero: true,
                            steps: 10,
                            stepValue: 5,
                            max: 50
                        }
                    }]
                },
            }
        });

        var pollEngagementData = {
            labels: pollEngagementLabel,
            datasets: [
                {
                    label: "Poll Engagement Statistic",
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: pollEngagementJsonData.data,
                    spanGaps: false,
                }
            ]
        };
        var myLineChart = Chart.Line(ctxPollEngagement, {
            data: pollEngagementData,
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero: true,
                            steps: 10,
                            stepValue: 5,
                            max: 50
                        }
                    }]
                },
            }
        });

        var adEngagementData = {
            labels: adEngagementLabel,
            datasets: [
                {
                    label: "Ad Engagement Statistic",
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: adEngagementJsonData.data,
                    spanGaps: false,
                }
            ]
        };
        var myLineChart = Chart.Line(ctxAdEngagement, {
            data: adEngagementData,
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero: true,
                            steps: 10,
                            stepValue: 5,
                            max: 50
                        }
                    }]
                },
            }
        });

        var adDisplayHistoryData = {
            labels: adDisplayHistoryLabel,
            datasets: [
                {
                    label: "Ad DIsplay Statistic",
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: adDisplayHistoryJsonData.data,
                    spanGaps: false,
                }
            ]
        };
        var myLineChart = Chart.Line(ctxAdDisplayHistory, {
            data: adDisplayHistoryData,
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero: true,
                            steps: 10,
                            stepValue: 5,
                            max: 50
                        }
                    }]
                },
            }
        });

        $('.datepicker').datetimepicker({
            sideBySide:true,
            format: 'YYYY-MM-DD'
        });

        $('#select-month').change(function(){
            if ($(this).val()=='m') {
                $('.month').removeClass('hidden');
            } else {
                $('.month').addClass('hidden');
            }
        });

        $('#select-ad-month').change(function(){
            if ($(this).val()=='m') {
                $('.ad-month').removeClass('hidden');
            } else {
                $('.ad-month').addClass('hidden');
            }
        });

        $('#select-poll-engagement-month').change(function(){
            if ($(this).val()=='m') {
                $('.poll-engagement-month').removeClass('hidden');
            } else {
                $('.poll-engagement-month').addClass('hidden');
            }
        });
    </script>
@endsection
