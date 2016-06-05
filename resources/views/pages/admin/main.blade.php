<!DOCTYPE html>
<html lang="en">
<head>
  @include('partials._head')
</head>

<body>
  <nav class="navbar navbar-default">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Admin</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          @if(Auth::check())
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li class="{{ Request::is('admin/adminPosts') ? 'active' : '' }}"><a href="/admin/adminPosts">Posts <span class="sr-only"></span></a></li>
                <li class="{{ Request::is('admin/controlpage') ? 'active' : '' }}"><a href="/admin/controlpage">Control Categories</a></li>
                <li class="{{ Request::is('admin/adminUsers') ? 'active' : '' }}"><a href="/admin/adminUsers">Users</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Account <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{ route('logout') }}">Logout</a></li>
                  </ul>
                </li>
              </ul>
          @endif
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
   </nav>

<div class="container">

@include('partials._messages')

@yield('content')

@include('partials._footer')

</div><!-- end of .container -->
@include('partials._javascript')

@yield('scripts')

</body>
</html>
