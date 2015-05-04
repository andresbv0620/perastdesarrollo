@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Inicio Super Administrador</div>

				<div class="panel-body">

                    <div class="span3">
                        <h6>Panel de Administración</h6>
                        <p>
                            <a class="btn btn-success" href="{{route('admin.users.index')}}" role="button"><i class="icon-user"></i> Gestionar Usuarios</a>
                            <a class="btn btn-primary" href="{{route('admin.planes.index')}}" role="button"><i class="icon-cog"></i> Gestionar Planes</a>

                        </p>

                        {!! Form::open(['route' => 'tenants_path','method'=>'POST']) !!}

                        @include('admin.sistemas.partials.tables')

                        {!! Form::close() !!}



                    </div>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
