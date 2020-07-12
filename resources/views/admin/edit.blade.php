@extends('layouts.app')

@section('content')
    <p>Добавить пост</p>
    <form method="POST" action="{{route('admin.update', $item->slug)}}" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="form-check">
            <input name="is_published"
                   type="hidden"
                   value="0">
            <input name="is_published"
                   type="checkbox"
                   class="form-check-input"
                   value="1"
                   @if($item->is_published) checked="checked" @endif>
            <label class="form-check-label" for="is_published">Опубликовать</label>
        </div>
        <div class="form-group">
            <p>Картинка: </p>
            <img class="img-responsive img-thumbnail" src="{{asset($item->image_name)}}" alt="Интерстеллар">
        </div>
        <div class="form-group">
            <p>Новвя картинка:</p>
            <input name="image" type="file" class="form-group input-lg">
        </div>
        <div class="form-group">
            <input name="title" type="text" class="form-control input-lg" placeholder="Название" value="{{$item->title}}">
        </div>
        <div class="form-group">
            <input name="producer" type="text" class="form-control input-lg" placeholder="Режиссёр" value="{{$item->producer}}">
        </div>
        <div class="form-group">
            <input name="trailer" type="text" class="form-control input-lg" placeholder="Трейлер" value="{{$item->trailer}}">
        </div>
        <div class="form-group">
            <select class="form-control input-lg" name="year">
{{--                <option value="null" selected disabled>Выберите год</option>--}}
                @for($i = date('Y'); $i >= 1895; $i--)
                    @if($i == $item->year)
                        <option value="{{$i}}" selected>{{$i}}</option>
                    @else
                        <option value="{{$i}}">{{$i}}</option>
                    @endif
                @endfor
            </select>
        </div>
        <div class="form-group">
            <select class="form-control input-lg" name="category_id">
                <option value="null" selected disabled>
                    Выберите категорию
                </option>
                @foreach($categoryList as $category)
                    @if($category->id == $item->category_id)
                        <option value="{{$category->id}}" selected>{{$category->title}}</option>
                    @else
                        <option value="{{$category->id}}"> {{$category->title}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <textarea class="form-control" placeholder="Описание фильма" name="content_raw">{{$item->content_raw}}</textarea>
        </div>
        <button type="submit" class="btn btn-lg btn-warning pull-right">Обнавить</button>
    </form>
<br>
    <br>
    <br>
{{--    <div class="container">--}}
    <form method="POST" action="{{route('admin.destroy', $item->id)}}">
        @method('DELETE')
        @csrf
        <button type="submit" class="btn btn-lg btn-warning pull-right">Удалить</button>
    </form>
{{--    </div>--}}
@endsection
