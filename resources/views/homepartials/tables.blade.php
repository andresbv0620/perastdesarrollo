<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Base de datos sistema</th>
        <th>Descripción del sistema</th>
        <th>Seleccionar</th>
        <th></th>
    </tr>


@if(!empty($sistemas))
    @foreach($sistemas as $sistema)
        <tr data-id="{{$sistema->id}}">
            <td>{{$sistema->id}}</td>
            <td>{{$sistema->nombreDataBase}}</td>
            <td>{{$sistema->description}}</td>
            @if(Entrust::hasRole('superadmin'))
                @else
                <td>{!! Form::radio('tenant_connection', $sistema->id.'_'.$userid ) !!}</td>
            @endif
            <td>
                @if(Entrust::hasRole('superadmin'))
                <button class="btn" type="button" data-toggle="collapse" data-target="#sistema{{$sistema->id}}" aria-expanded="false" aria-controls="collapseExample">
                    Ver Usuarios
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
                                    <th>Email</th>
                                    <th>Página</th>
                                    <th>Seleccionar</th>
                                                                    </tr>
                                @foreach($sistema->users  as $user)

                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->pagina}}</td>
                                        <td>
                                            {!! Form::radio('tenant_connection', $sistema->id.'_'.$user->id ) !!}

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