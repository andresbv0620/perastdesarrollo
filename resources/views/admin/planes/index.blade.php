@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Planes</div>

                    <div class="panel-body">
                        <p>
                            <a class="btn btn-default" href="{{route('admin.planes.create')}}" role="button">
                                Registrar Planes
                            </a>
                        </p><p>Hay {{$plans->total()}} Planes</p>
                        @include('admin.planes.partials.tables');
                      {!!$plans->render()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
