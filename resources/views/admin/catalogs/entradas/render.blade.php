<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Acciones</th>

    </tr>
    @foreach($tabs as $tab)
        <tr>
            <td>{{$tab->id}}</td>
            <td>{{$tab->name}}</td>
            <td>{{$tab->description}}</td>

            <td>
                <a href="{{ route('admin.tabs.edit', $tab) }}">Editar</a>
                <a href="{{ route('admin.tabs.destroy', $tab) }}">Eliminar</a>
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#tab{{$tab->id}}" aria-expanded="false" aria-controls="collapseExample">
                    + Agregar Entradas
                </button>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div class="collapse" id="tab{{$tab->id}}">
                    <div class="well">
                        <table class="table table-striped">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Tipo</th>
                                <th>Obligatorio</th>
                                <th>Acciones</th>

                            </tr>
                            @foreach($entradas[$tab->id]  as $entrada)
                                <tr>
                                    <td>{{$entrada->id}}</td>
                                    <td>{{$entrada->field_name}}</td>
                                    <td>{{$entrada->field_description}}</td>
                                    <td>

                                        @if($entrada->field_type=='texto')
                                            {!!Form::text($tab->id.'_'.$entrada->field_name,null,['class'=>'form-control','placeholder'=>$entrada->field_description])!!}
                                        @elseif($entrada->field_type=='opcion_unica')
                                            @foreach($opciones[$entrada->id] as $opcion)
                                                {!! Form::radio($tab->id.'_'.$entrada->field_name, $opcion->option_name,false) !!}
                                                {!! Form::label('field_name', $opcion->option_name)!!}
                                            @endforeach

                                        @endif


                                    </td>
                                    <td>{{$entrada->field_required}}</td>

                                    <td>
                                        <a href="{{ route('admin.entradas.edit', $entrada) }}">Editar</a>
                                        <a href="{{ route('admin.entradas.destroy', $entrada) }}">Eliminar</a>
                                    </td>
                                </tr>
                                <tr>

                                </tr>
                            @endforeach
                        </table>
                        {{--{!! Form::open(array('route' => ['admin.entradas.store'],'method'=>'POST')) !!}--}}
                        {{--{!!Form::hidden('tab_id',$tab->id)!!}--}}
                        {{--<div class="form-group">--}}
                            {{--{!!Form::label('field_name', 'Nombre')!!}--}}
                            {{--{!!Form::text('field_name',null,['class'=>'form-control','placeholder'=>'Nombre del catálogo'])!!}--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--{!!Form::label('field_description', 'Descripción')!!}--}}
                            {{--{!!Form::text('field_description',null,['class'=>'form-control','placeholder'=>'Descripcion'])!!}--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--{!!Form::label('Tipo de Campo')!!}--}}
                            {{--{!!Form::select('field_type', array('texto' => 'Texto', 'parrafo' => 'Parrafo', 'opcion_unica' => 'Opción Única', 'opcion_multiple' => 'Opción Multiple'), 'Texto', array('class' => 'tipo-entrada'))!!}--}}
                        {{--</div>--}}


                        {{--<div class="form-group opciones-group" id="opciones-tab{{$tab->id}}">--}}
                            {{--{!! Form::radio('', null,false,['class'=>'disabled']) !!}--}}
                            {{--{!!Form::text('opcion_name[]',null,['placeholder'=>'Opción'])!!}--}}
                            {{--<a class="agregar">Agregar Otra</a>--}}
                        {{--</div>--}}



                        {{--<div class="form-group">--}}
                            {{--{!!Form::label('field_required', 'Obligatorio')!!}--}}
                            {{--{!!Form::checkbox('field_required',null,false)!!}--}}
                        {{--</div>--}}

                        {{--<button type="submit" class="btn btn-default">Crear Entrada</button>--}}
                        {{--{!! Form::close() !!}--}}
                    </div>

                </div>

            </td>
        </tr>



    @endforeach
</table>