@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Tablets</div>

                    <div class="panel-body">
                        <p>
                            <a class="btn btn-default" href="{{route('admin.tablets.create')}}" role="button">
                                Registrar Tablets
                            </a>
                        </p><p>Hay {{$tablets->total()}} Tablets</p>
                        @include('admin.tablets.partials.tables')
                      {!!$tablets->render()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::open(['route'=>['admin.tablets.destroy',':OBJECT_ID'], 'method'=>'DELETE', 'id'=>'form-delete']) !!}

    {!! Form::close() !!}
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $(".btn-delete").click(function(e){
                e.preventDefault();

                var row=$(this).parents('tr');
                var id=row.data('id');
                var form=$('#form-delete');
                var url=form.attr('action').replace(':OBJECT_ID', id);
                var data=form.serialize();

                row.fadeOut();

                $.post(url, data, function (result) {
                    alert(result.message);
                }).fail(function (){
                    alert("El registro no fue eliminado");
                    row.show();
                });
            });
        });

    </script>


@endsection
