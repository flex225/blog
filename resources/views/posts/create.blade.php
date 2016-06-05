@extends('main')

@section('title',"| Create New Post")

@section('stylesheets')
  <!-- {!! Html::style('css/parsley.css') !!} -->
@endsection

@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
      <h1>Create New Post</h1>
      <hr>
      {!! Form::open(array('route' => 'posts.store', 'files' => true, 'data-parsley-validate' => '')) !!}
          {{ Form::label('post_type','Category:')}}
          {{ Form::select('post_type', array('C' => 'Choose Category', 'L' => 'Large', '1' => 'Small'), 'S')}}
          <br>
          {{ Form::label('body','Description:')}}
          {{ Form::textarea('body', null, array('class' => 'form-control', 'required' => ''))}}

          {{ Form::label('image','Image:')}}
          {{ Form::file('image') }}

          {{ Form::label('contacts','How to contatc:')}}
          {{ Form::textarea('contacts', null, array('class' => 'form-control', 'required' => ''))}}

          {{ Form::submit('Create Post', array('class' => 'btn btn-success btn-lg btn-block', 'style' => 'margin-top:20px'))}}
          {{ Form::token() }}
      {!! Form::close() !!}
    </div>
</div>

@endsection

@section('scripts')
  {!! Html::script('js/parsley.min.js') !!}
@endsection
