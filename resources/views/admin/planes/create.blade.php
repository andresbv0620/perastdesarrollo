@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Planes</div>

                    <div class="panel-body">
                        {!! Form::open(array('route' => 'admin.planes.store','method'=>'POST')) !!}

                        @include('admin.planes.partials.fields')

                        <button type="submit" class="btn btn-default">Crear Plan</button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection