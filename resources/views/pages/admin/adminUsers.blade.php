@extends('pages.admin.main')

@section('title', '| Admin Users')

@section('content')


      <div class="row">
        <div class="col-md-10">
          <h1>All Posts</h1>
        </div>
        <div class="col-md-12">
          <hr>
        </div>
      </div> <!-- end of .row -->

      <div class="row">
        <div class="col-md-12">
          <table class="table">
            <thead>
              <th>#</th>
              <th>Title</th>
              <th>Body</th>
              <th>Created At</th>
              <th></th>
            </thead>

            <tbody>

              @foreach ($users as $user)

                <tr>
                  <th>{{ $user->id }}</th>
                  <td>{{ $user->title }}</td>
                  <td>{{ substr($user->body, 0, 50) }}{{ strlen($user->body) > 50 ? "..." : "" }}</td>
                  <td>{{ date('M j, Y', strtotime($user->created_at)) }}</td>
                  <td><a href="{{ route('posts.show', $user->id) }}" class="btn btn-default btn-sm">View</a> <a href="{{ route('posts.edit', $user->id) }}" class="btn btn-default btn-sm">Edit</a></td>
                </tr>

              @endforeach

            </tbody>
          </table>
        </div>
      </div>


@endsection
