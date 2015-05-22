@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Sistemas</div>

                    <div class="panel-body">
                        @include('admin.partials.messages')
                        {!! Form::open(array('route' => 'admin.sistemas.store','method'=>'POST', 'enctype'=>'multipart/form-data')) !!}

                        @include('admin.sistemas.partials.fields')

                        <button type="submit" class="btn btn-default">Crear Sistema</button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection