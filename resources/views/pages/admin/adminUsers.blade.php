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
              <th>Username</th>
              <th>Created At</th>
              <th>Actviated</th>
              <th></th>
            </thead>

            <tbody>

              @foreach ($users as $user)
                @if($user->username == "admin")
                @else
                <tr>
                  <th>{{ $user->id }}</th>
                  <td>{{ $user->username }}</td>
                  <td>{{ date('M j, Y', strtotime($user->created_at)) }}</td>
                  <td>{{ $user->activated ? "Yes" : "No" }}</td>
                  <td><a href="{{ route('getUserInfo', $user->id) }}" class="btn btn-default btn-sm" style="float: left; margin-right: 5px;">View</a>
                    @if($user->activated)
                      {{ Form::open(array('route' => array('delete.user', $user->id), 'method' => 'POST')) }}
                      <input type="submit" value="Ջնջել" class="btn btn-danger btn-sm confirm">
                      </form><br></td>
                    @else
                    {{ Form::open(array('route' => array('recover.user', $user->id), 'method' => 'POST')) }}
                    <input type="submit" value="Վերականգնել" class="btn btn-danger btn-sm">
                    </form><br></td>
                    @endif
                </tr>
              @endif
              @endforeach

            </tbody>
          </table>
        </div>
      </div>


@endsection
@section('scripts')
  {!! Html::script('/js/jquery.confirm.js') !!}
  <script>

    $(".confirm").confirm({
      text: "Դուք ցանկանում ե՞ք ջնջել գրառումը?",
      title: "Ջնջման հաստատում",
      confirm: function (button) {
        window.location.href = '{{ route('delete.user', $user->id) }}';
      },
      cancel: function (button) {
      },
      confirmButton: "Այո",
      cancelButton: "Ոչ",
      post: true,
      confirmButtonClass: "btn-danger",
      cancelButtonClass: "btn-default",
      dialogClass: "modal-dialog modal-lg" // Bootstrap classes for large modal
    });
  </script>