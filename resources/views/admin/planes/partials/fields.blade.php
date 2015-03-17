<div class="form-group">
    {!!Form::label('nombre', 'Nombre')!!}
    {!!Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Nombre del plan'])!!}
</div>
<div class="form-group">
    {!!Form::label('usuariosAdmins', '# Usuarios')!!}
    {!!Form::text('usuariosAdmins',null,['class'=>'form-control','placeholder'=>'Número de Administradores'])!!}
</div>
<div class="form-group">
    {!!Form::label('usuariosReportes', '# Usuarios Reportes')!!}
    {!!Form::text('usuariosReportes',null,['class'=>'form-control','placeholder'=>'Número de Usuarios para Reportes'])!!}
</div>

<div class="form-group">
    {!!Form::label('cantidadTablets', '# Tablets')!!}
    {!!Form::text('cantidadTablets',null,['class'=>'form-control','placeholder'=>'Número de Tablets'])!!}
</div>
<div class="form-group">
    {!!Form::label('sistemas', '# Sistemas')!!}
    {!!Form::text('sistemas',null,['class'=>'form-control','placeholder'=>'Número de Sistemas'])!!}
</div>

<div class="form-group">

        {!!Form::label('duracion', 'Fecha Finalización')!!}
        {!!Form::date('duracion',null,['class'=>'input-medium datepick','placeholder'=>\Carbon\Carbon::now()])!!}

</div>

<div class="form-group">
    <div class="input-group">
        {!! Form::label('precio', 'Precio') !!}
        <div class="input-group-addon">$</div>
        {!! Form::text('precio',null,['class'=>'form-control','placeholder'=>'1.000.000']) !!}
    </div>
</div>
<div class="form-group">
    {!!Form::label('periodicidad', 'Periodicidad Cobro')!!}
    {!!Form::select('periodicidad', array('Anual' => 'Anual', 'Mensual' => 'Mensual'),['class'=>'form-control'])!!}
</div>
<div class="form-group">
    {!!Form::label('planCol', 'Plan Col')!!}
    {!!Form::text('planCol',null,['class'=>'form-control','placeholder'=>'PlanCol'])!!}
</div>