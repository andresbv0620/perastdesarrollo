@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Sistemas</div>

                    <div class="panel-body">
                        <p>
                            <a class="btn btn-default" href="{{route('admin.sistemas.create')}}" role="button">
                                Crear Sistema
                            </a>
                        </p><p>Hay {{$sistemas->total()}} Sistemas</p>
                        {!! Form::open(['route' => 'tenants_path','method'=>'POST']) !!}
                        @include('admin.sistemas.partials.tables');
                        {!! Form::close() !!}
                        {!!$sistemas->render()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
