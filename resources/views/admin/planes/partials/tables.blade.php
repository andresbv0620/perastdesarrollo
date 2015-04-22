<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Nombre</th>

        <th>Capacidad GB</th>
        <th>Tablets</th>
        <th>Sistemas</th>
        <th>Vigencia</th>
        <th>Precio</th>
        <th>Periodicidad</th>

        <th>Acciones</th>

    </tr>
    @foreach($plans as $plan)
        <tr>
            <td>{{$plan->id}}</td>
            <td>{{$plan->nombre}}</td>

            <td>{{$plan->capacidad}}</td>
            <td>{{$plan->cantidadTablets}}</td>
            <td>{{$plan->sistemas}}</td>
            <td>{{$plan->duracion}}</td>
            <td>{{$plan->precio}}</td>
            <td>{{$plan->periodicidad}}</td>

            <td>
                <a href="{{ route('admin.planes.edit',$plan) }}">Editar</a>
                <a href="">Eliminar</a>
            </td>
        </tr>
    @endforeach
</table>