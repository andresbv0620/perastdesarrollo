@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Inicio</div>

				<div class="panel-body">

                    <div class="span3">
                        <h2>Seleccione un plan para empezar</h2>

                        {!! Form::open(['route' => 'tenants_path','method'=>'POST']) !!}

                        @include('homepartials.tables')

                        <button class="btn btn-primary" type="submit">
                            Seleccionar Contexto
                        </button>

                        {!! Form::close() !!}



                    </div>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
