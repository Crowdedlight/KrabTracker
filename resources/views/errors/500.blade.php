@extends('layout.master')

@section('content')
    <div class="panel panel-danger">
        <div class="panel-heading"><h3 class="panel-title">Sever Error</h3></div>
        <div class="panel-body">
            <p>
                Something didn't go quite as planned. Go poke Crow LightBringer about this!
            </p>
            <p>
                <a href="{{route('home')}}">Go back</a>
            </p>

        </div>
    </div>
@endsection