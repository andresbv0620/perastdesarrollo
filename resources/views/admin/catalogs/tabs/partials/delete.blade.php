{!! Form::open(['route'=>['admin.tabs.destroy',$tab], 'method'=>'DELETE']) !!}
<button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro que desea eliminar?')">Eliminar Ficha</button>
{!! Form::close() !!}