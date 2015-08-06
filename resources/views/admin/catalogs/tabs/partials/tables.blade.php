<div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id="myTabs">

        <?php
        $maxtabs=count($tabs);
            $k=0;
            $j=0;
        ?>

        @foreach($tabs as $tab)
            <?php $k=$k+1; ?>
            @if($k==$maxtabs)
                <li class="tab active" id="ficha{{$k}}" data-id="{{$tab->id}}" role="presentation"><a href="#tab{{$tab->id}}" aria-controls="tab{{$tab->id}}" role="tab" data-toggle="tab">{{$tab->name}}</a></li>
            @else
                <li class="tab" id="ficha{{$k}}" data-id="{{$tab->id}}" role="presentation"><a href="#tab{{$tab->id}}" aria-controls="tab{{$tab->id}}" role="tab" data-toggle="tab">{{$tab->name}}</a></li>
            @endif
        @endforeach
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        @foreach($tabs as $tab)
            <?php $j=$j+1; ?>
                @if($j==$maxtabs)
                    <div role="tabpanel" class="tab-pane active" id="tab{{$tab->id}}" data-id="{{$tab->id}}">
                        <div class="panel panel-body">
                            <div class="pull-left">
                                <h4>Descripción:</h4>
                                <p>{{$tab->description}}</p>
                            </div>
                            <div class="pull-right">
                                <h4>Acciones:</h4>
                                <a class="btn btn-default" href="{{ route('admin.tabs.edit', $tab) }}">Editar Ficha</a>
                                <a href="#!" class="btn-delete btn btn-danger">Eliminar Ficha</a>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="row-fluid">
                                <div id="tab{{$tab->id}}" class="col-lg-12">

                        <div class="container-fluid">
                            <div class="row-fluid">
                                <div class="col-lg-6">
                                    <h4>Entradas Creadas para esta ficha</h4>
                                    <table class="table table-hover table-condensed">
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>

                                            <th>Obligatorio</th>
                                            <th>Acciones</th>
                                        </tr>
                                        @foreach($entradas[$tab->id]  as $entrada)
                                            <tr data-identrada="{{$entrada->id}}" id="entrada{{$entrada->id}}">
                                                <td>{{$entrada->id}}</td>
                                                <td>{{$entrada->field_name}}</td>
                                                <td>{{$entrada->field_description}}</td>
                                                <td>{{$entrada->field_required}}</td>
                                                <td>
                                                    {{--<a href="{{ route('admin.entradas.edit', $entrada) }}">Editar</a>--}}
                                                    <a href="#!" class="btn-delete-entrada">Eliminar</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>

                                </div>
                                <div class="panel panel-default col-lg-6 well">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Crear nueva entrada</h3>
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

                                        <button type="submit" class="btn btn-primary">Crear Entrada</button>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>

                        </div>




                    </div>
                </div>
                        </div>
                    </div>
                @else
                    <div role="tabpanel" class="tab-pane" id="tab{{$tab->id}}" data-id="{{$tab->id}}">
                        <div class="panel panel-body">
                            <div class="pull-left">
                                <h4>Descripción:</h4>
                                <p>{{$tab->description}}</p>
                            </div>
                            <div class="pull-right">
                                <h4>Acciones:</h4>
                                <a class="btn btn-default" href="{{ route('admin.tabs.edit', $tab) }}">Editar Ficha</a>
                                <a href="#!" class="btn-delete btn btn-danger">Eliminar Ficha</a>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="row-fluid">
                                <div id="tab{{$tab->id}}" class="col-lg-12">

                                    <div class="container-fluid">
                                        <div class="row-fluid">
                                            <div class="col-lg-6">
                                                <h4>Entradas Creadas para esta ficha</h4>
                                                <table class="table table-hover table-condensed">
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Nombre</th>
                                                        <th>Descripción</th>

                                                        <th>Obligatorio</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                    @foreach($entradas[$tab->id]  as $entrada)
                                                        <tr data-identrada="{{$entrada->id}}" id="entrada{{$entrada->id}}">
                                                            <td>{{$entrada->id}}</td>
                                                            <td>{{$entrada->field_name}}</td>
                                                            <td>{{$entrada->field_description}}</td>
                                                            <td>{{$entrada->field_required}}</td>
                                                            <td>
                                                                {{--<a href="{{ route('admin.entradas.edit', $entrada) }}">Editar</a>--}}
                                                                <a href="#!" class="btn-delete-entrada">Eliminar</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>

                                            </div>
                                            <div class="panel panel-default col-lg-6 well">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title">Crear nueva entrada</h3>
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

                                                    <button type="submit" class="btn btn-primary">Crear Entrada</button>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>

                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>
                @endif

        @endforeach

    </div>

</div>


