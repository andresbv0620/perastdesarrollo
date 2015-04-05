@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Usuarios</div>

                    @include('admin.partials.messages')
                        {!! Form::open(array('route' => 'admin.users.store','method'=>'POST')) !!}

                        @include('admin.users.partials.fields')



                        <button type="submit" class="btn btn-default">Crear Usuario</button>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            $('#plans-id').hide();
            $('#role_id').on('change',function(){
                var rolVal= $(this).val();

                if(rolVal==2 || rolVal==1){
                    $('#plans-id').show();
                }else{
                    $('#plans-id').hide();
                }
            });
        });
    </script>
@endsection
