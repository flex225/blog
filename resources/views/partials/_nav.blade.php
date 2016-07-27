<nav class="navbar navbar-default" style="margin-bottom:0px;">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"><img style="width:100px;height:50px;margin-top:-14px;" src="{{url('/icons/logo.png')}}"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav" style="width:90%;">
            <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="/ ">Գլխավոր էջ <span class="sr-only">(current)</span></a></li>
            <li class="{{ Request::is('agreement') ? 'active' : '' }}"><a href="{{route('contacts')}}">Կանոնակարգ</a></li>
            <li class="{{ Request::is('posts') ? 'active' : '' }}"><a href="{{ route('posts.index') }}">Գրառումներ</a></li>
            @if(!Auth::check())
              <li style="float:right"> <a href="{{route('register')}}" >Գրանցում</a></a></li>
              <li style="float:right"><a href="{{route('login')}}">Մուտք</a>
              </li>
            @endif
          </ul>
          @if(Auth::check())
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Auth::user()->username}} <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="{{url('/myposts')}}">Իմ գրառումները</a></li>
                <li><a href="{{url('/profile', Auth::user()->id)}}">Իմ էջ</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="{{route('logout')}}">Ելք</a></li>
              </ul>
            </li>
          </ul>
        @endif
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
 </nav>
