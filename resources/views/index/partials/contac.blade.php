<ul>
    @foreach( $errors->all () as $error )
        <li></li>
    @endforeach
</ul>

{!! Form::open(array('route' => 'contact_store', 'class' => 'form')) !!}

<div class="form-group" >
    {!! Form::label('name','Nombre') !!}
    {!! Form::text('name', null,
    array('required',
    'class'=>'form-control',
    'placeholder'=>'Nombre')) !!}
</div>

<div class= "form-group">
    {!! Form::label('email','Email') !!}
    {!! Form::text('email', null,
    array('required',
    'class'=>'form-control',
    'placeholder'=>'Email')) !!}
</div>

<div class= "form-group">
    {!! Form::label('message','Mensaje') !!}
    {!! Form::textarea('message', null,
    array('required',
    'class'=>'form-control',
    'placeholder'=>'Por favor especifique el plan en el cual esta interesado...')) !!}
</div>

<div class= "form-group">
    {!! Form::submit('Enviar',
    array('class'=>'btn btn-primary')) !!}
</div>
{!! Form::close() !!}