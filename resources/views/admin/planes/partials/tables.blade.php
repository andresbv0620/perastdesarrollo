<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Administradores</th>
        <th>Reportes</th>
        <th>Tablets</th>
        <th>Sistemas</th>
        <th>Duración</th>
        <th>Precio</th>
        <th>Periodicidad</th>
        <th>PlanCol</th>
        <th>Acciones</th>

    </tr>
    @foreach($plans as $plan)
        <tr>
            <td>{{$plan->id}}</td>
            <td>{{$plan->nombre}}</td>
            <td>{{$plan->usuariosAdmins}}</td>
            <td>{{$plan->usuariosReportes}}</td>
            <td>{{$plan->cantidadTablets}}</td>
            <td>{{$plan->sistemas}}</td>
            <td>{{$plan->duracion}}</td>
            <td>{{$plan->precio}}</td>
            <td>{{$plan->periodicidad}}</td>
            <td>{{$plan->planCol}}</td>
            <td>
                <a href="{{ route('admin.planes.edit',$plan) }}">Editar</a>
                <a href="">Eliminar</a>
            </td>
        </tr>
    @endforeach
</table>