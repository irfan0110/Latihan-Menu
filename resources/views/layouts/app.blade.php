<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="container-fluid pt-3 pb-3">
            <h4 class="text-primary">Latihan Menus</h4>
        </div>
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm pt-1 pb-1">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <?php

                    use App\AccessMenuUser;
                    use App\MenuUser;
                    use App\UserRole;
                    use Illuminate\Support\Facades\Auth;

                    $role = UserRole::where('user_id',Auth::user()->id)->pluck('role_id')->toArray();
                    $menus = MenuUser::
                            select('menus.id','menu_id','menu','icon')
                            ->distinct()
                            ->join('menus','menu_users.menu_id','=','menus.id')
                            ->whereIn('role_id',$role)->get();
                    $submenus = AccessMenuUser::
                                select('menu_id','url','icon','title')
                                ->distinct()
                                ->join('sub_menus','access_menu_users.submenu_id','=','sub_menus.id')
                                ->whereIn('role_id',$role)->get();

                    ?>
                    <ul class="navbar-nav mr-auto">
                        @foreach($menus as $menu)
                        <li class="nav-item {{ isDropDown($role,$menu->id) }}">
                            <a class="nav-link {{isDropDownToggle($role,$menu->id)}}" {{ checkSubMenu($role,$menu->id,$menu->menu) }} href="{{ $menu->menu =='Home' ? route('home') : '#' }}"><i class="{{$menu->icon}}"></i> {{$menu->menu}}</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown{{$menu->menu}}">
                            @foreach($submenus as $submenu)
                                @if($menu->id == $submenu->menu_id)
                                    <a class="dropdown-item" href="{{ route($submenu->url) }}"><i class="{{$submenu->icon}}"></i> {{$submenu->title}}</a>
                                @endif
                            @endforeach
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')
</body>
</html>
