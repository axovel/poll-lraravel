@extends('layouts.admin-dashboard')

@section('content')
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Ad Details</h1>
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
                                    <div class="huge">{{$ads->adDisplayHistory->count()}}</div>
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
                                    <i class="fa fa-mouse-pointer fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$ads->adVisitor->count()}}</div>
                                    <div>Total Impression Count!</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Ads Display Statistic</div>
                        <div class="panel-body">
                            <div class="panel-body">
                                <canvas id="adDisplayHistoryChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Ad Impression Statistics </div>
                        <div class="panel-body">
                            <div class="panel-body">
                                <canvas id="adVisitorChart"></canvas>
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
                                <label for="name" class="col-md-4 control-label">Ad Title</label>

                                <div class="col-md-6">
                                    <span id="title" class="control-label">{{ $ads->title }}</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 control-label">Ad Banner Image</label>

                                <div class="col-md-6">
                                    <div class="image-preview">
                                        <img src="{{asset('media/images/ads/medium/'.$ads->image)}}" class="img-responsive">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 control-label">Ad Category</label>

                                <div class="col-md-6">
                                    <span class="control-label">{{ $ads->adCategory->title }}</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 control-label">Ad Url</label>

                                <div class="col-md-6">
                                    <span class="control-label"><a href="{{ $ads->url }}" target="_blank">{{ $ads->url }}</a></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 control-label">Ad Start Date</label>

                                <div class="col-md-6">
                                    <span class="control-label">{{ $ads->start_date }}</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 control-label">Ad End Date</label>

                                <div class="col-md-6">
                                    <span class="control-label">{{ $ads->end_date }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('document').ready(function() {

            var ctx = document.getElementById("adDisplayHistoryChart");
            jsonData = jQuery.parseJSON('<?php echo $adDisplayData ?>');
            var data = {
                labels: jsonData.label,
                datasets: [
                    {
                        label: "Ad Display Statistic",
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
                        data: jsonData.data,
                        spanGaps: false,
                    }
                ]
            };
            var myLineChart = Chart.Line(ctx, {
                data: data,
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
                                labelString: 'Date'
                            }
                        }],
                        yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
                                steps: 10,
                                stepValue: 5,
                                max: jsonData.total
                            }
                        }]
                    },
                }
            });

            var ctx = document.getElementById("adVisitorChart");
            jsonData = jQuery.parseJSON('<?php echo $adVisitorData ?>');
            var data = {
                labels: jsonData.label,
                datasets: [
                    {
                        label: "Ads Impression Statistic",
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
                        data: jsonData.data,
                        spanGaps: false,
                    }
                ]
            };
            var myLineChart = Chart.Line(ctx, {
                data: data,
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
                                labelString: 'Date'
                            }
                        }],
                        yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
                                steps: 10,
                                stepValue: 5,
                                max: jsonData.total
                            }
                        }]
                    },
                }
            });
        });
    </script>
@endsection
