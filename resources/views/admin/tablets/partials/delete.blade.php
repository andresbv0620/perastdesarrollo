{!! Form::open(['route'=>['admin.tablets.destroy',$tablet], 'method'=>'DELETE']) !!}

<button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro que desea eliminar?')">Eliminar Tablet</button>


{!! Form::close() !!}