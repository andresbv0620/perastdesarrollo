@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Usuarios</div>

                    @include('admin.partials.messages')

                    <div class="panel-body">

                        {!! Form::open(['route' => 'admin.inputs.index', 'method'=>'GET', 'class' => 'navbar-form navbar-left pull-right', 'role' => 'search'])!!}
                            <div class="form-group">
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Item...']) !!}
                            </div>
                            <button type="submit" class="btn btn-default">Buscar</button>
                        {!! Form::close() !!}
                        <p>
                            <a class="btn btn-default" href="{{route('admin.inputs.create')}}" role="button">
                                Registrar Respuesta
                            </a>
                        </p><p>Hay {{$inputs->total()}} Respuestas</p>

                        @include('admin.inputs.partials.tables')

                        {!!$inputs->render()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::open(['route'=>['admin.inputs.destroy',':USER_ID'], 'method'=>'DELETE', 'id'=>'form-delete']) !!}

    {!! Form::close() !!}
@endsection


@section('scripts')
    <script>
        $(document).ready(function(){
            $(".btn-delete").click(function(e){
                e.preventDefault();

                var row=$(this).parents('tr');
                var id=row.data('id');
                var form=$('#form-delete');
                var url=form.attr('action').replace(':USER_ID', id);
                var data=form.serialize();

                row.fadeOut();

                $.post(url, data, function (result) {
                    alert(result.message);
                }).fail(function (){
                    alert("El usuario no fue eliminado");
                    row.show();
                });
            });
        });

    </script>


@endsection