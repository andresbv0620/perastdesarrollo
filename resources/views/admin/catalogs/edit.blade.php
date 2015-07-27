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

    {{--Forms para llamados ajax a traves de $.post--}}
    {!! Form::open(['route'=>['admin.tabs.destroy',':OBJECT_ID'], 'method'=>'DELETE', 'id'=>'form-delete']) !!}
    {!! Form::close() !!}

    {!! Form::open(['route'=>['admin.entradas.destroy',':OBJECT_ID'], 'method'=>'DELETE', 'id'=>'form-delete-entrada']) !!}
    {!! Form::close() !!}

    {!! Form::open(['route'=>['admin.catalogs.show',':OBJECT_ID'], 'method'=>'GET', 'id'=>'form-get-entradas']) !!}
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
                $('.opciones-group').hide();
                if (target.value==3) {

                    $('.opciones-'+divtab).show().empty().append(
                            "<div class='form-group'>" +
                            "<label class='radio-inline'>" +
                            "<input type='radio' class='disabled'>" +
                            "<input type='text' value='Opción 1' class='form-control' placeholder='Opción 1' name='opcion_name[]'>" +
                            "</label>" +
                            "</div>" +
                            "<div class='append-class'>" +
                            "</div>" +
                            "<fieldset disabled class='fieldset-disabled'>" +
                            "<div class='form-group'>" +
                            "<label class='radio-inline'>" +
                            "<input type='radio' class='disabled'>" +
                            "<a class='agregar'>" +
                            "<input type='text' class='form-control' placeholder='Agregar Opción'>" +
                            "</a>" +
                            "</label>" +
                            "</div>" +

                            "</fieldset>"
                    );

                }

                if (target.value==4) {
                    $('.opciones-'+divtab).show().empty().append(
                            "<div class='form-group'>" +
                            "<label class='checkbox-inline'>" +
                            "<input type='checkbox' class='disabled'>" +
                            "<input type='text' value='Opción 1' class='form-control' placeholder='Opción 1' name='opcion_name[]'>" +
                            "</label>" +
                            "</div>" +
                            "<div class='append-class'>" +
                            "</div>" +
                            "<fieldset disabled class='fieldset-disabled'>" +
                            "<div class='form-group'>" +
                            "<label class='checkbox-inline'>" +
                            "<input type='checkbox' class='disabled'>" +
                            "<a class='agregar'>" +
                            "<input type='text' class='form-control' placeholder='Agregar Opción'>" +
                            "</a>" +
                            "</label>" +
                            "</div>" +
                            "</fieldset>"
                    );
                }

                //Se cargan los catalogos de los cuales tomar las opciones para la entrada

                if (target.value==9) {
                    var table=<?php echo json_encode($tablaopciones, JSON_PRETTY_PRINT); ?>;
                    var options="<option></option>";
                    for (k in table) {
                        options=options+"<option value='"+k+"'>"+table[k]+"</option>"
                    }
                    var selectstr="<select id='tabla-catalogo' class='form-control' name='opdinamica_id'>"+options+"</select>";

                    $('.opciones-'+divtab).show().empty().append(
                            "<div class='form-group'>"
                            +"<label for='tabla-catalogo'>Catalogo: </label>"
                            +selectstr+
                            "</div>" +
                            "<div class='tablacatalogo-append-"+divtab +"'>" +
                            "</div>"
                    );
                }

                //Se cargan los campos del catalogo seleccionado para tomar las opciones para la entrada
                $(document).on("change","#tabla-catalogo",function(e){
                    e.preventDefault();
                    var row=$(this).parents('tr');
                    var id=$(this).val();

                    var form=$('#form-get-entradas');
                    var url=form.attr('action').replace(':OBJECT_ID', id);

                    if(id!="") {
                        $.get(url, function (result) {
                            //var options="<option></option>";
                            var options="";
                            for (k in result) {
                                for(j in result[k]) {
                                    console.log(result[k][j]['field_name']);
                                    //options=options+"<option value='"+result[k][j]['id']+"'>"+result[k][j]['field_name']+"</option>"
                                    options=options+"<label class='checkbox-inline'>"+"<input type='checkbox' name='campo_opcion[]' value='"+result[k][j]['id']+"'>"+result[k][j]['field_name']+"</label>"
                                }
                            }
                            //var selectstr="<select id='catalogo-entradas' class='form-control' name='campo_opcion'>"+options+"</select>";
                            var selectstr="<div class='form-group'>"+options+"</div>";

                            $('.tablacatalogo-append-'+divtab).empty().show().append(
                                    "<div class='form-group'>"
                                    +"<label for='tabla-catalogo'>Campos: </label>"
                                    +selectstr+
                                    "<textarea name='consulta' id='consulta' class='form-control' placeholder='Consulta SQL'>" +
                                    "</textarea>" +
                                    "</div>"
                            );

                        }).fail(function () {
                            alert("El registro no fue encontrado");
                            row.show();
                        });
                    }
                });

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
                row.append(
                        "<fieldset disabled class='fieldset-disabled'>" +
                        "<div class='form-group'>" +
                        "<label class='radio-inline'>" +
                        "<input type='radio' class='disabled'>" +
                        "<a class='agregar'>" +
                        "<input type='text' class='form-control' placeholder='Agregar Opción'>" +
                        "</a>" +
                        "</label>" +
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