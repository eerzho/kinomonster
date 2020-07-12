@extends('layouts.app')

@section('content')
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Имя</th>
            <th>E-mail</th>
            <th>Создано</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($userList as $user)
        <tr>
{{--            <td class="col-lg-2 col-md-2 col-sm-2 col-xs-2">--}}
{{--                {{$user->name}}--}}
{{--            </td>--}}
{{--            <td class="vert-align">--}}
{{--                <a href="{{route('admin.edit', $post->slug)}}">{{$post->title}}</a>--}}
{{--            </td>--}}
            <td class="vert-align">
                {{$user->name}}
            </td>
            <td class="vert-align">
                {{$user->email}}
            </td>
            <td class="vert-align">
                {{$user->created_at}}
            </td>
            <td class="vert-align">
                <form method="POST" action="{{route('admin.user.destroy', $user->id)}}">
                    @method('DELETE')
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card card-block">
                                <div class="card-body ml-auto">
                                    <button type="submit" class="btn btn-link">Удалить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </td>
{{--            <td class="vert-align">--}}
{{--                <span class="badge">{{$post->year}}</span>--}}
{{--            </td>--}}
{{--            <td class="vert-align">--}}
{{--                @if(!$post->is_published)--}}
{{--                    Не опубликовано--}}
{{--                @elseif($post->deleted_at != null)--}}
{{--                    Удалено--}}
{{--                @else--}}
{{--                    На сайте--}}
{{--                @endif--}}
{{--            </td>--}}
        </tr>
        @endforeach
        </tbody>
    </table>
    @if($userList->total() > $userList->count())
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                {{$userList->links()}}
            </div>
        </div>
    </div>
    @endif

@endsection
