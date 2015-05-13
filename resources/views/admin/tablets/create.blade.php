@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Planes</div>

                    <div class="panel-body">
                        @include('admin.partials.messages')
                        {!! Form::open(array('route' => 'admin.tablets.store','method'=>'POST')) !!}

                        @include('admin.tablets.partials.fields')

                        <button type="submit" class="btn btn-default">Registrar Tablet</button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection