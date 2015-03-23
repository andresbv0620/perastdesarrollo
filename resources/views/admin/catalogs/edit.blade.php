@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h1><small>Esta editando el catálogo:</small> {{$catalog->name}}</h1></div>
                    <div class="panel-body">
                        @include('admin.partials.messages')

                        {!! Form::model($catalog,array('route' => ['admin.users.update',$catalog],'method'=>'PUT')) !!}
                        @include('admin.catalogs.partials.fields')
                        <button type="submit" class="btn btn-default">Actualizar Catálogo</button>
                        {!! Form::close() !!}

                        <hr>

                        <h2>Fichas Asociadas a este Catálogo</h2>

                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                           + Agregar Ficha
                        </button>
                        <div class="collapse" id="collapseExample">
                            <div class="well">
                                {!! Form::open(array('route'=>['admin.tabs.tabcatalog',$catalog->id],'method'=>'GET')) !!}
                                @include('admin.catalogs.tabs.partials.fields')
                                <button type="submit" class="btn btn-default" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Crear Tab</button>
                                {!! Form::close() !!}
                            </div>
                        </div>


                        @include('admin.catalogs.tabs.partials.tables')
                    </div>
                    @include('admin.catalogs.partials.delete')
                </div>
            </div>
        </div>
    </div>
@endsection