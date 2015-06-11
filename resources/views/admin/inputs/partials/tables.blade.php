<table class="table table-striped">
    <tr>
        @foreach($entradas as $entrada)
            <th>{{$entrada->field_name}}</th>

        @endforeach
    </tr>
    @foreach($inputs as $input)

        <tr data-id="">
            @foreach($entradas as $entrada)
                <?php $inputKey=($entrada->tab_id)."_".($entrada->id)?>
                <td>{{$input->$inputKey}}</td>
            @endforeach
            <td>
                <a href="{{ route('admin.inputs.edit') }}">Editar</a>
                <a href="#!" class="btn-delete">Eliminar</a>
            </td>
        </tr>
    @endforeach

</table>