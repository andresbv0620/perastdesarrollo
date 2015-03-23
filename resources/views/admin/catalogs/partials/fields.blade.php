<div class="form-group">
    {!!Form::label('name', 'Nombre')!!}
    {!!Form::text('name',null,['class'=>'form-control','placeholder'=>'Nombre del catálogo'])!!}

</div>
<div class="form-group">
    {!!Form::label('description', 'Descripción')!!}
    {!!Form::textarea('description',null,['class'=>'form-control','rows'=>'3','placeholder'=>'Descripcion'])!!}
</div>

