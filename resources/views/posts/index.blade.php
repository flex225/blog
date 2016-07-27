@extends('main')

@section('title', '| Բոլոր գրառումները')
@section('stylesheets')
    <style>
        .category, .subcategory {
            font-weight: bold;
            list-style-type: none;
        }
    </style>
@endsection

@section('content')

    <div class="row">
        <?php $other_id="";?>
        {{--<pre width="1000px;">--}}
        {{--{{var_dump($subcategories)}}--}}
        {{--</pre>--}}

        <div class="col-md-10">
            <h1>Բոլոր գրառումները</h1>
        </div>

        <div class="col-md-2">
            <a href="{{ route('posts.create') }}" class="btn  btn-primary btn-lg btn-h1-spacing">Կատարել գրառում</a>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
    </div> <!-- end of .row -->

    <div class="row">
        <form method="post" action="{{route('updateFilter')}}">
            <div class="form-group col-md-2">
                <label>Բաժիններ</label>
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
                                        <input type="checkbox" name="checklist[]"
                                               value="{{$subcategory->id}}">
                                        {{$subcategory->subcategory_name}}</li>
                                @endif
                            @endforeach
                            @if($other_id != 0)
                                <li class="subcategory">
                                    <input type="checkbox" name="checklist[]"
                                           value="{{$other_id}}">
                                    {{$other}}</li><?php $other_id = 0;?>
                            @endif
                        </ul>
                    </li>
                @endforeach
                <input type="submit" value="Թարմացնել" class="btn btn-primary btn-block" placeholder="">
                {{ Form::token() }}
            </div>
            <form>
                <div class="col-md-10">
                    <table class="table">
                        <thead>
                        <th>Գրառման տեսակը</th>
                        <th>Բաժին</th>
                        <th style="min-width:90px;">Ստեղծվել է</th>
                        <th></th>
                        </thead>

                        <tbody>
                        @if(count($posts)!=0)
                            @foreach ($posts as $post)

                                <tr>
                                    <td>{{ $post->post_type == 0? "Օգնության կարիք ունեմ": "Ցանկանում եմ օգնել" }}</td>
                                    <td><?php
                                        $post_id = $post->id;
                                        $subname = "";
                                        foreach ($post_and_category as $value) {
                                            if ($value->post_id == $post_id) {
                                                foreach ($subcategories as $sub) {
                                                    if ($sub->id == $value->subcategory_id) {
                                                        $subname .= $sub->subcategory_name ."<br>";
                                                    }
                                                }
                                            }
                                        }
                                        echo $subname;?>
                                        </td>
                                    <td>{{ date('m-j-Y', strtotime($post->created_at)) }}</td>
                                    <td><a href="{{ route('posts.show', $post->id) }}" class="btn btn-default btn-sm"
                                           style="background-color: #dcdcdc">Կարդալ ավելին</a>
                                    </td>
                                </tr>

                            @endforeach
                        @else
                            <h2>Գրառումներ չկան</h2>
                        @endif
                        </tbody>
                    </table>

                </div>
    </div>
    <div class="row">
        <div class="text-center">
            {!! $posts->links() !!}
        </div>
    </div>

@endsection
