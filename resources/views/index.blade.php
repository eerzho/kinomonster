@extends('layouts.app')

@section('content')
    <h2>Новые фильмы</h2>
    <hr>
    <div class="row">
        @foreach($filmList as $film)
            <div class="films_block col-lg-3 col-md-3 col-sm-3 col-xs-6">
                <a href="{{route('home.show', $film->slug)}}"><img src="{{asset($film->image_name)}}"></a>
                <div class="film_label">{{$film->title}}</div>
            </div>
        @endforeach
    </div>
{{--    <div class="margin-8"></div>--}}

    <h2>Новые сериалы</h2>
    <hr>
    <div class="row">
        @foreach($serialList as $serial)
            <div class="films_block col-lg-3 col-md-3 col-sm-3 col-xs-6">
                <a href="{{route('home.show', $serial->slug)}}"><img src="{{asset($serial->image_name)}}"></a>
                <div class="film_label">{{$serial->title}}</div>
            </div>
            @endforeach
    </div>
    <div class="margin-8"></div>
@endsection
