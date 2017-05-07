<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', '') }}</title>

  <!-- Styles -->
  <link href="/css/app.css" rel="stylesheet">
  <!-- Scripts -->
  <script>
    window.Laravel = {!!json_encode([
        'csrfToken' => csrf_token(),
      ]) !!
    };
  </script>
</head>

<body>
  <div id="app">
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container" >
        <div class="navbar-header">

          <!-- Collapsed Hamburger -->
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

          <!-- Branding Image -->
          <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', '') }}
          </a>
        </div>

        <div class="col-sm-8 col-md-offset-1 nopd">
                <div class="col-sm-10 col-sm-offset-1 nopd">
                <form class="form-horizontal" method="get" role="search" action="{{ url('/search') }}">
                        <div class="input-group stylish-input-group">
                            <input name="search" type="text" class="form-control"  placeholder="Search">
                            <span class="input-group-addon">
                                <button type="submit">
                                    <span class="glyphicon glyphicon-search">
                                    </span>
                                </button>
                            </span>
        	           </div>
                  </form>
                </div>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
          <!-- Left Side Of Navbar -->
          <ul class="nav navbar-nav">
            &nbsp;
          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            @if (Auth::guest())
            <li><a href="{{ route('login') }}">Login</a></li>
            <li><a href="{{ route('register') }}">Register</a></li>
            @else
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <i class="glyphicon glyphicon-user" aria-hidden="true"></i> {{ Auth::user()->name }}
              </a>

              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                  Logout
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  </form>
                </li>
                <li>
                  <a href="{{ url('/dashboard') }}">
                    Dashboard
                  </a>
                </li>
                <li>
                  <a href="{{ url('/profile') }}">
                    Profile
                  </a>
                </li>
              </ul>
            </li>
            @endif
          </ul>
        </div>
      </div>
    </nav>

    @yield('content')
  </div>
  </div>
  </div>
  <!-- Scripts -->
  <script src="/js/app.js"></script>
  {{-- Include Tracking Scripts. This places them inline.
  You might need to change the path. --}}
  {{include('/var/www/smsapp/analytics-scripts.js')}}
</body>

</html>
