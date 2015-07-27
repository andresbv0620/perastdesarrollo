<div class="form-group">
    {!!Form::label('name', 'Nombre')!!}
    {!!Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre del catálogo'])!!}

</div>
<div class="form-group">
    {!!Form::label('description', 'Descripción')!!}
    {!!Form::textarea('description',null,['class'=>'form-control','rows'=>'3','placeholder'=>'Descripcion'])!!}
</div>
<div class="form-group">
    {!!Form::label('tipo', 'Tipo')!!}
    {!!Form::select('tipo', array('entradaSimple' => 'Entrada Simple', 'ordenVenta' => 'Orden Venta'), null, ['class'=>'form-control','placeholder' => 'Seleccione un tipo...']) !!}
</div>

