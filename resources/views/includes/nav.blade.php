<div class="container-fluid">
    <div class="row">
<nav role="navigation" class="navbar navbar-inverse">
    <div class="container">

        <div class="navbar-header header">

            <div class="container">

                <div class="row">

                    <div class="col-lg-12">
                        <h1><a href="{{route('home.index')}}">КиноМонстр</a></h1>
                        <p>Кино - наша страсть!</p>
                    </div>

                </div>

            </div>


            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">

                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>

            </button>


        </div>

        <div id="navbarCollapse" class="collapse navbar-collapse navbar-right">

            <ul class="nav nav-pills">
                <li class="active"> <a href="{{route('home.index')}}">Главная</a> </li>
                <li> <a href="{{route('home.list', 1)}}">Фильмы</a> </li>
                <li> <a href="{{route('home.list', 2)}}">Сериалы</a> </li>
                @if(Auth::user())
                    <li> <a href="{{route('user.favorite.show')}}">Избранное</a> </li>
                @endif

{{--                <li> <a href="contact.html">Контакты</a> </li>--}}
                @guest
                @else
{{--                    @if(Auth::user()->role == false)--}}
{{--                        {{__('user'.Auth::user()->name)}}--}}
{{--                    @elseif(Auth::user()->role == true)--}}
{{--                        {{__('admin')}}--}}
{{--                    @endif--}}
                    <li>
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Выход
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <br>
                            <a href="{{ route('profile.index') }}">
                                Профиль
                            </a>
                            <br>
                            @if (Auth::user()->role == true)
                                <a href="{{route('admin.index')}}">Страница админа</a>
                            @endif
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
    </div>
</div>
