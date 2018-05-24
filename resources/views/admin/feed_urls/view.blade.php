@extends('layouts.admin-dashboard')

@section('content')
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Read RSS Feed</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        @include('notification')
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-rss fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$totalFeedCount}}</div>
                                <div>Total Feeds Saved!</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-rss fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$totalTodayFeedCount}}</div>
                                <div>Feed Added Today!</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-rss fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{count($data['items'])}}</div>
                                <div>Total Feed In This Link</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Feed URL</div>
                    <div class="panel-body">
                        <form class="form-horizontal " role="form" method="POST" name="feedReader" action="" encryption="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input id="title" type="text" class="form-control" name="url" value="{{$rssFeedUrl->url}}">

                                    @if ($errors->has('url'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('url') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if(isset($data))
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Feed Data</div>
                        <div class="panel-body">
                            <div>
                                @foreach ($data['items'] as $item)
                                    <div class="item col-md-8">
                                        <h3><a href="{{ $item->get_permalink() }}" target="_blank">{{ $item->get_title() }}</a></h3>
                                        <p>{{ $item->get_description() }}</p>
                                        <p><small>Posted on {{ $item->get_date('j F Y | g:i a') }}</small></p>
                                    </div>
                                    <div class="col-md-2 item">
                                        <form action="{{ route('create-poll') }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="title" value="{{ $item->get_title() }}">
                                            <input type="hidden" name="description" value="{{ $item->get_description() }}">
                                            <button class="btn btn-default">Create Poll</button>
                                        </form>
                                    </div>
                                    <div class="col-md-2 item">
                                        <form action="{{ route('admin.rss-feed-data.store') }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="title" value="{{ $item->get_title() }}">
                                            <input type="hidden" name="description" value="{{ $item->get_description() }}">
                                            <input type="hidden" name="url" value="{{ $item->get_permalink() }}">
                                            <input type="hidden" name="pubDate" value="{{ $item->get_date() }}">
                                            <button class="btn btn-success">Save Feed</button>
                                        </form>
                                    </div>
                                @endforeach
                                @if(count($data['items']) == 0)
                                    <h3>There are no items from this feed url.</h3>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('document').ready(function(){
            
        });
    </script>
@endsection
