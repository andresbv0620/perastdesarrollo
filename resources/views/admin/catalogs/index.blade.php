@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Catálogos</div>

                    @include('admin.partials.messages')

                    <div class="panel-body">
                        <p>
                            @if(count($catalogs)==0 && Entrust::hasRole('admin'))
                            <a class="btn btn-default" href="{{route('admin.catalogs.create')}}" role="button">
                                Crear Catálogo
                            </a>
                                @endif
                        </p><p>Hay {{ count($catalogs) }} Catalogos</p>

                        @include('admin.catalogs.partials.tables')

                        {!!$catalogs->render()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::open(['route'=>['admin.catalogs.destroy',':CATALOG_ID'], 'method'=>'DELETE', 'id'=>'form-delete']) !!}

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
                var url=form.attr('action').replace(':CATALOG_ID', id);
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
