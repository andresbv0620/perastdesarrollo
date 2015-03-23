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
                        {!! Form::open(array('route' => ['admin.entradas.show',$tab->id],'method'=>'GET')) !!}
                            <div class="form-group">
                                {!!Form::label('name', 'Nombre')!!}
                                {!!Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre del catálogo'])!!}
                            </div>
                            <div class="form-group">
                                {!!Form::label('description', 'Descripción')!!}
                                {!!Form::text('description',null,['class'=>'form-control','placeholder'=>'Descripcion'])!!}
                            </div>
                            <div class="form-group">
                                {!!Form::label('value', 'Opciones de Valores Separados por coma')!!}
                                {!!Form::text('value',null,['class'=>'form-control','placeholder'=>'valor 1, valor 2, valor 3'])!!}
                            </div>
                            <div class="form-group">
                                {!!Form::label('esPrincipal', 'Es Principal')!!}
                                {!!Form::text('esPrincipal',null,['class'=>'form-control','placeholder'=>'Si o No'])!!}
                            </div>
   
                            <button type="submit" class="btn btn-default">Crear Entrada</button>
                        {!! Form::close() !!}


                        <table class="table table-striped">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Posibles Valores</th>
                                <th>Es Principal</th>

                            </tr>
                            @foreach($entradas=$tab->entrada  as $entrada)
                                <tr>
                                    <td>{{$entrada->id}}</td>
                                    <td>{{$entrada->name}}</td>
                                    <td>{{$entrada->description}}</td>
                                    <td>{{$entrada->value}}</td>
                                    <td>{{$entrada->esPrincipal}}</td>

                                    <td>
                                        <a href="{{ route('admin.entradas.edit', $entrada) }}">Editar</a>
                                        <a href="{{ route('admin.entradas.destroy', $entrada) }}">Eliminar</a>
                                    </td>
                                </tr>
                                <tr>

                                </tr>
                            @endforeach
                        </table>




                    </div>
                </div>

            </td>
        </tr>



    @endforeach
</table>