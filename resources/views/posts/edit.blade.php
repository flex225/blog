@extends('main')

@section('title', '| Փոփոխել գրառումը')

@section('stylesheets')
    <!-- {!! Html::style('css/parsley.css') !!} -->
@endsection

@section('content')

    <div class="row">
        {{ Form::model($post[0], array('route' => array('posts.update', $post[0]->id), 'method' => 'PUT','files' => 'true')) }}
        <div class="col-md-10 col-md-offset-1">
            <h1 style="text-align: center;margin-bottom: 30px;">Փոփոխել գրառումը</h1>
            <div class="btn-group col-md-offset-4" data-toggle="buttons">
                <label class="btn btn-default rad marg {{$post[0]->post_type == 0?"active":""}}">
                    <input type="radio" name="post_type" value="0" id="need"
                           autocomplete="off" {{$post[0]->post_type == 0?"checked":""}} /> Օգնության կարիք ունեմ
                </label>
                <label class="btn btn-default rad {{$post[0]->post_type == 1?"active":""}}">
                    <input type="radio" name="post_type" id="hellp" value="1"
                           autocomplete="off" {{$post[0]->post_type == 1?"checked":""}}>Ցանկանում եմ օգնել</label>
            </div>
            <hr style="margin-bottom:30px;">
            <div class="row">
                <div class="form-group col-md-3" style="float: left;margin-right:20px">
                    <select name='gender' class="form-control input-md need">
                        <option value="-1">Սեռ</option>
                        <option value="0"{{$post[0]->gender == 0?"selected":""}}>Իգական</option>
                        <option value="1"{{$post[0]->gender == 1?"selected":""}}>Արական</option>
                    </select>
                    <input name="name" type="text" value="{{$post[0]->name}}" class="form-control" id=""
                           placeholder="Անուն">
                    <input name="surname" type="text" value="{{$post[0]->surname}}" class="form-control" id=""
                           placeholder="Ազգանուն">
                </div>
                <?php
                $other = "";
                $other_id = 0;
                ?>
                {{--{{var_dump($treeView)}}--}}

                <div class="form-group col-md-3" style="float: left;margin-right:20px">
                    <select name='age' class="form-control input-md help">
                        <option value="-1">Տարիք</option>
                        @foreach($ages as $age)
                            <option value="{{$age->id}}"{{$post[0]->age == $age->age?"selected":""}}>{{$age->age}}</option>
                        @endforeach
                    </select>
                    <select name='status' class="form-control input-md help">
                        <option value="-1">Կարգավիճակ</option>
                        @foreach($statuses as $status)
                            <option value="{{$status->id}}" {{$post[0]->state == $status->state?"selected":""}}>{{$status->state}}</option>
                        @endforeach
                    </select><br>
                    <label class="btn btn-default btn-file">
                        Ներբեռնել նկար(ներ) <input type="file" name="image[]" style="display: none;" multiple/>
                    </label>
                </div>
                <div class="form-group col-md-4">
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
                                            @if($post_and_category[0]->subcategory_id == $subcategory->id )
                                                <input type="checkbox" name="checklist[]"
                                                       value="{{$subcategory->id}}" checked/>
                                                {{$subcategory->subcategory_name}}</li>
                                        @else
                                            @if(!empty($post_and_category[1]->subcategory_id)
                                               and $post_and_category[1]->subcategory_id == $subcategory->id )
                                                <input type="checkbox" name="checklist[]"
                                                       value="{{$subcategory->id}}" checked/>
                                                {{$subcategory->subcategory_name}}</li>
                                            @else
                                                <input type="checkbox" name="checklist[]"
                                                       value="{{$subcategory->id}}">
                                                {{$subcategory->subcategory_name}}</li>
                                            @endif
                                        @endif
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

                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                        <textarea name="description" placeholder="Նկարագրություն*" class="form-control"
                                  style="resize: none;">{{ $post[0]->body }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-5">
                        <textarea name="contacts" placeholder="Ինչպես կապնվել* (հեռախոս, էլ․ հասցե, հասցե)"
                                  class="form-control" style="resize: none;">{{ $post[0]->contacts }}</textarea>
                    <br>
                    <input type="submit" name="create" class="btn btn-primary btn-lg" value="Պահպանել գրառում">
                </div>
            </div>
            {{ Form::token() }}
        </div>
        {{Form::close()}}
    </div>
    </div>

@endsection

@section('scripts')
    {!! Html::script('js/parsley.min.js') !!}
    <script>
        $(document).ready(function () {
            $('input[type=radio]').change(function () {
                if (this.value == '0') {
                    $('.help').css('visibility', 'visible');
                }
                else if (this.value == '1') {
                    $('.help').css('visibility', 'hidden');
                }
            });
            $('#category').change(function () {
                if (this.value != -1) {
                    var value = this.value;
                    $.get("{{ route('getSubcategories') }}", {id: value}, function (data) {
                        var first = "<option value='-1'>Ենթաբաժին*</option>";
                        var second = "<option value='-1'>Ենթաբաժին</option>";
                        $("#subcategory1").html(first + data);
                        $("#subcategory2").html(second + data);
                    });
                }
            });

        });
    </script>
@endsection
