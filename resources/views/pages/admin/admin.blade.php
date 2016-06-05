@extends('pages.admin.main')

@section('title','| Admin')

  {{-- {{bcrypt('admin')}} --}}
@section('content')
  <div class="row">
      <div class=" col-md-offset-4 col-md-4">
      <h3>Sign In</h3>
      <form action="{{route('adminLogin')}}" method="post">
        <div class="form-group {{ $errors->has('username') ? 'has-error' :'' }}">
          <label for="username">Username</label>
          <input class="form-control" type="text" name="username" id="username" value="{{ Request::old('username') }}">
        </div>
        <div class="form-group {{ $errors->has('password') ? 'has-error' :'' }}">
          <label for="password">Password</label>
          <input class="form-control" type="password" name="password" id="password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
      </form>
    </div>
  </div>
@endsection
