<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Id Unico de Tablet</th>
        <th>Descripción</th>
        <th>Aciones</th>
    </tr>
    @foreach($tablets  as $tablet)

        <tr data-id="{{ $tablet->id }}">
            <td>{{$tablet->id}}</td>
            <td>{{$tablet->idUnicoTablet}}</td>
            <td>{{$tablet->description}}</td>
            <td>
                <a href="{{ route('admin.tablets.edit', $tablet) }}">Editar</a>
                <a href="#!" class="btn-delete">Eliminar</a>
            </td>
        </tr>
        <tr>

        </tr>
    @endforeach
</table>