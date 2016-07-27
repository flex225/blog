@extends('main')

@section('title', "Իմ էջը")

@section('content')
    <div class="row" style="background:#fff;margin-top:40px;margin-bottom:20px;padding-bottom:20px;border-radius:20px; ">
        <h1 style="text-align: center;padding-bottom:50px;">Օգտատիրոջ տվյալներ</h1>
        <div class="col-md-5 col-md-offset-2">
            <span class="prof"><strong class="p_leb">Անուն։</strong><h5 class="p_desc"> {{ $user[0]->first_name }}</h5></span><br><br>
            <span class="prof"><strong class="p_leb">Ազգանուն։</strong><h5 class="p_desc"> {{ $user[0]->last_name }}</h5></span><br><br>
            <span class="prof"><strong class="p_leb">Ծննդյան տարեթիվ։</strong><h5 class="p_desc"> {{ $user[0]->birth_date == "0000-00-00"? "" : $user[0]->birth_date}}</h5></span>
        </div>
        <div class="col-md-5">
            <span class="prof"><strong class="p_leb">Հասցե։</strong><h5 class="p_desc"> {{ $user[0]->address }}</h5></span><br><br>
            <span class="prof"><strong class="p_leb">Էլ․ հասցե։</strong><h5 class="p_desc"> {{ $user[0]->email }}</h5></span><br><br>
            <span class="prof"><strong class="p_leb">Հեռախոսահամար։</strong><h5 class="p_desc"> {{ $user[0]->telephone }}</h5></span>
        </div>
    </div>
    <div class="row">
      <div class="col-md-offset-8 col-md-4" style="margin-top: 20px;">
        @foreach($feedbacks as $feedback)
            <div class="well">{{$feedback->feedback}} </div>
        @endforeach
        <div class="text-center">
            {!! $feedbacks->links() !!}
        </div>
        @if(Auth::user()->id != Request::segment(2))
          <form action="{{ route('leaveFeedback') }}" method="post" style="margin-top:10px;">
              <input type="hidden" value="{{ Request::segment(2) }}" name="to_user"> <br>
              <textarea style="resize: inherit;height: 150px;" name="feedback" class="form-control" placeholder="Թողեք Ձեր կարծիքը"></textarea><br>
              <input value="Թողնել" type="submit" class="btn btn-primary" style="float:right"><br>
              {{ Form::token() }}
          </form>
        @endif
      </div>
    </div>
@endsection
