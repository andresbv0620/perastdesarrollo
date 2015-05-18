@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Tablet: {{$tablet->nombre}}</div>

                    <div class="panel-body">
                        @include('admin.partials.messages')
                        {!! Form::model($tablet,array('route' => ['admin.tablets.update',$tablet],'method'=>'PUT')) !!}

                        @include('admin.tablets.partials.fields')

                        <button type="submit" class="btn btn-default">Actualizar Tablet</button>

                        {!! Form::close() !!}


                    </div>
                </div>
            </div>
            @include('admin.tablets.partials.delete')
        </div>
    </div>

@endsection
