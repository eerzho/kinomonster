@extends('layouts.app')
@section('content')
    <h1>{{$post->title}}</h1>
    <hr>
    <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="{{$post->trailer}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>

    <div class="well info-block text-center">
        Год: <span class="badge">{{$post->year}}</span>
        Режиссёр: <span class="badge">{{$post->producer}}</span>
        <form method="POST" action="{{route('user.favorite.add', $post->id)}}">
            @csrf
            <button type="submit" class="btn btn-link">Добавить в избранные</button>
        </form>
    </div>

    <div class="margin-8"></div>

    <h2>Описание</h2>
    <hr>

    <div class="well">
        {{$post->content_raw}}
    </div>
    <div class="margin-8"></div>
        <h2>Отзывы</h2>
        <hr>
        @foreach($commentList as $comment)
            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-user"></i>
                    @if(Auth::user())
                        @if($comment->user_id == Auth::user()->id)
                            <span>Вы</span>
                        @else
                            <span>{{$comment->user_name}}</span>
                        @endif
                        @if(Auth::user()->role)
                            <form method="POST" action="{{route('admin.comment.destroy', $comment->id)}}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-link">Удалить комментарий</button>
                            </form>
                        @endif
                    @else
                        <span>{{$comment->user_name}}</span>
                    @endif
                </div>
                <div class="panel-body">
                    {{$comment->comment}}
                </div>
            </div>
        @endforeach
        @if($commentList->total() > $commentList->count())
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        {{$commentList->links()}}
                    </div>
                </div>
            </div>
        @endif
    @guest
    @else
        <form method="POST" action="{{route('user.comment.store', $post->id)}}">
            @csrf
        <div class="form-group">
            <textarea name="comment" placeholder="Комментарий" class="form-control"></textarea>
        </div>
        <button class="btn btn-lg btn-warning pull-right">Отправить</button>
    </form>
    <div class="margin-8 clear"></div>
    @endguest
@endsection
