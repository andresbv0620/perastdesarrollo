@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Empresas</div>

                    @include('admin.partials.messages')

                    <div class="panel-body">
                        <p>
                            <a class="btn btn-default" href="{{route('admin.sistemas.create')}}" role="button">
                                Crear Empresa
                            </a>
                        </p><p>Hay {{$sistemas->total()}} Empresas</p>
                        {!! Form::open(['route' => 'tenants_path','method'=>'POST']) !!}
                        @include('admin.sistemas.partials.tables')

                        {!! Form::close() !!}
                        {!!$sistemas->render()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::open(['route'=>['admin.sistemas.destroy',':OBJECT_ID'], 'method'=>'DELETE', 'id'=>'form-delete']) !!}

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
                var url=form.attr('action').replace(':OBJECT_ID', id);
                var data=form.serialize();

                row.fadeOut();

                $.post(url, data, function (result) {
                    alert(result.message);
                }).fail(function (){
                    alert("El registro no fue eliminado");
                    row.show();
                });
            });
        });

    </script>


@endsection
