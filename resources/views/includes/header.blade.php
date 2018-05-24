<header>
    <h1 class="text-center heading-page">POLLS TODAY</h1>
    <div class="header-wrap">
        <div class="text-right top-bar">
            <ul class="list-inline ">
                @if(Auth::check())
                    <li><a href="{{url('/user/dashboard')}}">{{Auth::user()->first_name .' '.Auth::user()->last_name}}</a></li>
                    <li><a href="{{url('logout')}}">sign out</a></li>
                @else
                    <li><a href="{{url('login')}}">sign in</a></li>
                    <li><a href="{{url('register')}}">register</a></li>
                @endif
                <li> <a href="">search</a></li>
            </ul>
        </div>
        <div class="collapse navbar-collapse  text-center" id="myNavbar">
            <ul class="nav navbar-nav">
                @foreach($pollCategories as $pollCategory)
                    <li ><a class= "active" href="{{$pollCategory->slug}}" >{{$pollCategory->title}}</a></li>
                @endforeach
                    <li  id="#blog"><a class="" href="#tech" >blog</a></li>
            </ul>
        </div>
    </div>
</header>