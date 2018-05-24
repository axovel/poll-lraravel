<!DOCTYPE html>
<html lang="en">
@include('includes.head')
<body id="app-layout">
    <div class="container">
        @include('includes.header')
        <div class="left-side col-md-3 ">
            <div class="col-md-12 text-content">
                <h4 class="text-left">Poll of the day</h4>
                <p class="left-ques">Q:Do you think Gov. Mike Pence would be effective running mate for Donlad Trump? </p>
                <a href="" class="btn btn-success"><i class="fa fa-bell" aria-hidden="true"></i> Mark Your Vote</a>

                <p class="left-ques">Q:Do you think Gov. Mike Pence would be effective running mate for Donlad Trump? </p>
                <a href="" class="btn btn-success"><i class="fa fa-bell" aria-hidden="true"></i> Mark Your Vote</a>
                <p class="text-right small-text"><a href="">View All Polls</a></p>
            </div>
        </div>
        @yield('content')
        <div class="right-side-sidebar col-md-3">
            <div class="right-content sidebar">
                <h4 class="heading-right text-left text-capitalize">Trending</h4>
                @foreach($topPolls as $topPoll)
                    <p><i class="fa fa-bolt" aria-hidden="true"></i> <a href="{{url($topPoll->slug)}}">{{$topPoll->title}}</a></p>
                @endforeach
                <p class="small text-right">
                    <span>View All</span>
                </p>
            </div>
            <div class="advertise sidebar">
                <img src="{{asset('images/add.jpg')}}">
            </div>
        </div>
    </div>
    <footer>
        <div class="col-md-12 footer-links">
            <div class="col-md-2 col-md-offset-2">
                <h3>quick links</h3>
                <ul>
                    <li>News</li>
                    <li>Politics</li>
                    <li>Business</li>
                    <li>Tech</li>
                    <li>Entertainment</li>
                    <li>Lifestyle</li>
                    <li>Sports</li>
                    <li>World Post</li>
                    <li>Blog</li>
                </ul>
            </div>
            <div class="col-md-2">
                <h3>quick links</h3>
                <ul>
                    <li>RSS</li>
                    <li>FAQ</li>
                    <li>About Us</li>
                    <li>Contact Us</li>
                </ul>
            </div>
            <div class="col-md-2">
                <h3>quick links</h3>
                <ul>
                    <li>Poll of The Day</li>
                    <li>Results</li>
                    <li>Trending</li>
                    <li>Subscribe</li>
                </ul>
            </div>
            <div class="col-md-2">
                <h3>quick links</h3>
                <ul>
                    <li>Facebook</li>
                    <li>Twitter</li>
                    <li>Business</li>
                    <li>Blogger</li>
                    <li>Google Plus</li>
                </ul>
            </div>
        </div>
        <div class="col-md-12 copyright small-text">
            <div class="col-md-9">
                <span>Copyright <i class="fa fa-copyright" aria-hidden="true"></i> Kansanaani | All rights reserved</span>
            </div>
            <div class="col-md-3">
                <span class="text-right"> User Agreement | Privacy Policy | Terms & Condition</span>
            </div>
        </div>
    </footer>
</body>
</html>
