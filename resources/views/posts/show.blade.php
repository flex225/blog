@extends('main')

@section('title', '| Գրառում #'.$post[0]->id)

@section('stylesheets')
    <link type="text/css" rel="stylesheet" href="{{url('/css/lightslider.css')}}"/>
@endsection

@section('content')
    <div class="row">
        {{-- <pre>{{ print_r($photos ) }}</pre> --}}

        <div class="col-md-8 jumbotron" style="margin-top:10px;">
            <div class="row">
                <h1 style="text-align:center;margin:0px;padding:2px;font-size:22px;width: 280px;height: 30px;border-radius:50px;color:white;background-color:#ef4923 ">{{ $post[0]->post_type == 0 ? "Օգնության կարիք ունեմ": "Ցանկանում եմ օգնել"}}</h1>
            </div>
            @if(count($photos) != 0)
                <ul id="responsive" style="margin-top:10px;">
                    @foreach($photos as $photo)
                        <li>
                            <img src="http://ognenq.am/art/public/post_pictures/{{ $post[0]->username }}/{{$photo->img_src}}" class="thumbnail"
                                 style="max-width:640px;height: 400px;"/>
                        </li>
                    @endforeach
                </ul>
                {{-- <img style="margin-top:10px;max-width:650px;height: auto;" class="thumbnail" src="/post_pictures/{{$post[0]->username}}/{{$photos[0]->img_src}}"/> --}}
            @endif
            
            
            @if($post[0]->name)
                <p style="font-size:18px;"><strong>Անուն: </strong> {{$post[0]->name}}</p>
            @endif
            @if($post[0]->surname)
            <p style="font-size:18px;"><strong>Ազգանուն: </strong> {{$post[0]->surname}}</p>
            @endif
            
            @if($post[0]->age)
            <p style="font-size:18px;"><strong>Տարիք: </strong> {{$post[0]->age}}</p>
            @endif
            @if($post[0]->state)            
            <p style="font-size:18px;"><strong>Կարգավիճակ: </strong> {{$post[0]->state}}</p>
      	    @endif
            <dl class="dl-vertical">
                <dt style="font-size:18px;width:135px;margin-right: 5px;">Նկարագրություն:</dt>
                <dd style="margin-top:5px;text-size:15px;text-indent:20px;text-align: justify;word-spacing:10px;padding:20px;border-radius:20px;background-color: #fff;"> {{ $post[0]->body }}</dd>
            </dl>
            <dl class="dl-vertical">
                <dt style="font-size:18px;width:170px;margin-right: 5px;">Ինչպես կապնվել:</dt>
                <dd>
                    <pre style="margin-top:5px;font-size:15px;padding:20px;border-radius:20px;background-color: #fff;">{{ $post[0]->contacts }}</pre>
                </dd>
            </dl>

        </div>

        @if($post[0]->user_id == Auth::user()->id || Auth::user()->username == "admin" )
            <div class="col-md-4" style="margin-top:10px;">
                <div class="well">
                    <dl class="dl-horizontal">
                        <dt>Ստեղծվել է:</dt>
                        <dd>{{ date('j-m-Yթ․ H:i', strtotime($post[0]->created_at)) }}</dd>
                    </dl>

                    <dl class="dl-horizontal">
                        <dt>Թարմացվել է:</dt>
                        <dd>{{ date('j-m-Yթ․ H:i', strtotime($post[0]->updated_at)) }}</dd>
                    </dl>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6" style="margin-top:2px;">
                            {!! Html::linkRoute('posts.edit', 'Փոփոխել', array($post[0]->id), array('class' => 'btn btn-primary btn-block')) !!}
                        </div>
                        <div class="col-sm-6" style="margin-top:2px;">
                            {{ Form::open(array('route' => array('posts.destroy', $post[0]->id), 'method' => 'DELETE')) }}
                            <input type="submit" value="Ջնջել" class="btn btn-primary btn-block confirm">
                            </form><br>
                        </div>
                        <div class="col-sm-6">
                            <dl class="dl-horizontal">
                                <dt>Օգտատեր:</dt>
                                <dd>{{ $post[0]->username}}</dd>
                                @if($post[0]->first_name != null)
                                    <dt>Անուն, Ազգանուն:</dt>
                                    <dd style="width: 150px;">{{ $post[0]->first_name." ".$post[0]->last_name}} </dd>
                                @endif
                            </dl>
                        </div>
                        <div class="col-sm-6" style="margin-left: 70px;">

                        @if( Auth::user()->username == "admin")
                            {!! Html::linkRoute('getUserInfo', 'Դիտել օգտատիրոջ էջը', array($post[0]->user_id), array('class' => 'btn btn-primary')) !!}
                        @endif
                        </div>
                    </div>

                </div>
            </div>
        @else
            <div class="col-md-4">
                <div class="well" style="margin-top:10px;">
                    <dl class="dl-horizontal">
                        <dt>Օգտատեր:</dt>
                        <dd>{{ $post[0]->username}}</dd>
                        @if($post[0]->first_name != null)
                            <dt>Անուն, Ազգանուն:</dt>
                            <dd>{{ $post[0]->first_name." ".$post[0]->last_name}} </dd>
                        @endif
                    </dl>
                    <hr>
                    <div class="row">
                        <dl class="dl-horizontal" style="margin-top: -20px;">
                            <dt>Ստեղծվել է:</dt>
                            <dd>{{ date('j-m-Yթ․ H:i', strtotime($post[0]->created_at)) }}</dd>
                        </dl>
                        <div class="col-sm-12">
                            {!! Html::linkRoute('getUserInfo', 'Դիտել օգտատիրոջ էջը', array($post[0]->user_id), array('class' => 'btn btn-primary btn-block ')) !!}
                        </div>
                    </div>

                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    {!! Html::script('/js/jquery.confirm.js') !!}
    {!! Html::script('/js/lightslider.js') !!}
    <script>
        $(document).ready(function () {
            $('#responsive').lightSlider({
                item: 1,
                loop: false,
                slideMove: 1,
                easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
                speed: 600,
                responsive: [
                    {
                        breakpoint: 800,
                        settings: {
                            item: 3,
                            slideMove: 1,
                            slideMargin: 6,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            item: 2,
                            slideMove: 1
                        }
                    }
                ]
            });
        });
        $(".confirm").confirm({
            text: "Դուք ցանկանում ե՞ք ջնջել գրառումը?",
            title: "Ջնջման հաստատում",
            confirm: function (button) {
                window.location.href = '{{ route('deletePost', $post[0]->id) }}';
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
@endsection
