<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials._head')
</head>

<body style="background-color:#e7e7e7;">
@include('partials._nav')
<div style="margin-bottom:0px;min-height:100%">
<div class="container">

    @include('partials._messages')

    @yield('content')


</div><!-- end of .container -->
@include('partials._footer')

</div>
@include('partials._javascript')

@yield('scripts')

</body>
</html>
