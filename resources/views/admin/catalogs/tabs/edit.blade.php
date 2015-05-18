@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h1><small>Esta editando la ficha:</small> {{$tab->name}}</h1></div>
                    <div class="panel-body">
                        @include('admin.partials.messages')

                        {!! Form::model($tab,array('route' => ['admin.tabs.update',$tab],'method'=>'PUT')) !!}
                        @include('admin.catalogs.tabs.partials.fields')
                        <button type="submit" class="btn btn-default">Actualizar Ficha</button>
                        {!! Form::close() !!}

                    </div>
                    @include('admin.catalogs.tabs.partials.delete')
                </div>
            </div>
        </div>
    </div>
@endsection