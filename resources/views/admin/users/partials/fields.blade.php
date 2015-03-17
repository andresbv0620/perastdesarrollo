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

<div class="form-group">
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

        @foreach($plans as $plan)
            <tr>
                <td>{!!Form::checkbox('plan_id', $plan->id, ['class'=>'checkbox'])!!}</td>
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
    </table>
</div>