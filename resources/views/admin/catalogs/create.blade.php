@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Catálogos</div>


                    @include('admin.partials.messages')



                    {!! Form::open(array('route' => 'admin.catalogs.store','method'=>'POST')) !!}

                    @include('admin.catalogs.partials.fields')

                    @include('admin.catalogs.tabs.partials.tables')



                    <button type="submit" class="btn btn-default">Crear Catálogo</button>




                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
