<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>КиноМонстр</title>

    <!-- Bootstrap -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Main Style -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">



</head>
<body>

@include('includes.nav')


<div class="wrapper">
    <div class="container" >
        <div class="row">
            <div class="col-lg-9 col-lg-push-3"> <!-- Меняем блоки местами col-lg-push-3 -->
                <form role="search" class="visible-xs" method="GET" action="{{route('home.search')}}">
                    @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <input name="title" type="search" class="form-control input-lg" placeholder="Поиск">
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-lg" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
{{--                {{$errors->first()}}--}}
                @if(!empty($errors))
                    <div class="panel-heading"><div class="sidebar-header" style="background: red">{{$errors->first()}}</div></div>
                @endif
                @if(session('success'))
                    @if(session('success') == 'Отмена')
                        <div class="panel-heading">
                            <div class="sidebar-header" style="background: green">
                                Запись id[{{session('id')}}] удалена
                                <form method="POST" action="{{route('admin.restore', session()->get('id'))}}">
                                    @method('HEAD')
                                    @csrf
                                    <button type="submit" class="btn btn-link">Отмена</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="panel-heading"><div class="sidebar-header" style="background: green">{{session('success')}}</div></div>
                    @endif
                @endif
                @yield('content')
            </div>
            <div class="col-lg-3 col-lg-pull-9">
                <div class="margin-8"></div>
{{--                <div class="panel panel-info hidden-xs">--}}
{{--                    <div class="panel-heading"><div class="sidebar-header">Поиск</div></div>--}}
{{--                    <div class="panel-body">--}
{{--                        <form role="search">--}}
{{--                            <div class="form-group">--}}
{{--                                <div class="input-group">--}}
{{--                                    <input type="search" class="form-control input-lg" placeholder="Поиск">--}}
{{--                                    <div class="input-group-btn">--}}
{{--                                        <button class="btn btn-default btn-lg" type="submit"><i class="glyphicon glyphicon-search"></i></button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
                @if(request()->is('login*') || request()->is('register*'))
                    <?php $style = 'display:none';?>
                @else
                    <?php $style = ''; ?>
                @endif
                @guest
                    <div class="panel panel-info hidden-xs" style="{{$style}}">
                        <div class="panel-heading"><div class="sidebar-header">Поиск</div></div>
                        <div class="panel-body">
                            <form role="search" method="GET" action="{{route('home.search')}}">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group">
                                        <input name="title" type="search" class="form-control input-lg" placeholder="Поиск">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default btn-lg" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="panel panel-info" style="{{$style}}">
                        <div class="panel-heading"><div class="sidebar-header">Вход</div></div>
                        <div class="panel-body">
                            <form role="form" action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="form-control input-lg" placeholder="Логин">
                                </div>
                                <div class="form-group">
                                    <input id="password" type="password" name="password" required autocomplete="current-password" class=" form-control input-lg" placeholder="Пароль">
                                </div>
                                <button type="submit" class="btn btn-warning pull-right">Войти</button>
                            </form>
                            @if (Route::has('register'))
                                <a class="btn btn-warning pull-left" href="{{ route('register') }}">Регистрация</a>
                            @endif
                        </div>
                        @elseif(Auth::user()->role == false)
                            <div class="panel panel-info hidden-xs">
                                <div class="panel-heading"><div class="sidebar-header">Поиск</div></div>
                                <div class="panel-body">
                                    <form role="search" method="GET" action="{{route('home.search')}}">
                                        @csrf
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input name="title" type="search" class="form-control input-lg" placeholder="Поиск">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default btn-lg" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @elseif(Auth::user()->role == true)
                            @if(!empty($item))
{{--                            @if($item->exists)--}}
                                <div class="panel panel-info hidden-xs">
{{--                                    <div class="panel-heading"><div class="sidebar-header">ID: {{$item->id}}<br>Title: {{$item->title}}</div></div>--}}
{{--                                    @if(!empty($user))--}}
                                        <div class="panel-heading">
                                            <div class="sidebar-header">
                                                @if(!empty($user))
                                                    Автор: {{$user->name}}
                                                @endif
                                            </div>
                                        </div>
{{--                                    @endif--}}
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for = "title">Создано</label>
                                                <input type="text" disabled class="form-control input-lg" value="{{$item->created_at}}">
                                            </div>
                                            <div class="input-group">
                                                <label for = "title">Изменено</label>
                                                <input type="text" disabled class="form-control input-lg" value="{{$item->updated_at}}">
                                            </div>
                                            <div class="input-group">
                                                <label for = "title">Опубликовано</label>
                                                <input type="text" disabled class="form-control input-lg" value="{{$item->published_at}}">
                                            </div>
                                            <div class="input-group">
                                                <label for = "title">Удалено</label>
                                                <input type="text" disabled class="form-control input-lg" value="{{$item->deleted_at}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                                <div class="panel panel-info hidden-xs">
                                    <a class="btn btn-warning pull-left" href="{{route('admin.index')}}">Все записи</a>
                                </div>
                                <br>
                                <br>
                                <div class="panel panel-info hidden-xs">
                                    <a class="btn btn-warning pull-left" href="{{route('admin.show', Auth::user()->id)}}">Мои записи</a>
                                </div>
                                <br>
                                <div class="panel panel-info hidden-xs">
                                    <a class="btn btn-warning pull-left" href="{{route('admin.trash')}}">Удаленные записи</a>
                                </div>
                                <br>
                                <div class="panel panel-info hidden-xs">
                                    <a class="btn btn-warning pull-left" href="{{route('admin.create')}}">Добавить запись</a>
                                </div>
                                <br>
                                <div class="panel panel-info hidden-xs">
                                    <a class="btn btn-warning pull-left" href="{{route('admin.user')}}">Пользователи</a>
                                </div>
                        </div>
                    @endguest
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<footer style="{{$style}}">
    <div class="container">
        <p class="text-center"> <a href="#">SB Prod</a> </p>
    </div>
</footer>




<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
</body>
</html>
