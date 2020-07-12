@extends('layouts.app')
@section('content')
        <h1>Профиль</h1>
        <hr>


        <div class="profile">
            <div class="profile__name">
                {{Auth::user()->name}}
            </div>
            <form method="POST" action="{{route('profile.destroy', Auth::user()->id)}}">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-lg btn-warning pull-left">Удалить аккаунт</button>
            </form>
            <div class="margin-8 clear"></div>

        </div>
        <form method="POST" action="{{route('profile.change.password', Auth::user()->id)}}">
            @method('PATCH')
            @csrf
            <label>Сменить пароль</label>
            <div class="form-group">
                <input name="new_password" type="password" class="form-control input-lg" placeholder="Новый пароль">
            </div>
            <div class="form-group">
                <input name="new_confirm_password" type="password" class="form-control input-lg" placeholder="Подтвердите пароль">
            </div>
            <button type="submit" class="btn btn-lg btn-warning pull-right">Сменить пароль</button>
        </form>
        <div class="margin-8 clear"></div>
        <form method="POST" action="{{route('profile.change.name', Auth::user()->id)}}">
            @method('PATCH')
            @csrf
            <label>Сменить имя</label>
            <div class="form-group">
                <input name="new_name" type="text" class="form-control input-lg" placeholder="Введите новое имя">
            </div>
            <button type="submit" class="btn btn-lg btn-warning pull-right">Сменить имя</button>
        </form>

@endsection
