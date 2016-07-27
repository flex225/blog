@extends('pages.admin.main')

@section('content')
<div class="row">
    <?php $other_id="";?>
  <div class="jumbotron col-md-4">
    <h4>All Post Type</h4>
    <hr>
  <ul class="categories" >
    @if(count($treeView)==0)
      There is no Categories!!
    @endif
        @foreach($treeView as $category)
            <li class="category">
                {{ $category->category_name }}
                <ul class="">
                    @foreach($category->subcategories as $subcategory)

                        @if($subcategory->subcategory_name=='Այլ')
                            <?php $other = $subcategory->subcategory_name;
                            $other_id = $subcategory->id; ?>
                        @else
                            <li class="subcategory">
                                {{$subcategory->subcategory_name}}</li>
                        @endif
                    @endforeach
                    @if($other_id != 0)
                        <li class="subcategory">
                            {{$other}}</li><?php $other_id = 0;?>
                    @endif
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

</div><br>
    <div class="row">
        <div class="col-md-4">
            <h4>Add Age</h4>
            <hr>
            <form method="post" action="{{route('add.age')}}">
                <input type="number" class="form-control" name="from" placeholder="from" style="float: left;width: 100px;margin-right: 10px">
                <input type="number" class="form-control " name="to" placeholder="to" style="float: left;width: 100px;margin-right: 10px">
                <input type="submit" class="btn-success btn " value="Add">
                {{ Form::token() }}
            </form>
            <h4>Delete Age</h4>
            <hr>
            <form method="post" action="{{route('remove.age')}}">
                <select class="form-control" style="margin-bottom: 10px;" name="age">
                    @foreach($ages as $age)
                        <option value="{{ $age->id }}">{{ $age->age }}</option>
                    @endforeach
                </select>
                <input type="submit" class="btn-danger btn " value="Delete" style="float:right">
                {{ Form::token() }}
            </form>
        </div>
        <div class="col-md-4">
            <h4>Add State</h4>
            <hr>
            <form method="post" action="{{route('add.state')}}">
                <input type="text" class="form-control" name="state" placeholder="State" style="float: left;width: 150px;margin-right: 10px">
                <input type="submit" class="btn-success btn " value="Add">
                {{ Form::token() }}
            </form>
            <h4>Delete State</h4>
            <hr>
            <form method="post" action="{{route('remove.state')}}">
                <select class="form-control" style="margin-bottom: 10px;" name="age">
                    @foreach($states as $state)
                        <option value="{{ $state->id }}">{{ $state->state }}</option>
                    @endforeach
                </select>
                <input type="submit" class="btn-danger btn " style="float: right;" value="Delete">
                {{ Form::token() }}
            </form>
        </div>
    </div>
@endsection
