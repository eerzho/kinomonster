@extends('layouts.app')
@section('content')
    @if(empty($category))
        <h1>Избранное</h1>
        <hr>
        @foreach($list as $post)
            <div class="row">
                <div class="well clearfix">
                    <div class="col-lg-3 col-md-2 text-center">
                        <img class="img-thumbnail" src="{{asset($post['image_name'])}}" alt="">
                        <p class="film-title">{{$post['title']}}</p>
                    </div>
                    <div class="col-lg-9 col-md-12">
                        <p>{{$post['content_raw']}}</p>
                    </div>
                    <div class="col-md-12 offset-md-4">
                        <form method="POST" action="{{route('user.favorite.delete', $post['id'])}}">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-lg btn-warning pull-left">Удалить</button>
                        </form>
                        <a href="{{route('home.show', $post['slug'])}}" class="btn btn-lg btn-warning pull-right">Подробнее</a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <h1>{{$category->title}}</h1>
    <hr>
    @foreach($list as $post)
        <div class="row">
            <div class="well clearfix">
                <div class="col-lg-3 col-md-2 text-center">
                    <img class="img-thumbnail" src="{{asset($post->image_name)}}" alt="">
                    <p class="film-title">{{$post->title}}</p>
                </div>
                <div class="col-lg-9 col-md-12">
                    <p>{{$post->content_raw}}</p>
                </div>
                <div class="col-md-12 offset-md-4">
                    <a href="{{route('home.show', $post->slug)}}" class="btn btn-lg btn-warning pull-right">Подробнее</a>
                </div>
            </div>
        </div>
    @endforeach
    @endif
@endsection
