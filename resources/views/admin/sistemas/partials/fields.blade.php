<div class="form-group">
    {!!Form::label('nombreDataBase', 'Nombre de la empresa')!!}
    {!!Form::text('nombreDataBase',null,['class'=>'form-control','placeholder'=>'Nombre de la empresa'])!!}
</div>

<div class="form-group">
    {!!Form::label('description', 'Descripción')!!}
    {!!Form::text('description',null,['class'=>'form-control','placeholder'=>'Descripción de la empresa'])!!}
</div>
<div class="form-group">
    {!! Form::label('imagenFondo', 'Imagen de Fondo')!!}
    {!! Form::file('imagenFondo')!!}

    <p class="help-block">Suba una Imagen de Fondo. Tamaño Maximo 4Mb</p>
</div>
<div class="form-group">
    {!! Form::label('logo', 'Logo')!!}
    {!! Form::file('logo')!!}

    <p class="help-block">Suba un logo. Tamaño Maximo 4Mb</p>
</div>

<h2>Asignar administrador a la empresa</h2>
<table class="table table-striped">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Página</th>
    </tr>
    @if(isset($users))
        @foreach($users as $user)

            @if($usercheckeds!='')
            {!! $userchecked = in_array($user->id, $usercheckeds) ? true : false;!!}
            @endif
            <tr>
                <td>{!!Form::radio('user_id[]', $user->id, $userchecked,['class'=>'checkbox','id'=>$user->id])!!}</td>
                <td>{!!Form::label('Nombre',$user->name)!!}</td>
                <td>{!!Form::label('Email',$user->email)!!}</td>
                <td>{!!Form::label('Página',$user->pagina)!!}</td>
            </tr>
        @endforeach

    @elseif(isset($user))
            @if($usercheckeds!='')
                {!! $userchecked = in_array($user->id, $usercheckeds) ? true : false;!!}
            @endif
            <tr>
                <td>{!!Form::radio('user_id[]', $user->id, $userchecked,['class'=>'checkbox','id'=>$user->id])!!}</td>
                <td>{!!Form::label('Nombre',$user->name)!!}</td>
                <td>{!!Form::label('Email',$user->email)!!}</td>
                <td>{!!Form::label('Página',$user->pagina)!!}</td>
            </tr>
    @endif
</table>


