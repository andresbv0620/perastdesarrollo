@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h2><small>Está viendo el catálogo: </small> {{$catalog->name}}</h2></div>
                    <div class="panel-body">
                        @include('admin.partials.messages')

                        <style>

                            .stepwizard-step p {
                                margin-top: 10px;
                            }

                            .stepwizard-row {
                                display: table-row;
                            }

                            .stepwizard {
                                display: table;
                                width: 100%;
                                position: relative;
                            }

                            .stepwizard-step button[disabled] {
                                opacity: 1 !important;
                                filter: alpha(opacity=100) !important;
                            }

                            .stepwizard-row:before {
                                top: 14px;
                                bottom: 0;
                                position: absolute;
                                content: " ";
                                width: 100%;
                                height: 1px;
                                background-color: #ccc;
                                z-order: 0;

                            }

                            .stepwizard-step {
                                display: table-cell;
                                text-align: center;
                                position: relative;
                            }

                            .btn-circle {
                                width: 30px;
                                height: 30px;
                                text-align: center;
                                padding: 6px 0;
                                font-size: 12px;
                                line-height: 1.428571429;
                                border-radius: 15px;
                            }


                            /*estilos de opciones autocompletar dinamicas*/

                            .twitter-typeahead{
                                width:100%;
                            }

                            .twitter-typeahead .tt-query,
                            .twitter-typeahead .tt-hint {
                                margin-bottom: 0;
                            }
                            .tt-dropdown-menu {
                                min-width: 160px;
                                margin-top: 2px;
                                padding: 5px 0;
                                background-color: #fff;
                                border: 1px solid #ccc;
                                border: 1px solid rgba(0,0,0,.2);
                                *border-right-width: 2px;
                                *border-bottom-width: 2px;
                                -webkit-border-radius: 6px;
                                -moz-border-radius: 6px;
                                border-radius: 6px;
                                -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
                                -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
                                box-shadow: 0 5px 10px rgba(0,0,0,.2);
                                -webkit-background-clip: padding-box;
                                -moz-background-clip: padding;
                                background-clip: padding-box;
                                width:100%;
                            }

                            .tt-suggestion {
                                display: block;
                                padding: 3px 20px;
                            }

                            .tt-suggestion.tt-is-under-cursor {
                                color: #fff;
                                background-color: #0081c2;
                                background-image: -moz-linear-gradient(top, #0088cc, #0077b3);
                                background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0077b3));
                                background-image: -webkit-linear-gradient(top, #0088cc, #0077b3);
                                background-image: -o-linear-gradient(top, #0088cc, #0077b3);
                                background-image: linear-gradient(to bottom, #0088cc, #0077b3);
                                background-repeat: repeat-x;
                                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff0088cc', endColorstr='#ff0077b3', GradientType=0)
                            }

                            .tt-suggestion.tt-is-under-cursor a {
                                color: #fff;
                            }

                            .tt-suggestion p {
                                margin: 0;
                            }

                            /*Estilos para tabla de opciones dinamicas*/
                            .table-sortable tbody tr {
                                cursor: move;
                            }

                        </style>


                        <div class="container-fluid">
                            <div class="stepwizard">
                                <div class="stepwizard-row setup-panel">
                                    <?php $i=0 ?>
                                    @foreach($tabs as $tab)
                                    <div class="stepwizard-step">
                                        @if($i==0)
                                            <a href="#tab-{{$tab->id}}" type="button" class="btn btn-primary btn-circle">{{$i=$i+1}}</a>
                                        @else
                                            <a href="#tab-{{$tab->id}}" type="button" class="btn btn-default btn-circle" disabled="disabled">{{$i=$i+1}}</a>
                                        @endif

                                        <p>Paso {{$i}}</p>
                                    </div>
                                    @endforeach

                                </div>
                            </div>

                            {!! Form::open(array('route'=>['admin.inputs.store'],'method'=>'POST','role'=>'form')) !!}

                            @foreach($tabs as $tab)

                                <div class="row setup-content" id="tab-{{$tab->id}}">
                                    <div class="col-xs-12">
                                        <div class="col-md-12">
                                            <h3> {{$tab->name}}</h3>
                                            @foreach($entradas[$tab->id]  as $entrada)
                                                <div class="form-group">
                                                    <label class="control-label">{{$entrada->field_name}}<br>{{$entrada->field_description}}</label>
                                                    {!!Form::hidden('idcatalogo',$catalog->id)!!}

                                                    @if($entrada->field_required==1)
                                                        <?php $required = 'required'?>
                                                    @endif
                                                    @if($entrada->entradatipo_id==1)
                                                        {!!Form::text('respuesta['.$entrada->id.']',null,['class'=>'form-control','placeholder'=>$entrada->field_description,'required'=>$required, 'maxlength'=>'100'])!!}
                                                    @elseif($entrada->entradatipo_id==2)
                                                        {!!Form::textarea('respuesta['.$entrada->id.']',null,['class'=>'form-control','placeholder'=>$entrada->field_description,'required'=>$required, 'maxlength'=>'500'])!!}
                                                    @elseif($entrada->entradatipo_id==7)
                                                        {!!Form::text('respuesta['.$entrada->id.']',null,['class'=>'form-control','placeholder'=>$entrada->field_description,'required'=>$required, 'maxlength'=>'100'])!!}
                                                    @elseif($entrada->entradatipo_id==5)
                                                        <input id="input-24" type="hidden" value="imagen">
                                                        <div class="alert alert-info" role="alert">Entrada no disponible en la versión web, solo disponible en el App movil</div>
                                                    @elseif($entrada->entradatipo_id==8)
                                                        <input id="input-24" type="hidden" value="imagen">
                                                        <div class="alert alert-info" role="alert">Entrada no disponible en la versión web, solo disponible en el App movil</div>

                                                    @elseif($entrada->entradatipo_id==3)
                                                        <div class="radio">
                                                            @foreach($opciones[$entrada->id] as $opcion)
                                                                <span> | </span>
                                                                <label>
                                                                    {!! Form::radio('respuesta['.$entrada->id.']', $opcion->option_name,false) !!}
                                                                    {!!$opcion->option_name!!}
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    @elseif($entrada->entradatipo_id==4)
                                                        <div class="checkbox">
                                                            @foreach($opciones[$entrada->id] as $opcion)
                                                                <span> | </span>
                                                                <label>
                                                                    {!! Form::checkbox('respuesta['.$entrada->id.']', $opcion->option_name,false) !!}
                                                                    {!! $opcion->option_name!!}
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    @elseif($entrada->entradatipo_id==6)
                                                        <div class="form-group">
                                                            {!!Form::label('duracion', 'Vigente hasta')!!}
                                                            <div class='input-group date' id='datetimepicker1'>
                                                            {!!Form::text('respuesta['.$entrada->id.']',null,['class'=>'form-control','placeholder'=>\Carbon\Carbon::now(),'required'=>$required])!!}
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                            </div>
                                                        </div>
                                                    @elseif($entrada->entradatipo_id==9)

                                                        <div class="container-fluid">
                                                            <div class="row-fluid">
                                                                <input type="hidden" name="count" value="1" />
                                                                <div class="control-group" id="fields">
                                                                    <label class="control-label" for="field1">{!!$entrada->nombrecampo!!}</label>
                                                                    <div class="controls" id="profs">
                                                                        <div class="input-append">
                                                                            {{--{!!Form::text('respuesta['.$entrada->id.'][]',null,['data-opcionesdinamicas'=>$opcionesdinamicas[$entrada->id],'data-entradaid'=>$entrada->id,'autocomplete'=>'off', 'class'=>'span3 typeahead', 'id'=>$entrada->id.'field1','placeholder'=>$entrada->field_description])!!}--}}
                                                                            {!!Form::select('respuesta['.$entrada->id.'][]', $respuestasgrupo[$entrada->id], null, array('data-opcionesdinamicas'=>$opcionesdinamicas[$entrada->id],'data-entradaid'=>$entrada->id,'autocomplete'=>'off', 'class'=>'span3 typeahead form-control', 'id'=>$entrada->id.'field1'))!!}
                                                                            <button id="b1" class="btn btn-info add-more" type="button">+</button>

                                                                        </div>
                                                                        <br>
                                                                        <small>Presione + para añadir otro campo</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="container-fluid">
                                                            <div class="row-fluid clearfix">
                                                                <div class="col-md-12 table-responsive">
                                                                    <table class="table table-bordered table-hover table-sortable" id="tab_logic">
                                                                        <thead>
                                                                        <tr >
                                                                            @foreach($entrada->nombrecampoopciones as $campoopcion)
                                                                            <th class="text-center">
                                                                                {!!$campoopcion!!}
                                                                            </th>
                                                                            @endforeach
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr id='addr0' data-id="0" class="hidden">
                                                                            @foreach($entrada->nombrecampoopciones as $campoopcion)
                                                                            <td data-name="name">
                                                                                {!!Form::select('respuesta['.$entrada->id.'][]', $respuestasgrupo[$entrada->id], null, array('data-opcionesdinamicas'=>$opcionesdinamicas[$entrada->id],'data-entradaid'=>$entrada->id,'autocomplete'=>'off', 'class'=>'opciondinamica typeahead form-control', 'id'=>$entrada->id.'field1'))!!}

                                                                            </td>
                                                                            @endforeach


                                                                                                                                                        <td data-name="del">
                                                                                <button nam"del0" class='btn btn-danger glyphicon glyphicon-remove row-remove'></button>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <a id="add_row" class="btn btn-default pull-right">Agregar Fila</a>
                                                        </div>


                                                    @endif
                                                </div>
                                            @endforeach
                                            <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Siguiente</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-default">ENVIAR</button>
                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

        //Ajax calls
        /*$(document).ready(function(){
         $(document).on("change",".opciondinamica",function(e){
         e.preventDefault();
         alert($(this).val());
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
         });*/


        $(document).ready(function(){
            $('.opciones-group').hide();
            $(document).on('change','.tipo-entrada',function(e){
                e = e || event;
                var target = e.target || e.srcElement;
                var divtab=$(this).parents('.collapse').attr('id');

                if (target.value=='opcion_unica') {
                    $('#opciones-'+divtab).show();
                }else{
                    $('#opciones-'+divtab).hide();
                }
            });

            $(document).on('click','.agregar',function(e){
                var row=$(this).parents('.opciones-group');
                var preopcion='<input class="disabled" name="" type="radio" value="">';
                var option='<input placeholder="Opción" name="opcion_name[]" type="text">';
                row.prepend(preopcion+option+"<br><br>");
            });



        });


        $(document).ready(function () {

            var navListItems = $('div.setup-panel div a'),
                    allWells = $('.setup-content'),
                    allNextBtn = $('.nextBtn');

            allWells.hide();

            navListItems.click(function (e) {
                e.preventDefault();
                var $target = $($(this).attr('href')),
                        $item = $(this);

                if (!$item.hasClass('disabled')) {
                    navListItems.removeClass('btn-primary').addClass('btn-default');
                    $item.addClass('btn-primary');
                    allWells.hide();
                    $target.show();
                    $target.find('input:eq(0)').focus();
                }
            });

            allNextBtn.click(function(){
                var curStep = $(this).closest(".setup-content"),
                        curStepBtn = curStep.attr("id"),
                        nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                        curInputs = curStep.find("input[type='text'],input[type='url']"),
                        isValid = true;

                $(".form-group").removeClass("has-error");
                for(var i=0; i<curInputs.length; i++){
                    if (!curInputs[i].validity.valid){
                        isValid = false;
                        $(curInputs[i]).closest(".form-group").addClass("has-error");
                    }
                }

                if (isValid)
                    nextStepWizard.removeAttr('disabled').trigger('click');
            });

            $('div.setup-panel div a.btn-primary').trigger('click');
        });
        $(function () {
            $('#datetimepicker1').datetimepicker({format: 'YYYY/MM/DD'});
        });

        //Opciones dinamicas Campos
        $(document).ready(function(){
            $(".typeahead").each(function(){
                var next = 1;
                var entradaid = $(this).data('entradaid');
                var ops = $('#'+entradaid+'field'+next).data('opcionesdinamicas');
                var res = ops.split(",");
                console.log(res);

                var substringMatcher = function(strs) {
                    return function findMatches(q, cb) {
                        var matches, substringRegex;

                        // an array that will be populated with substring matches
                        matches = [];

                        // regex used to determine if a string contains the substring `q`
                        substrRegex = new RegExp(q, 'i');

                        // iterate through the pool of strings and for any string that
                        // contains the substring `q`, add it to the `matches` array
                        $.each(strs, function(i, str) {
                            if (substrRegex.test(str)) {
                                matches.push(str);
                            }
                        });

                        cb(matches);
                    };
                };

                var states = res;
                $('#'+entradaid+'field'+next).typeahead({
                            hint: true,
                            highlight: true,
                            minLength: 1
                        },
                        {
                            name: 'states',
                            source: substringMatcher(states)
                        });

                $('.tt-menu').css('background-color','#fff');
                $(".add-more").click(function(e){
                    e.preventDefault();
                    var addto = "#"+entradaid+"field" + next;
                    next = next + 1;
                    var newIn = '<br /><br /><input autocomplete="off" class="span3 typeahead" id="'+entradaid+'field' + next + '" name="respuesta[' + entradaid + '][]" type="text">';
                    var newInput = $(newIn);
                    $(addto).after(newInput);

                    $("#count").val(next);

                    $('#'+entradaid+'field'+next).typeahead({
                                hint: true,
                                highlight: true,
                                minLength: 1
                            },
                            {
                                name: 'states',
                                source: substringMatcher(states)
                            });
                    $('.tt-menu').css('background-color','#fff');

                });
            });
        });

        //Tabla dinamica
        $(document).ready(function() {
            $("#add_row").on("click", function() {
                // Dynamic Rows Code

                // Get max row id and set new id
                var newid = 0;
                $.each($("#tab_logic tr"), function() {
                    if (parseInt($(this).data("id")) > newid) {
                        newid = parseInt($(this).data("id"));
                    }
                });
                newid++;

                var tr = $("<tr></tr>", {
                    id: "addr"+newid,
                    "data-id": newid
                });

                // loop through each td and create new elements with name of newid
                $.each($("#tab_logic tbody tr:nth(0) td"), function() {
                    var cur_td = $(this);

                    var children = cur_td.children();

                    // add new td and element if it has a nane
                    if ($(this).data("name") != undefined) {
                        var td = $("<td></td>", {
                            "data-name": $(cur_td).data("name")
                        });

                        var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
                        c.attr("name", $(cur_td).data("name") + newid);
                        c.appendTo($(td));
                        td.appendTo($(tr));
                    } else {
                        var td = $("<td></td>", {
                            'text': $('#tab_logic tr').length
                        }).appendTo($(tr));
                    }
                });

                // add delete button and td
                /*
                 $("<td></td>").append(
                 $("<button class='btn btn-danger glyphicon glyphicon-remove row-remove'></button>")
                 .click(function() {
                 $(this).closest("tr").remove();
                 })
                 ).appendTo($(tr));
                 */

                // add the new row
                $(tr).appendTo($('#tab_logic'));

                $(tr).find("td button.row-remove").on("click", function() {
                    $(this).closest("tr").remove();
                });
            });




            // Sortable Code
            var fixHelperModified = function(e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();

                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width())
                });

                return $helper;
            };

            $(".table-sortable tbody").sortable({
                helper: fixHelperModified
            }).disableSelection();

            $(".table-sortable thead").disableSelection();



            $("#add_row").trigger("click");
        });

</script>
@endsection
