@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Planes</div>

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
@endsection
