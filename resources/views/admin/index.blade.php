@extends('layouts.app')

@section('content')
    <table class="table table-striped">
        <thead>
        <tr>
            <th></th>
            <th>Имя</th>
            <th>Режисер</th>
            <th>Год</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>
        @foreach($postList as $post)
        <tr>
            <td class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <img class="img-responsive img-thumbnail" src="{{asset($post->image_name)}}">
            </td>
            <td class="vert-align">
                <a href="{{route('admin.edit', $post->slug)}}">{{$post->title}}</a>
            </td>
            <td class="vert-align">
                {{$post->producer}}
            </td>
            <td class="vert-align">
                <span class="badge">{{$post->year}}</span>
            </td>
            <td class="vert-align">
                @if(!$post->is_published)
                    Не опубликовано
                @elseif($post->deleted_at != null)
                    <form method="POST" action="{{route('admin.restore', $post->id)}}">
                        @method('HEAD')
                        @csrf
                        <button type="submit" class="btn btn-link">Восстановить</button>
                    </form>
                @else
                    На сайте
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @if($postList->total() > $postList->count())
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                {{$postList->links()}}
            </div>
        </div>
    </div>
    @endif

@endsection
