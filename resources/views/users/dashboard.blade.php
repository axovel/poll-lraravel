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
                                    <div class="huge">{{$pollComments}}</div>
                                    <div>New Comments!</div>
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
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$polls->count()}}</div>
                                    <div>Total Polls !</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('user.poll.index')}}">
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
                                    <i class="fa fa-rss fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$feeds->count()}}</div>
                                    <div>Total Feed!</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('user.rss-feed-data.index')}}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
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
                                <form name="total-polls-frm" action="{{route('user.dashboard')}}" method="get">
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
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <script>
        var pollJsonData = jQuery.parseJSON('<?php echo $pollData;?>');
        var ctxPoll      = document.getElementById("pollChart");
        var pollLabel    = pollJsonData.label;
        var data = {
            labels: pollLabel,
            datasets: [
                {
                    label: "Total Poll Created",
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
        })
    </script>
@endsection
