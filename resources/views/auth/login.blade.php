@extends('main')

@section('title', '| Մուտք')

@section('content')
  <div class="row">
    <div class="col-md-offset-4 col-md-4">
      <h1> <small>Մուտք</small></h1>
      <form method="post">
        <div class="form-group">
          {{--<label for="username">Username:</label>--}}
          <input type="text" name="username" class="form-control" id="" placeholder="Մուտքանուն"><br>
          {{--<label for="password">Password:</label>--}}
          <input type="password" name="password" class="form-control" id="" placeholder="Գաղտնաբառ">
          <br>
          <input type="submit" name="login" value="Մուտք" class="btn btn-primary" style="float: right;">
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </form>
    </div>
  </div>
@endsection
