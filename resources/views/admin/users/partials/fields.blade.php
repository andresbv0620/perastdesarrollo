<!--Se cargan todos los roles-->
<div class="form-group">
    Roles
    <table class="table table-striped">
        <tr>
            <th></th>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripcion</th>
        </tr>
        @if(isset($roles))
            @foreach($roles as $role)
                @if($rolescheckeds!='')
                    {!! $rolechecked = in_array($role->id, $rolescheckeds) ? true : false;!!}
                @endif
                <tr>
                    <td>{!!Form::checkbox('role_id[]', $role->id, $rolechecked,['class'=>'checkbox','id'=>$role->name])!!}</td>
                    <td>{!!Form::label('ID',$role->id)!!}</td>
                    <td>{!!Form::label('Nombre',$role->display_name)!!}</td>
                    <td>{!!Form::label('Descripcion',$role->description)!!}</td>
                </tr>
            @endforeach
        @endif
    </table>
</div>
<div class="form-group">
    {!!Form::label('name', 'Nombre')!!}
    {!!Form::text('name',null,['class'=>'form-control','placeholder'=>'Introduzca su nombre'])!!}

</div>
<div class="form-group">
    {!!Form::label('email', 'Email')!!}
    {!!Form::text('email',null,['class'=>'form-control','placeholder'=>'Introduzca su email'])!!}
</div>
<div class="form-group">
    {!!Form::label('password', 'Contraseña')!!}
    {!!Form::password('password',['class'=>'form-control'])!!}
</div>
<div class="form-group">
    {!!Form::label('pagina', 'Página')!!}
    {!!Form::text('pagina',null,['class'=>'form-control','placeholder'=>'Introduzca su pagina'])!!}
</div>

<div class="form-group">
    {!! Form::label('imagenFondo', 'Imagen de Fondo')!!}
    {!! Form::file('imagenFondo')!!}

    <p class="help-block">Suba una Imagen de Fondo</p>
</div>
<div class="form-group">
    {!! Form::label('logo', 'Logo')!!}
    {!! Form::file('logo')!!}

    <p class="help-block">Suba un logo</p>
</div>

<!--Se cargan los planes solo para Super Admin y Admin-->
<div class="form-group" id="plans-id">
    Planes
    <table class="table table-striped">
        <tr>
            <th></th>
            <th>ID</th>
            <th>Nombre</th>
            <th>Administradores</th>
            <th>Reportes</th>
            <th>Tablets</th>
            <th>Sistemas</th>
            <th>Duracion</th>
            <th>Precio</th>
            <th>Periodicidad</th>
            <th>planCol</th>
        </tr>
        @if($plans <> "")
            @foreach($plans as $plan)
                <tr>
                    <td>{!!Form::radio('plan_id', $plan->id, ['class'=>'radio'])!!}</td>
                    <td>{!!Form::label('plan',$plan->id)!!}</td>
                    <td>{!!Form::label('nombre',$plan->nombre)!!}</td>
                    <td>{!!Form::label('usuariosAdmins',$plan->usuariosAdmins)!!}</td>
                    <td>{!!Form::label('usuariosReportes',$plan->usuariosReportes)!!}</td>
                    <td>{!!Form::label('cantidadTablets',$plan->cantidadTablets)!!}</td>
                    <td>{!!Form::label('sistemas',$plan->sistemas)!!}</td>
                    <td>{!!Form::label('duracion',$plan->duracion)!!}</td>
                    <td>{!!Form::label('precio',$plan->precio)!!}</td>
                    <td>{!!Form::label('periodicidad',$plan->periodicidad)!!}</td>
                    <td>{!!Form::label('planCol',$plan->planCol)!!}</td>
                </tr>
            @endforeach
        @endif
    </table>
</div>

<!--Se cargan todos los Sistemas Registrados para que esten disponibles para asociarlos al usuario-->
<div class="form-group">
    Sistemas
    <table class="table table-striped">
        <tr>
            <th></th>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
        </tr>

        @if($sistemas!='')
            @foreach($sistemas as $sistema)
                @if($sistemascheckeds!='')
                    {!! $sistemaschecked = in_array($sistema->id, $sistemascheckeds) ? true : false; !!}
                @endif
                <tr>
                    <td>{!!Form::checkbox('sistema_id[]', $sistema->id, $sistemaschecked, ['class'=>'checkbox'])!!}</td>
                    <td>{!!Form::label('Sistema Id',$sistema->id)!!}</td>
                    <td>{!!Form::label('nombreDataBase',$sistema->nombreDataBase)!!}</td>
                    <td>{!!Form::label('Descripción',$sistema->description)!!}</td>
                </tr>
            @endforeach
        @endif

    </table>
</div>