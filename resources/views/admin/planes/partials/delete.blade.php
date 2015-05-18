{!! Form::open(['route'=>['admin.planes.destroy',$plan], 'method'=>'DELETE']) !!}

<button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro que desea eliminar?')">Eliminar Plan</button>


{!! Form::close() !!}