<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Acciones</th>

    </tr>
    @foreach($catalogs as $catalog)
        <tr>
            <td>{{$catalog->id}}</td>
            <td>{{$catalog->name}}</td>
            <td>{{$catalog->description}}</td>

            <td>
                <a href="{{ route('admin.catalogs.edit', $catalog) }}">Editar</a>
                <a href="{{ route('admin.catalogs.destroy', $catalog) }}">Eliminar</a>
            </td>
        </tr>
    @endforeach
</table>