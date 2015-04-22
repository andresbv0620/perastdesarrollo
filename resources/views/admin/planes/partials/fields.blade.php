<div class="form-group">
    {!!Form::label('nombre', 'Nombre')!!}
    {!!Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Nombre del plan'])!!}
</div>
<div class="form-group">
    {!!Form::label('capacidad', 'Capacidad GB')!!}
    {!!Form::text('capacidad',null,['class'=>'form-control','placeholder'=>'GB'])!!}
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
    {!!Form::label('duracion', 'Vigente hasta')!!}
    <div class='input-group date' id='datetimepicker1'>
        {!!Form::date('duracion',null,['class'=>'form-control','placeholder'=>\Carbon\Carbon::now()])!!}
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('precio', 'Precio') !!}
    <div class="input-group">

        <span class="input-group-addon">$</span>
        {!! Form::text('precio',null,['class'=>'form-control','placeholder'=>'1.000.000']) !!}
    </div>
</div>
<div class="form-group">
    {!!Form::label('periodicidad', 'Periodicidad Cobro')!!}
    {!!Form::select('periodicidad',array('anual' => 'anual', 'mensual' => 'mensual'),['class'=>'form-control'])!!}
</div>

@section('scripts')
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker();
        });
    </script>
@endsection