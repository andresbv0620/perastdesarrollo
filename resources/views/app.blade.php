<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>PERAST-Sistema de Recoleccion de Datos</title>

    {!! Html::Style('/css/app.css') !!}
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">


    <!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>

        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">PERAST</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">

                        <li><a href="{{ url('/') }}">Inicio</a></li>
                        @if(Entrust::hasRole('superadmin')||Entrust::hasRole('admin'))
                            @if (Entrust::hasRole('superadmin'))
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Planes<span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ url('/admin/planes') }}">Ver Planes</a></li>
                                        <li><a href="{{ url('/admin/planes/create') }}">Crear Planes</a></li>
                                    </ul>
                                </li>
                            @endif
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Usuarios<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/admin/users') }}">Ver Usuarios</a></li>
                                    <li><a href="{{ url('/admin/users/create') }}">Crear Usuarios</a></li>
                                </ul>
                            </li>

                            @if (Entrust::hasRole('superadmin'))
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Sistemas<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/admin/sistemas') }}">Ver Sistemas</a></li>
                                    <li><a href="{{ url('/admin/sistemas/create') }}">Crear Sistemas</a></li>
                                </ul>
                            </li>
                            @endif
                                @if(Entrust::hasRole('admin'))

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Catalogos<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/admin/catalogs') }}">Ver Catálogos</a></li>

                                    <li><a href="{{ url('/admin/catalogs/create') }}">Crear Catálogo</a></li>

                                </ul>
                            </li>
                                @endif
                                @if(Entrust::hasRole('admin'))
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Tablets<span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ url('/admin/tablets') }}">Ver Tablets</a></li>
                                        <li><a href="{{ url('/admin/tablets/create') }}">Crear Tablets</a></li>
                                    </ul>
                                </li>
                                @endif
                        @endif
                    </ul>


                    <ul class="nav navbar-nav navbar-right">
                        @if (Auth::guest())
                            <li><a href="{{ url('/auth/login') }}">Ingreso</a></li>
                            <li><a href="{{ url('/auth/register') }}">Registro</a></li>
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
@yield('scripts')
</body>
</html>
