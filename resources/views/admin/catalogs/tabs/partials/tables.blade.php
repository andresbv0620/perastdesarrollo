<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Acciones</th>

    </tr>
    @foreach($tabs as $tab)
        <tr data-id="{{$tab->id}}">
            <td>{{$tab->id}}</td>
            <td>{{$tab->name}}</td>
            <td>{{$tab->description}}</td>

            <td>
                <a href="{{ route('admin.tabs.edit', $tab) }}">Editar</a>
                <a href="#" class="btn-delete">Eliminar</a>
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#tab{{$tab->id}}" aria-expanded="false" aria-controls="collapseExample">
                    + Agregar Entradas
                </button>
            </td>
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
                                    <tr data-identrada="{{$entrada->id}}">
                                        <td>{{$entrada->id}}</td>
                                        <td>{{$entrada->field_name}}</td>
                                        <td>{{$entrada->field_description}}</td>
                                        <td>{{$entrada->field_type}}</td>
                                        <td>{{$entrada->field_required}}</td>

                                        <td>
                                            <a href="{{ route('admin.entradas.edit', $entrada) }}">Editar</a>
                                            <a href="#!" class="btn-delete-entrada">Eliminar</a>
                                        </td>
                                    </tr>
                                    <tr>

                                    </tr>
                                @endforeach
                            </table>
                            {!! Form::open(array('route' => ['admin.entradas.store'],'method'=>'POST')) !!}
                            {!!Form::hidden('tab_id',$tab->id)!!}
                            <div class="form-group">
                                {!!Form::label('field_name', 'Nombre')!!}
                                {!!Form::text('field_name',null,['class'=>'form-control','placeholder'=>'Nombre de la entrada'])!!}
                            </div>
                            <div class="form-group">
                                {!!Form::label('field_description', 'Descripción')!!}
                                {!!Form::text('field_description',null,['class'=>'form-control','placeholder'=>'Descripcion de la entrada'])!!}
                            </div>
                            <div class="form-group">
                                {!!Form::label('Tipo de Campo')!!}
                                {!!Form::select('field_type', array('texto' => 'Texto', 'parrafo' => 'Parrafo', 'opcion_unica' => 'Opción Única', 'opcion_multiple' => 'Opción Multiple'), 'Texto', array('class' => 'tipo-entrada'))!!}
                            </div>


                            <div class="form-group opciones-group" id="opcionesunic-tab{{$tab->id}}">
                                {!! Form::radio('', null,false,['class'=>'disabled']) !!}
                                {!!Form::text('opcion_name[]',null,['placeholder'=>'Opción'])!!}
                                <a class="agregar">Agregar Otra</a>
                            </div>

                            <div class="form-group opciones-group" id="opcionesmulti-tab{{$tab->id}}">
                                {!! Form::checkbox('', null,false,['class'=>'disabled']) !!}
                                {!!Form::text('opcion_name[]',null,['placeholder'=>'Opción'])!!}
                                <a class="agregar">Agregar Otra</a>
                            </div>

                            <div class="form-group">
                                {!!Form::label('field_required', 'Obligatorio')!!}:
                                Si {!!Form::radio('field_required',1, true)!!}
                                No {!!Form::radio('field_required',0)!!}
                            </div>

                            <button type="submit" class="btn btn-default">Crear Entrada</button>
                            {!! Form::close() !!}
                        </div>

                    </div>

                </td>
            </tr>
        </tr>




    @endforeach
</table>