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
    @endif
    @if(isset($user))
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

@if(isset($sistema))
<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#sistema{{$sistema->id}}" aria-expanded="false" aria-controls="collapseExample">
    Ver Tablets
</button>
<div class="collapse" id="sistema{{$sistema->id}}">
    <div class="well">

        <table class="table table-striped">
            <tr>
                <th>#</th>
                <th>Id Unico de Tablet</th>
                <th>Descripción</th>
            </tr>
            @foreach($sistema->tablets  as $tablet)

                <tr>
                    <td>{{$tablet->id}}</td>
                    <td>{{$tablet->idUnicoTablet}}</td>
                    <td>{{$tablet->description}}</td>
                    <td>
                        <a href="{{ route('admin.entradas.edit', $tablet) }}">Editar</a>
                        <a href="{{ route('admin.entradas.destroy', $tablet) }}">Eliminar</a>
                    </td>
                </tr>
                <tr>

                </tr>
            @endforeach
            <h2>Crear nueva tablet</h2>
            <div class="form-group" >
                {!!Form::label('idUnicoTablet', 'Id Unico de Tablet')!!}
                {!!Form::text('idUnicoTablet',null,['class'=>'form-control','placeholder'=>'Id Unico de Tablet'])!!}
            </div>
            <div class= "form-group" >
                {!!Form::label('description', 'Descripción')!!}
                {!!Form::text('description',null,['class'=>'form-control','placeholder'=>'Descripcion'])!!}
            </div>
        </table>
    </div>
</div>
@endif