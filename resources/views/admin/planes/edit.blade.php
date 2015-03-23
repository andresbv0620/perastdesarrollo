@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Plan: {{$plan->nombre}}</div>

                    <div class="panel-body">
                        @include('admin.partials.messages')
                        {!! Form::model($plan,array('route' => ['admin.planes.update',$plan],'method'=>'PUT')) !!}

                        @include('admin.planes.partials.fields')

                        <button type="submit" class="btn btn-default">Actualizar Plan</button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
