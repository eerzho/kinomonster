@extends('layouts.app')

@section('content')
    <p>Добавить пост</p>
    <form method="POST" action="{{route('admin.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-check">
            <input name="is_published"
                   type="hidden"
                   value="0">
            <input name="is_published"
                   type="checkbox"
                   class="form-check-input"
                   value="1">
            <label class="form-check-label" for="is_published">Опубликовать</label>
        </div>
        <div class="form-group">
            <p>Картинка: </p>
            <input name="image" type="file" class="form-group input-lg">
        </div>
        <div class="form-group">
            <input name="title" type="text" class="form-control input-lg" placeholder="Название" value="{{old('title')}}">
        </div>
        <div class="form-group">
            <input name="producer" type="text" class="form-control input-lg" placeholder="Режиссёр" value="{{old('producer')}}">
        </div>
        <div class="form-group">
            <input name="trailer" type="text" class="form-control input-lg" placeholder="Трейлер" value="{{old('trailer')}}">
        </div>
        <div class="form-group">
            <select class="form-control input-lg" name="year">
                <option value="null" selected disabled>Выберите год</option>
                @for($i = date('Y'); $i >= 1895; $i--)
                    @if(old('year') == $i)
                        <option value="{{$i}}" selected>{{$i}}</option>
                    @else
                        <option value="{{$i}}">{{$i}}</option>
                    @endif
                @endfor
            </select>
        </div>
        <div class="form-group">
            <select class="form-control input-lg" name="category_id">
                <option value="null" selected disabled> Выберите категорию </option>
                @foreach($categoryList as $category)
                    @if(old('category_id') == $category->id)
                        <option value="{{$category->id}}" selected> {{$category->title}} </option>
                    @else
                        <option value="{{$category->id}}"> {{$category->title}} </option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <textarea class="form-control" placeholder="Описание фильма" name="content_raw">{{old('content_raw')}}</textarea>
        </div>
        <button type="submit" class="btn btn-lg btn-warning pull-right">Добавить</button>
    </form>

@endsection
