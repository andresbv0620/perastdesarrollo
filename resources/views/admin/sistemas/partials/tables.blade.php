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
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#sistema{{$sistema->id}}" aria-expanded="false" aria-controls="collapseExample">
                    Ver Tablets
                </button>
            </td>
        </tr>
            <tr>
                <td colspan="4">
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
                            </table>




                        </div>
                    </div>

                </td>
            </tr>
    @endforeach
@endif

</table>