<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
       
       

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('touch-swipe/filter.js') }}"></script>
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/glmenu.css') }}" rel="stylesheet">
        <link href="{{ asset('css/but.css') }}" rel="stylesheet">
        <link href="{{ asset('css/filters.css') }}" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="{{asset('lightcase-2.3.6/src/css/lightcase.css')}}">
        <script type="text/javascript" src="{{asset('lightcase-2.3.6/src/js/lightcase.js')}}"></script>
        <!-- Scripts -->
        <script>
    window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
    ]) !!}
    ;
        </script>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $('a[data-rel^=lightcase]').lightcase();
            });
        </script>
        <script>
            $(document).ready(function () {
                $("[data-toggle]").click(function () {
                    var toggle_el = $(this).data("toggle");
                    $(toggle_el).toggleClass("open-sidebar");
                });

            });
        </script>
        <script>
            $(".swipe-area").swipe({
                swipeStatus: function (event, phase, direction, distance, duration, fingers)
                {
                    if (phase == "move" && direction == "right") {
                        $(".container").addClass("open-sidebar");
                        return false;
                    }
                    if (phase == "move" && direction == "left") {
                        $(".container").removeClass("open-sidebar");
                        return false;
                    }
                }
            });
        </script>

        <link href="{{asset('dist/css/select2.min.css')}}" rel="stylesheet"/>
        <link rel="stylesheet" href="{{asset('select2-bootstrap/dist/select2-bootstrap.css')}}">
        <script src="{{asset('dist/js/select2.min.js')}}"></script>
        <link rel="stylesheet" href="{{asset('css/BootSideMenu.css')}}">    
        <script type="text/javascript">
              $(document).ready(function () {
                 $( ".select" ).select2({theme: "bootstrap"});
              });
        </script>

    </head>
    <body>
        
        <div id="app">
            <nav class="navbar navbar-default navbar-static-top">
                
                    <div class="navbar-header">

                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Branding Image -->
                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse" >
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">

                            @if(request()->getPathInfo()!=='/' && request()->getPathInfo()!=='/login' )
                            <li><a href="/addPart" class="button16">Добавить мероприятие</a></li>
                            <li><a href="/kadet" class="button16">Кадеты</a></li>
                            <li><a href="/part" class="button16">Мероприятия</a></li>
                            <li> <a href="/class" class="button16">Классы</a></li>
                            @endif
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right" style="margin-right: 10px;">
                            <!-- Authentication Links -->
                            @if (Auth::check())   
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->LastName }} {{ Auth::user()->FirstName }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    @if(Auth::user()->is_admin == 1)
                                    <li>
                                        <a href="/admin">
                                            Панель администратора
                                        </a>
                                    </li>
                                    @endif

                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                            Выход
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>

                                </ul>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>

            </nav>

            @yield('content')
        </div>

        <!-- Scripts -->

    </body>
</html>
