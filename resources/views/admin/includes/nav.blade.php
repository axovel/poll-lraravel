<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{url('admin/dashboard')}}">{{Auth::user()->first_name.' '.Auth::user()->last_name .' ('.Auth::user()->slug.')'}}</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li><a href="{{route('reset-password')}}"><i class="fa fa-gear fa-fw"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li><a href="{{url('logout')}}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                    <li>
                        <a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                @if(Auth::user()->role =='admin')
                    <li>
                        <a href="#"><i class="fa fa-user" aria-hidden="true"></i></i> Users <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{route('admin.user.create')}}">Add Users</a>
                            </li>
                            <li>
                                <a href="{{route('admin.user.index')}}">List Users</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-tasks" aria-hidden="true"></i></i> Polls<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{route('admin.poll.create')}}">Add Poll</a>
                            </li>
                            <li>
                                <a href="{{route('admin.poll.index')}}">List Polls</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Poll Categories<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{route('admin.poll-category.create')}}">Add Poll Category</a>
                            </li>
                            <li>
                                <a href="{{route('admin.poll-category.index')}}">Poll Category List</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-image" aria-hidden="true"></i></i> Ad<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{route('admin.ad.create')}}">Add Ad</a>
                            </li>
                            <li>
                                <a href="{{route('admin.ad.index')}}">List Ad</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-comment-o" aria-hidden="true"></i></i> Comments<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{route('admin.poll-comments.index')}}">List Comments</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-rss-square fa-fw" aria-hidden="true"></i> Feed Reader <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{route('admin.rss-feed-url.index')}}">Add Feed Url</a>
                            </li>
                            <li>
                                <a href="{{route('admin.rss-feed-data.index')}}">Rss Feeds</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{route('reset-password')}}"><i class="fa fa-gear fa-fw" aria-hidden="true"></i> Settings</a>
                    </li>
                @else
                    <li>
                        <a href="#"><i class="fa fa-image" aria-hidden="true"></i></i> Ad<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{route('admin.ad.create')}}">Add Ad</a>
                            </li>
                            <li>
                                <a href="{{route('admin.ad.index')}}">List Ad</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-tasks" aria-hidden="true"></i> Polls<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{route('admin.poll.create')}}">Add Poll</a>
                            </li>
                            <li>
                                <a href="{{route('admin.poll.index')}}">List Polls</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" aria-hidden="true"><i class="fa fa-rss-square fa-fw" aria-hidden="true"></i>Feed Reader <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{route('admin.rss-feed-url.index')}}">Add Feed Url</a>
                            </li>
                            <li>
                                <a href="{{route('admin.rss-feed-data.index')}}">Rss Feeds</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-comment-o" aria-hidden="true"></i></i> Comments<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{route('admin.poll-comments.index')}}">List Comments</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{route('reset-password')}}"><i class="fa fa-gear fa-fw" aria-hidden="true"></i></i>Settings</a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>