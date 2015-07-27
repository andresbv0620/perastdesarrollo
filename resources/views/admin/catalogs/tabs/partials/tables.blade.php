<table class="table">
    <tr>
        <th>Id</th>
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
                <button class="btn btn-default pull-right" type="button" data-toggle="collapse" data-target="#tab{{$tab->id}}" aria-expanded="false" aria-controls="collapseExample">
                    Agregar Entradas <span class="caret"></span>
                </button>
            </td>
            <tr>
                <td colspan="4">
                    <div class="collapse" id="tab{{$tab->id}}">
                        <div class="well">
                            <table class="table table-hover table-condensed">
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Tipo</th>
                                    <th>Obligatorio</th>
                                    <th>Acciones</th>
                                </tr>
                                @foreach($entradas[$tab->id]  as $entrada)
                                    <tr data-identrada="{{$entrada->id}}" id="entrada{{$entrada->id}}">
                                        <td>{{$entrada->id}}</td>
                                        <td>{{$entrada->field_name}}</td>
                                        <td>{{$entrada->field_description}}</td>
                                        <td>{{$entrada->field_type}}</td>
                                        <td>{{$entrada->field_required}}</td>
                                        <td>
                                            {{--<a href="{{ route('admin.entradas.edit', $entrada) }}">Editar</a>--}}
                                            <a href="#!" class="btn-delete-entrada">Eliminar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Nueva pregunta o entrada</h3>
                                </div>
                                <div class="panel-body">
                                    {!! Form::open(array('route' => ['admin.entradas.store'],'method'=>'POST')) !!}
                                    {!!Form::hidden('tab_id',$tab->id)!!}
                                    <div class="fields">
                                        <div class="form-group">
                                            {!!Form::label('field_name', 'Nombre')!!}
                                            {!!Form::text('field_name',null,['class'=>'form-control','placeholder'=>'Nombre de la entrada'])!!}
                                        </div>
                                        <div class="form-group">
                                            {!!Form::label('field_description', 'Descripción')!!}
                                            {!!Form::text('field_description',null,['class'=>'form-control','placeholder'=>'Descripcion de la entrada'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('Tipo de Campo')!!}
                                        {!!Form::select('entradatipo_id', $entradatipos, 'Texto', array('class' => 'tipo-entrada form-control'))!!}
                                    </div>



                                    <div class="col-lg-6 form-group opciones-group opciones-tab{{$tab->id}}">
                                    {{--Aqui van las opciones agregadas con append jquery--}}
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
                        </div>

                    </div>

                </td>
            </tr>
        </tr>
    @endforeach
</table>