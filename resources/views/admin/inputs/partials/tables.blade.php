<table class="table table-striped">
    <tr>
        @foreach($entradascampoid as $entradascampo)
            <th>{{$entradascampo->nombrecampo}}</th>

        @endforeach
    </tr>
    @foreach($respuestasgrupoarray as $row)

        <tr data-id="">
            @foreach($row as $colum)
                <td>{{$colum->respuesta}}</td>
            @endforeach
            <td>
                <a href="{{ route('admin.inputs.edit') }}">Editar</a>
                <a href="#!" class="btn-delete">Eliminar</a>
            </td>
        </tr>
    @endforeach


</table>