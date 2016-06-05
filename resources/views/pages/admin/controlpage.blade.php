@extends('pages.admin.main')

@section('content')
<div class="row">
  <div class="jumbotron col-md-4">
    <h4>All Post Type</h4>
    <hr>
  <ul class="categories" >
    @if(empty($treeView->category_name))
      There is no Categories!!
    @endif
    @foreach($treeView as $category)
      <li class="category" >
        {{ $category->category_name }}
        <ul class="categories" >
          @foreach($category->subcategories as $subcategory)
            <li class="subcategory" >{{$subcategory->subcategory_name}}</li>
          @endforeach
        </ul>
      </li>
    @endforeach
</ul>
  </div>
    <div class="col-md-4">
      <h4>Add Post Type</h4>
      <hr>
      {!! Form::open(array('route' => 'createPostType' )) !!}
          {{ Form::label('category','Category:')}}
          {{ Form::text('category',null,array('class' => 'form-control'))}}
          <br>
          {{ Form::submit('Add Category', array('class' => 'btn btn-success btn-lg btn-block',))}}
          {{ Form::token() }}
      {!! Form::close() !!}
      <hr>
    </div>
    <div class="col-md-4">
      <h4>Add Post Subtype</h4>
      <hr>
      {!! Form::open(array('route' => 'createPostSubType')) !!}
          {{ Form::label('category_chooser','Category:')}}
          <select name='category_chooser' class="form-control input-md" required="">
            <option value="">Choose category</option>
            @foreach($post_type as $post)
                  <option value='{{$post->id}}'>{{$post->category_name}}</option>
            @endforeach
          </select>
          <br>
          {{ Form::label('subcategory','Subcategory:')}}
          {{ Form::text('subcategory', null, array('class' => 'form-control', 'required' => ''))}}

          {{ Form::submit('Add Subcategory', array('class' => 'btn btn-success btn-lg btn-block', 'style' => 'margin-top:20px'))}}
          {{ Form::token() }}
      {!! Form::close() !!}
      <hr>
    </div>
    <div class="col-md-4">
      <h4>Delete Post Type</h4>
      <hr>
      {!! Form::open(array('route' => 'deleteposttype')) !!}
          {{ Form::label('deleteCategory','Category:')}}
          <select name='deleteCategory' class="form-control input-md" required="">
            <option value="">Choose category</option>
            @foreach($post_type as $post)
                  <option value='{{$post->id}}'>{{$post->category_name}}</option>
            @endforeach
          </select>
          {{ Form::submit('Delete Category', array('class' => 'btn btn-danger btn-lg btn-block', 'style' => 'margin-top:20px'))}}
          {{ Form::token() }}
      {!! Form::close() !!}
    </div>
    <div class="col-md-4">
      <h4>Delete Post Subtype</h4>
      <hr>
      {!! Form::open(array('route' => 'deletepostsubtype')) !!}
          {{ Form::label('subcategory','Subcategory:')}}
          <select name='deleteSubcategory' class="form-control input-md" required="">
            <option value="">Choose subcategory</option>
            @foreach($post_subtype as $post)
                  <option value='{{$post->id}}'>
                    {{$post->category_name}} - {{$post->subcategory_name}}
                  </option>
            @endforeach
          </select>
          {{ Form::submit('Delete Subcategory', array('class' => 'btn btn-danger btn-lg btn-block', 'style' => 'margin-top:20px'))}}
          {{ Form::token() }}
      {!! Form::close() !!}
    </div>
</div>
@endsection
