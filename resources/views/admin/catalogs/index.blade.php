@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Catálogos</div>

                    @if(Session::has('message'))
                        <p class="alert alert-success">{{ Session::get('message') }}</p>
                    @endif

                    <div class="panel-body">
                        <p>
                            <a class="btn btn-default" href="{{route('admin.catalogs.create')}}" role="button">
                                Crear Catálogo
                            </a>
                        </p><p>Hay {{$catalogs->total()}} Planes</p>

                        @include('admin.catalogs.partials.tables')

                        {!!$catalogs->render()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection