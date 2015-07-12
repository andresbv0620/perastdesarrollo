@extends('app')
<body style="background: url('{{ asset('/index/images/b2.jpg') }}'); background-size: cover; height: 700px">
@section('content')

<div class="container-fluid">
	<div class="row">
        <div class="col-md-2  col-md-offset-1">

                <img src="{{ asset('/index/images/tablet2.png') }}" width="345" height="600" style="position: absolute; top: 1%; left: 1px">
                <img src="{{ asset('/index/images/perast.gif') }}" width="300" style="position: absolute; top: 61px; left: 24px">


        </div>
		<div class="col-md-5" style="position: absolute; top: 24%; left: 43%;">



			<div class="panel panel-default">
				<div class="panel-heading">Ingreso</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>¡Upps!</strong> Corrige los siguientes datos.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">


						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail</label>
							<div class="col-md-6">
                                {!!Form::Text('email',null,['class'=>'form-control','type'=>'email'])!!}

							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> Recuerdame
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Ingresar</button>

								{{--<a class="btn btn-link" href="{{ url('/password/email') }}">¿Olvidó su password?</a>--}}
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
    </body>