<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Multi Auth Guard') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <script src="{!! asset('/jquery-3.2.1.min.js') !!}"></script>  


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/employee') }}">
                    {{ config('app.name', 'Laravel Multi Auth Guard') }}: Employee
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/employee/login') }}">Вход</a></li>
                        <li><a href="{{ url('/employee/register') }}">Регистрация</a></li>
                    @else
                        <li class="dropdown"> 
                             <a href="#"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Мои заявки <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/employee/create_ticket') }}">Создать заявку</a></li>
                                <li><a href="{{ url('/employee/view_all_incoming_tickets') }}">Входящие заявки</a></li>
                                 <li><a href="{{ url('employee/view_all_incoming_external_tickets') }}">Входящие внешние заявки от частных клиентов</a></li>
                                <li><a href="{{ url('employee/view_all_incoming_external_legal_tickets') }}">Входящие внешние заявки от организаций</a></li>
                                <li><a href="{{ url('/employee/outgoing_tickets') }}">Исходящие заявки</a></li>
                            </ul>
                        </li>
    
                         @if(  Auth::user()->id_role == 1  )
                            <li class="dropdown">
                                <a href="#"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Администрирование <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/employee/management') }}">Управление сотрудникими</a></li>
                                    <li><a href="{{ url('/employee/about_company') }}">Профиль компании</a></li>
                                    <li><a href="{{ url('/employee/company_units') }}">Отделы</a></li>
                                </ul>
                            </li>
                         @else 
                            
                         @endif

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                
                                <!-- <li><a href="/employee/my_profile">Мой профиль</a></li> -->

                                <li>

                                    <a href="{{ url('/employee/logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Выйти
                                    </a>

                                    <form id="logout-form" action="{{ url('/employee/logout') }}" method="POST" style="display: none;">
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

    <!-- Scripts -->
    @yield('script')
    <script src="/js/app.js"></script>
</body>


    

</html>

<?php 
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('employee')->user();

   
?>