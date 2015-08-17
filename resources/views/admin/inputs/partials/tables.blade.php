<table class="table table-striped">
    <tr>
        @foreach($entradascampoid as $entradascampo)
            <th>{{$entradascampo->nombrecampo}}</th>

        @endforeach
    </tr>
    @foreach($respuestasgrupoarray as $key=>$row)

        <tr data-id="">
            @foreach($row as $colum)
                @if($colum->tipo==5)
                    <?PHP
                    $Base64Img = base64_decode($colum->respuesta);
                    file_put_contents($_SERVER["DOCUMENT_ROOT"].'/reportes_img/'.$key.'.png', $Base64Img);
                    ?>

                    <td><img class="img-upload" src="{{ asset('reportes_img/'.$key.'.png') }}" style="height: 80px; margin: 0px"></td>
                @else
                    <td>{{$colum->respuesta}}</td>
                @endif





            @endforeach
            <td>
                <a href="{{ route('admin.inputs.edit') }}">Editar</a>
                <a href="#!" class="btn-delete">Eliminar</a>
            </td>
        </tr>
    @endforeach


</table>