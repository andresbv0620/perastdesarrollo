<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Colector | Sistema de Recoleccion de Datos</title>

    {!! Html::Style('/css/app.css') !!}
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

    <script src="{{ url('//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js') }}"></script>
    <script src="{{ url('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js') }}"></script>

    <!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
@if(\Session::has('fondo_path'))
    <body background="{{ asset(\Session::get('fondo_path')) }}" style="background-size: cover">
@else
    <body>
@endif


        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    @if(\Session::has('logo_path'))
                        <img class="img-upload" src="{{ asset(\Session::get('logo_path')) }}" style="height: 30px; margin: 10px">
                    @else
                        <a class="navbar-brand" href="#">Colector</a>
                    @endif

                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">

                        <li><a href="{{ url('/') }}">Inicio</a></li>
                        @if (Entrust::hasRole('superadmin'))
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Planes<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/admin/planes') }}">Ver Planes</a></li>
                                    <li><a href="{{ url('/admin/planes/create') }}">Crear Planes</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Empresas<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/admin/sistemas') }}">Ver Empresas</a></li>
                                    <li><a href="{{ url('/admin/sistemas/create') }}">Crear Empresas</a></li>
                                </ul>
                            </li>
                        @endif
                        @if(Entrust::hasRole('superadmin')||Entrust::hasRole('admin'))

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Usuarios<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/admin/users') }}">Ver Usuarios</a></li>
                                    <li><a href="{{ url('/admin/users/create') }}">Crear Usuarios</a></li>
                                </ul>
                            </li>

                            @if(Entrust::hasRole('admin'))
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Catalogos<span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ url('/admin/catalogs') }}">Ver Catálogos</a></li>

                                        <li><a href="{{ url('/admin/catalogs/create') }}">Crear Catálogo</a></li>

                                    </ul>
                                </li>

                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Tablets<span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ url('/admin/tablets') }}">Ver Tablets</a></li>
                                        <li><a href="{{ url('/admin/tablets/create') }}">Crear Tablets</a></li>
                                    </ul>
                                </li>
                                {{--<li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Reportes<span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ url('/admin/inputs') }}">Ver Reportes</a></li>

                                    </ul>
                                </li>--}}
                            @endif
                        @endif
                    </ul>


                    <ul class="nav navbar-nav navbar-right">
                        @if (Auth::guest())
                            <li><a href="{{ url('/auth/login') }}">Ingreso</a></li>
                            {{--<li><a href="{{ url('/auth/register') }}">Registro</a></li>--}}
                        @else
                            <li class="dropdown">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Sistema Actual: {{ Session::get('tenant_connection') }} <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/home') }}">Seleccionar un sistema</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

        </nav>
        @if (Entrust::hasRole('superadmin'))
            <h1>Perfil Super Administrador {{ Auth::user()->name }}</h1>
            @elseif (Entrust::hasRole('admin'))
            <h1>Perfil Administrador {{ Auth::user()->name }}</h1>
            @elseif (Entrust::hasRole('recolector'))
                <h1>Perfil Recolector {{ Auth::user()->name }}</h1>
            @elseif (Entrust::hasRole('reportes'))
                <h1>Perfil Reportes {{ Auth::user()->name }}</h1>
            @else
                <div class="alert alert-danger" role="alert">Usuario no autorizado</div>
        @endif

        @yield('content')

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="{{ url('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js') }}"></script>
    <link href="{{ asset('/build/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
    <script src="{{ asset('/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    {{--typehead--}}
    <script src="{{ asset('/bower_components/typeahead.js/dist/typeahead.jquery.js') }}"></script>
    {{--custom--}}
{{--<script src="{{ asset('/js/custom.js') }}"></script>--}}
@yield('scripts')
</body>
</html>
