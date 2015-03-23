@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Tab para {{ $catalog->name }}</div>

                    @include('admin.partials.messages')
                   {!! Form::open(array('route' => ['admin.tabs.store',$catalog],'method'=>'POST')) !!}

                    @include('admin.catalogs.tabs.partials.fields')

                    <button type="submit" class="btn btn-default">Adicionar Ficha</button>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
