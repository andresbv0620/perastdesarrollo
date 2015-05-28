<div class="form-group" >
    {!!Form::label('idUnicoTablet', 'Id Unico de Tablet')!!}
    {!!Form::text('idUnicoTablet',null,['class'=>'form-control','placeholder'=>'Id Unico de Tablet'])!!}
</div>
<div class= "form-group" >
    {!!Form::label('description', 'Descripción')!!}
    {!!Form::text('description',null,['class'=>'form-control','placeholder'=>'Descripcion'])!!}
</div>

<!--Se cargan todos las tablets registradas-->
<div class="form-group">
    Tambien puede asignar al sistema actual una de las Tablets Registradas
    <table class="table table-striped">
        <tr>
            <th></th>
            <th>ID</th>
            <th>Id Único</th>
            <th>Descripcion</th>
        </tr>
        @if(isset($tablets))
            @foreach($tablets as $tablet)
                @if($tabletscheckeds!='')
                    {!! $tabletschecked = in_array($tablet->id, $tabletscheckeds) ? true : false;!!}
                @endif
                <tr>
                    <td>{!!Form::radio('tablet_id[]', $tablet->id, $tabletschecked,['class'=>'checkbox','id'=>$tablet->idUnicoTablet])!!}</td>
                    <td>{!!Form::label('ID',$tablet->id)!!}</td>
                    <td>{!!Form::label('Id Único',$tablet->idUnicoTablet)!!}</td>
                    <td>{!!Form::label('Descripcion',$tablet->description)!!}</td>
                </tr>
            @endforeach
        @endif
    </table>
</div>