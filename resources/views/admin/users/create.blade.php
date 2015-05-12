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
            $('#superadmin').on('click',function(){
                if ($('#superadmin').is(':checked')) {
                    $('#plans-id').show();
                }else{
                    $('#plans-id').hide();
                }
            });
            $('#admin').on('click',function(){
                if ($('#admin').is(':checked')) {
                    $('#plans-id').show();
                }else{
                    $('#plans-id').hide();
                }
            });
            $('#recolector').on('click',function(){
                if ($('#recolector').is(':checked')) {
                    $('#plans-id').hide();
                }

            });

            $('#reportes').on('click',function(){
                if ($('#reportes').is(':checked')) {
                    $('#plans-id').hide();
                }
            });

        });

    </script>
@endsection
