@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h1><small>Está viendo el catálogo:</small> {{$catalog->name}}</h1></div>
                    <div class="panel-body">
                        @include('admin.partials.messages')

                        {{--{!! Form::model($catalog,array('route' => ['admin.users.update',$catalog],'method'=>'PUT')) !!}
                        @include('admin.catalogs.homepartials.fields')
                        <button type="submit" class="btn btn-default">Actualizar Catálogo</button>
                        {!! Form::close() !!}--}}

                        <hr>

                        <h2>Fichas Asociadas a este Catálogo</h2>

                        {{--<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            + Agregar Ficha
                        </button>--}}
                        <div class="collapse" id="collapseExample">
                            <div class="well">
                                {!! Form::open(array('route'=>['admin.tabs.tabcatalog',$catalog->id],'method'=>'GET')) !!}
                                @include('admin.catalogs.tabs.partials.fields')
                                <button type="submit" class="btn btn-default" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Crear Tab</button>
                                {!! Form::close() !!}
                            </div>
                        </div>

                        {!! Form::open(array('route'=>['admin.inputs.store'],'method'=>'POST')) !!}
                            @include('admin.catalogs.entradas.render')
                        <button type="submit" class="btn btn-default">ENVIAR</button>
                        {!! Form::close() !!}
                    </div>
                    @include('admin.catalogs.partials.delete')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('.opciones-group').hide();
            $(document).on('change','.tipo-entrada',function(e){
                e = e || event;
                var target = e.target || e.srcElement;
                var divtab=$(this).parents('.collapse').attr('id');

                if (target.value=='opcion_unica') {
                    $('#opciones-'+divtab).show();
                }else{
                    $('#opciones-'+divtab).hide();
                }
            });

            $(document).on('click','.agregar',function(e){

                var row=$(this).parents('.opciones-group');
                var preopcion='<input class="disabled" name="" type="radio" value="">';
                var option='<input placeholder="Opción" name="opcion_name[]" type="text">';
                row.prepend(preopcion+option+"<br><br>");

            });



        });

    </script>


@endsection