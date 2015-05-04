@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Sistema: {{$sistema->nombre}}</div>

                    <div class="panel-body">
                        @include('admin.partials.messages')
                        {!! Form::model($sistema, array('route' => ['admin.sistemas.update',$sistema],'method'=>'PUT')) !!}
                        @include('admin.sistemas.partials.fields')
                        <button type="submit" class="btn btn-default">Actualizar Sistema</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection