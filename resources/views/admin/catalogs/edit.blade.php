@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h1><small>Esta editando el catálogo:</small> {{$catalog->name}}</h1></div>
                    <div class="panel-body">
                        @include('admin.partials.messages')

                        {!! Form::model($catalog,array('route' => ['admin.catalogs.update',$catalog],'method'=>'PUT')) !!}
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
                                {!! Form::open(array('route'=>['admin.tabs.store'],'method'=>'POST')) !!}
                                @include('admin.catalogs.tabs.partials.fields')
                                {!!Form::hidden('catalog_id',$catalog->id)!!}
                                <button type="submit" class="btn btn-default">Crear Tab</button>
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
    {!! Form::open(['route'=>['admin.tabs.destroy',':OBJECT_ID'], 'method'=>'DELETE', 'id'=>'form-delete']) !!}

    {!! Form::close() !!}
    {!! Form::open(['route'=>['admin.entradas.destroy',':OBJECT_ID'], 'method'=>'DELETE', 'id'=>'form-delete-entrada']) !!}

    {!! Form::close() !!}
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('.opciones-group').hide();
            $(document).on('change','.tipo-entrada',function(e){
                e = e || event;
                var target = e.target || e.srcElement;
                var divtab=$(this).parents('.collapse').attr('id');

                if (target.value=='opcion_unica') {
                    $('#opcionesunic-'+divtab).show();
                }else{
                    $('#opcionesunic-'+divtab).hide();
                }

                if (target.value=='opcion_multiple') {
                    $('#opcionesmulti-'+divtab).show();
                }else{
                    $('#opcionesmulti-'+divtab).hide();
                }

            });

            $(document).on('click','.agregar',function(e){

                var row=$(this).parents('.opciones-group');
                var preopcion='<input class="disabled" name="" type="radio" value="">';
                var option='<input placeholder="Opción" name="opcion_name[]" type="text">';
                row.prepend(preopcion+option+"<br><br>");

            });

            $(".btn-delete").click(function(e){

                e.preventDefault();

                var row=$(this).parents('tr');
                var id=row.data('id');

                var form=$('#form-delete');
                var url=form.attr('action').replace(':OBJECT_ID', id);

                var data=form.serialize();

                row.fadeOut();
                $("#tab"+id).fadeOut();

                $.post(url, data, function (result) {
                    alert(result.message);
                }).fail(function (){
                    alert("El registro no fue eliminado");
                    row.show();
                });
            });

            $(".btn-delete-entrada").click(function(e){

                e.preventDefault();
                var row=$(this).parents('tr');

                var id=row.data('identrada');

                var form=$('#form-delete-entrada');
                var url=form.attr('action').replace(':OBJECT_ID', id);


                var data=form.serialize();

                $('#entrada'+id).fadeOut();


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