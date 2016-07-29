@extends('main')

@section('title', '| Գրանցում')

@section("stylesheets")
    {{ Html::style('css/datePicker.css') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-offset-3 col-md-8">
            <form method="post">
                <h1>
                    <small>Գրանցում</small>
                </h1>
                <div class="form-group" style="float:left;width:300px;">
                    {{--<label for="first_name">First Name:</label>--}}
                    <input type="text" name="first_name" class="form-control" id="" placeholder="Անուն"
                           autofocus="autofocus" value="{{old('first_name')}}">
                    {{--<label for="last_name">Last Name:</label>--}}<br>
                    <input type="text" name="last_name" class="form-control" id="" placeholder="Ազգանուն"
                           value="{{old('last_name')}}">
                    {{--<label for="last_name">Birth Date:</label>--}}<br>

                    <input  name="birth_date"  class="form-control datepicker" id="theDate" placeholder="Ծննդյան տարեթիվ" value="{{old('birth_date')}}">
                    {{--<label for="email">Email:</label>--}}<br>
                    <input type="text" name="email" class="form-control" id="" placeholder="Էլ. հասցե"
                           value="{{old('email')}}">
                    {{--<label for="address">Address:</label>--}}<br>
                    <input type="text" name="address" class="form-control" id="" placeholder="Հասցե"
                           value="{{old('address')}}">
                    <p style="margin-top:5px;color:red;font-size:12px">Աստղանիշով նշված տողերը լրացնելը պարտադիր է:</p>
                </div>
                <div class="form-group" style="float:left;margin-left:10px;width:300px;">
                    {{--<label for="telephone">Telephone:</label>--}}
                    <input type="text" name="telephone" class="form-control" id="" placeholder="հեռախոս"
                           value="{{old('telephone')}}">
                    {{--<label for="username">Username:</label>--}}<br>
                    <input type="text" name="username" class="form-control" id="" placeholder="Մուտքանուն"
                           value="{{old('username')}}">
                    {{--<label for="password">Password:</label>--}}<br>
                    <input type="password" name="password" class="form-control" id="" placeholder="Գաղտնաբառ">
                    {{--<label for="password_confirmation">Confirm Password:</label>--}}<br>
                    <input type="password" name="password_confirmation" class="form-control" id=""
                           placeholder="Կրկնել գաղտնաբառը"><br>
                    <label for="agree" style="margin-top: 10px;"><input type="checkbox" name="agree"> Ես համաձայն եմ
                        կայքի <a target="_blank" href="{{route('contacts')}}">կանոնակարգին</a></label><br>
                    <input type="submit" name="register" value="Գրանցվել" class="btn btn-primary btn-lg"
                           style="margin-top: 10px;float:right;">
                </div>

                {{ Form::token() }}
            </form>
        </div>
    </div>
@endsection
@section("scripts")
    <script type="text/javascript" src="{{ url('/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/bootstrap-datepicker.hy.min.js') }}"> </script>
    <script>
        $(document).ready(function () {
            $('.datepicker').datepicker({
                language: 'hy',
                startView: 'years',
                format: 'yyyy-mm-dd'
            });
        });
    </script>
@endsection