<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Base de datos sistema</th>
        <th>Descripción del sistema</th>

        <th>Acciones</th>

    </tr>


@if(!empty($sistemas))
    @foreach($sistemas as $sistema)
        <tr data-id="{{$sistema->id}}">
            <td>{{$sistema->id}}</td>
            <td>{{$sistema->nombreDataBase}}</td>
            <td>{{$sistema->description}}</td>

            <td>
                <a href="{{ route('admin.sistemas.edit',$sistema) }}">Editar</a>
                <a href="#!" class="btn-delete">Eliminar</a>
                @if(Entrust::hasRole('superadmin'))
                <button class="btn" type="button" data-toggle="collapse" data-target="#sistema{{$sistema->id}}" aria-expanded="false" aria-controls="collapseExample">
                    Ver Tablets
                </button>
                @endif
            </td>
        </tr>
            <tr>
                <td colspan="5">
                    <div class="collapse" id="sistema{{$sistema->id}}">
                        <div class="well">
                            <table class="table table-striped">
                                <tr>
                                    <th>#</th>
                                    <th>Id Unico de Tablet</th>
                                    <th>Descripcion</th>

                                                                    </tr>
                                @foreach($sistema->tablets  as $tablets)

                                    <tr>
                                        <td>{{$tablets->id}}</td>
                                        <td>{{$tablets->idUnicoTablet}}</td>
                                        <td>{{$tablets->description}}</td>

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