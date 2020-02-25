<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title or 'Canada Phone Numbers| Canada Phone Number Lookup - ' . config( 'app.url' )  }}</title>
    <!-- SEO -->
    <meta name="description" content="{{$description or null}}">
    <meta name="keywords" content="{{$keywords or null}}">
    <meta name="author" content="{{$author or null}}">
    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

</head>
<body>
<div class="blog-masthead">
    <div class="container">
        <nav class="navbar-static-top blog-nav">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#app-navbar-collapse">
                        <span class="glyphicon glyphicon-align-justify"></span>
                        {{--<span class="icon-bar"></span>--}}
                        {{--<span class="icon-bar"></span>--}}
                        {{--<span class="icon-bar"></span>--}}
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand blog-nav-item link_logo" href="/">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">

                        <li><a class="blog-nav-item {{$ActivMenu['codes'] or null}}" href="/codes">Area Codes</a>
                        </li>
                        <li><a class="blog-nav-item {{$ActivMenu['province'] or null}}"
                               href="/province">Provinces</a>
                        </li>
                        <li><a class="blog-nav-item {{$ActivMenu['city'] or null}}" href="/citys">Cities</a></li>
                        <li><a class="blog-nav-item {{$ActivMenu['privacy'] or null}}" href="/privacy">Privacy</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            {{--<li><a class="blog-nav-item" href="{{ url('/login') }}">Login</a></li>--}}
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle blog-nav-item" data-toggle="dropdown" role="button"
                                   aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a class="blog-nav-item" href="/admin">Home</a></li>
                                    <li><a class="blog-nav-item" href="/admin/settings">Settings</a></li>
                                    <li>
                                        <a class="blog-nav-item" href="{{ url('/logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                              style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
<div id="app">
   <div class="container">
       <div class="First">
           @include('parts.FirstAdvertisingBlock')
       </div>
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 blog-main">
                        @yield('content')
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 blog-sidebar">
                <div class="row">
                    <aside class="sidebar-module sidebar-module-inset">
                        @include('parts.SecondAdvertisingBlock')
                    </aside>
                </div>
                <div class="row">
                    <aside class="sidebar-module sidebar-module-inset">
                        @if(!empty($RandomComments))
                            @include('parts.RandomCommentsBlock')
                        @endif
                    </aside>
                </div>
            </div>
        </div>
       @include('parts.PhonesInCodeBlock')
       @include('parts.SearchedPhonesBlock')
    </div>
    <footer class="blog-footer">
        <div class="footer">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">Hosted by All Canada Reverse Phone Base</div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">2016 - {{date('Y')}} © All Rights Reserved
                </div>

            </div>
        </div>
    </footer>
</div>
<script async src="/js/app.js"></script>
</body>
</html>
