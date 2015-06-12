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

                        <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <div class="panel-heading"><h3>Fichas Asociadas a este Catálogo</h3></div>
                            <div class="panel-body">
                                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                    Agregar Ficha <span class="caret"></span>
                                </button>
                                <p><div class="collapse" id="collapseExample">
                                    <div class="well">
                                        {!! Form::open(array('route'=>['admin.tabs.store'],'method'=>'POST')) !!}
                                        @include('admin.catalogs.tabs.partials.fields')
                                        {!!Form::hidden('catalog_id',$catalog->id)!!}
                                        <button type="submit" class="btn btn-default">Crear Ficha</button>
                                        {!! Form::close() !!}
                                    </div>
                                </div></p>
                            </div>


                            @if(!empty($tabs[0]))
                                @include('admin.catalogs.tabs.partials.tables')
                            @endif
                        </div>
                        @include('admin.catalogs.partials.delete')
                    </div>

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
                    $('#opcionesmulti-'+divtab).empty();
                    $('#opcionesunic-'+divtab).empty().append("<div class='form-group'>" +
                    "<input type='radio' class='disabled'>" +
                    "<input type='text' value='Opción 1' class='' placeholder='Opción 1' name='opcion_name[]'>" +
                    "</div>" +
                    "<div class='append-class'>" +
                    "</div>" +
                    "<fieldset disabled class='fieldset-disabled'>" +
                    "<div class='form-group'>" +
                    "<input type='radio' class='disabled'>" +
                    "<a class='agregar'>" +
                    "<input type='text' placeholder='Agregar Opción'>" +
                    "</a>" +
                    "</div>" +
                    "</fieldset>");

                }else{
                    $('#opcionesunic-'+divtab).hide();
                }

                if (target.value=='opcion_multiple') {
                    $('#opcionesmulti-'+divtab).show();
                    $('#opcionesunic-'+divtab).empty();
                    $('#opcionesmulti-'+divtab).empty().append("<div class='form-group'>" +
                    "<input type='checkbox' class='disabled'>" +
                    "<input type='text' value='Opción 1' class='' placeholder='Opción 1' name='opcion_name[]'>" +
                    "</div>" +
                    "<div class='append-class'>" +
                    "</div>" +
                    "<fieldset disabled class='fieldset-disabled'>" +
                    "<div class='form-group'>" +
                    "<input type='checkbox' class='disabled'>" +
                    "<a class='agregar'>" +
                    "<input type='text' placeholder='Agregar Opción'>" +
                    "</a>" +
                    "</div>" +
                    "</fieldset>");
                }else{
                    $('#opcionesmulti-'+divtab).hide();
                }

                if ((target.value=='boton_siguiente')||(target.value=='boton_limpiar')||(target.value=='boton_anterior')||(target.value=='boton_guardar')) {
                    $('.fields').hide();
                }else{
                    $('.fields').show();
                }

            });

            $(document).on('click','.agregar',function(e){
                $(this).parents('.fieldset-disabled').removeAttr('disabled');
                $(this).removeClass();
                $(this).children().attr('name', 'opcion_name[]');
                $(this).children().attr('placeholder', 'Opción');
                $(this).children().focus();

                var row=$(this).parents('.fieldset-disabled').parent();
                row.append("<fieldset disabled class='fieldset-disabled'>" +
                "<div class='form-group'>" +
                "<input type='radio' class='disabled'>" +
                "<a class='agregar'>" +
                "<input type='text' placeholder='Agregar Opción'>" +
                "</a>" +
                "</div>" +
                "</fieldset>");

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