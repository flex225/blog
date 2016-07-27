@extends('main')

@section('title',"| Կատարել գրառում")

@section('stylesheets')
    <!-- {!! Html::style('css/parsley.css') !!} -->
@endsection

@section('content')

    <div class="row">
        <form method="post" action="{{route('posts.store')}}" enctype="multipart/form-data">
            <div class="col-md-10 col-md-offset-1">
                <h1 style="text-align: center;margin-bottom: 30px;">Կատարել նոր գրառում</h1>
                <div class="btn-group col-md-offset-4" data-toggle="buttons">
                    <label class="btn btn-default rad marg active">
                        <input type="radio" name="post_type" value="0" id="need" autocomplete="off" checked> Օգնության կարիք ունեմ
                    </label>
                    <label class="btn btn-default rad">
                        <input type="radio" name="post_type" id="hellp" value="1" autocomplete="off">Ցանկանում եմ օգնել</label>
                </div>
                <hr style="margin-bottom:30px;">
                <div class="row">
                    <div class="form-group col-md-3" style="float: left;margin-right:20px">
                        <select name='gender' class="form-control input-md need">
                            <option value="-1">Սեռ</option>
                            <option value="0">Իգականա</option>
                            <option value="1">Արական</option>
                        </select>
                        <input name="name" type="text" value="{{ old('name') }}" class="form-control" id="" placeholder="Անուն">
                        <input name="surname" type="text" value="{{ old('surname') }}" class="form-control" id="" placeholder="Ազգանուն">
                    </div>
                    <?php
                    $other = "";
                    $other_id = 0;
                    ?>
                    {{--{{var_dump($treeView)}}--}}
                    <div class="form-group col-xs-4" style="min-width:200px;">
                        <select name='category' id="category" class="form-control input-md need">
                            <option value="-1">Բաժին*</option>
                            @foreach($post_category as $category)
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                        <select name='subcategory1' id="subcategory1" class="form-control input-md need">
                            <option value="-1">Ենթաբաժին*</option>
                        </select>
                        <select name='subcategory2' id="subcategory2" class="form-control input-md need">
                            <option value="-1">Ենթաբաժին</option>
                        </select>

                    </div>
                    <div class="form-group col-md-3" style="float: left;margin-right:20px">
                        <select name='age' class="form-control input-md help">
                            <option value="-1">Տարիք</option>
                            @foreach($ages as $age)
                                <option value="{{$age->id}}">{{$age->age}}</option>
                            @endforeach
                        </select>
                        <select name='status' class="form-control input-md help">
                            <option value="-1">Կարգավիճակ</option>
                            @foreach($statuses as $status)
                                <option value="{{$status->id}}">{{$status->state}}</option>
                            @endforeach
                        </select><br>
                        <label class="btn btn-default btn-file">
                            Ներբեռնել նկար(ներ) <input type="file" name="image[]" style="display: none;" multiple/>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-8">
                        <textarea name="description" placeholder="Նկարագրություն*" class="form-control"
                                  style="resize: none;">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-5">
                        <textarea name="contacts" placeholder="Ինչպես կապնվել* (հեռախոս, էլ․ հասցե, հասցե)"
                                  class="form-control" style="resize: none;">{{ old('contacts') }}</textarea>
                        <p style="margin-top:5px;color:red;font-size:12px">Աստղանիշով նշված տողերը լրացնելը պարտադիր է</p>
                        <br>
                        <input type="submit" name="create" class="btn btn-primary btn-lg" value="Կատարել գրառում">
                    </div>
                </div>
                {{ Form::token() }}

            </div>
        </form>
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
               if(this.value != -1) {
                   var value = this.value;
                   $.get( "{{ route('getSubcategories') }}",{id:value}, function( data ) {
                       var first ="<option value='-1'>Ենթաբաժին*</option>";
                       var second ="<option value='-1'>Ենթաբաժին</option>";
                       $( "#subcategory1" ).html( first + data );
                       $( "#subcategory2" ).html(second + data );
                   });
               }
            });

        });
    </script>
@endsection
