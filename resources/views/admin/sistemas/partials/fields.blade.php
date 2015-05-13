<div class="form-group">
    {!!Form::label('nombreDataBase', 'Base de datos sistema')!!}
    {!!Form::text('nombreDataBase',null,['class'=>'form-control','placeholder'=>'Base de datos sistema'])!!}
</div>

<div class="form-group">
    {!!Form::label('description', 'Descripción')!!}
    {!!Form::text('description',null,['class'=>'form-control','placeholder'=>'Descripción del sistema'])!!}
</div>
<h2>Asignar sistema a usuario</h2>
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
                <td>{!!Form::checkbox('user_id[]', $user->id, $userchecked,['class'=>'checkbox','id'=>$user->id])!!}</td>
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
                <td>{!!Form::checkbox('user_id[]', $user->id, $userchecked,['class'=>'checkbox','id'=>$user->id])!!}</td>
                <td>{!!Form::label('Nombre',$user->name)!!}</td>
                <td>{!!Form::label('Email',$user->email)!!}</td>
                <td>{!!Form::label('Página',$user->pagina)!!}</td>
            </tr>

    @endif

</table>


