@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Usuario: {{$user->name}}</div>

                    <div class="panel-body">
                        @include('admin.partials.messages')
                        {!! Form::model($user,array('route' => ['admin.users.update',$user],'method'=>'PUT')) !!}

                        @include('admin.users.partials.fields')

                        <button type="submit" class="btn btn-default">Actualizar Usuario</button>

                        {!! Form::close() !!}
                    </div>
               </div>
            </div>
            @include('admin.users.partials.delete')
        </div>
    </div>
@endsection
