<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Base de datos sistema</th>
        <th>Descripción del sistema</th>
        <th>Acciones</th>
    </tr>


@if(!empty($sistemas))
    @foreach($sistemas as $sistema)
        <tr>
            <td>{{$sistema->id}}</td>
            <td>{{$sistema->nombreDataBase}}</td>
            <td>{{$sistema->description}}</td>
            <td>
                <a href="{{ route('admin.sistemas.edit',$sistema) }}">Editar</a>
                <a href="">Eliminar</a>
            </td>
        </tr>
    @endforeach
@endif

</table>