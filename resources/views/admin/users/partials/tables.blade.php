<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Email</th>
        {{--<th>Contraseña</th>--}}
        <th>Pagina</th>
        <th>Background</th>
        <th>Logo</th>
        <th>Acciones</th>

    </tr>
    @foreach($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            {{--<td>{{$user->password}}</td>--}}
            <td>{{$user->pagina}}</td>
            <td>{{$user->imagenFondo}}</td>
            <td>{{$user->logo}}</td>
            <td>
                <a href="{{ route('admin.users.edit', $user) }}">Editar</a>
                <a href="">Eliminar</a>
            </td>
        </tr>
    @endforeach
</table>