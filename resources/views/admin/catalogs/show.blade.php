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
                                            <a href="#tab-{{$tab->id}}" type="button" class="btn btn-primary btn-circle" disabled="disabled">{{$i=$i+1}}</a>
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

                                                @if($entrada->field_required==1)
                                                    <?php $required = 'required'?>
                                                @endif
                                                @if($entrada->field_type=='texto')
                                                    {!!Form::text($tab->id.'_'.$entrada->id,null,['class'=>'form-control','placeholder'=>$entrada->field_description,'required'=>$required, 'maxlength'=>'100'])!!}
                                                @elseif($entrada->field_type=='parrafo')
                                                    {!!Form::textarea($tab->id.'_'.$entrada->id,null,['class'=>'form-control','placeholder'=>$entrada->field_description,'required'=>$required, 'maxlength'=>'100'])!!}
                                                @elseif($entrada->field_type=='opcion_unica')
                                                    <div class="radio">
                                                        @foreach($opciones[$entrada->id] as $opcion)
                                                            <span> | </span>
                                                            <label>
                                                                {!! Form::radio($tab->id.'_'.$entrada->id, $opcion->option_name,false) !!}
                                                                {!!$opcion->option_name!!}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                @elseif($entrada->field_type=='opcion_multiple')
                                                    <div class="checkbox">
                                                        @foreach($opciones[$entrada->id] as $opcion)
                                                            <span> | </span>
                                                            <label>
                                                                {!! Form::checkbox($tab->id.'_'.$entrada->id, $opcion->option_name,false) !!}
                                                                {!! $opcion->option_name!!}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                @elseif($entrada->field_type=='fecha')
                                                    <div class="form-group">
                                                        {!!Form::label('duracion', 'Vigente hasta')!!}
                                                        <div class='input-group date' id='datetimepicker1'>
                                                            {!!Form::text('duracion',null,['class'=>'form-control','placeholder'=>\Carbon\Carbon::now()])!!}
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
                                                        </div>
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

    </script>


@endsection