@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Cliente: {{$user->name}}</div>

                    <div class="panel-body">
                        @include('admin.partials.messages')
                        {!! Form::model($user,array('route' => ['admin.users.update',$user],'method'=>'PUT')) !!}

                        @include('admin.users.partials.fields')

                        <button type="submit" class="btn btn-default">Actualizar Cliente</button>

                        {!! Form::close() !!}
                    </div>


                    <h2>Ver detalles de sistemas</h2>

                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        + Agregar Sistema
                    </button>
                    <div class="collapse" id="collapseExample">
                        <div class="well">
                            {!! Form::open(array('route'=>['admin.sistemas.store'],'method'=>'POST')) !!}
                            @include('admin.sistemas.partials.fields')
                            <button type="submit" class="btn btn-default" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Crear Sistema</button>
                            {!! Form::close() !!}
                        </div>
                    </div>

                    @include('admin.sistemas.partials.tables')




                    @include('admin.users.partials.delete')

               </div>
            </div>
        </div>
    </div>
@endsection
