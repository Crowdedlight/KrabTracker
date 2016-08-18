@extends('layout.master')

@section('content')
    <div class="panel panel-danger">
        <div class="panel-heading"><h3 class="panel-title">CREST Error</h3></div>
        <div class="panel-body">
            <p>
                Crest is currently not available. Blame CCP and try again in a few minutes!
            </p>
            <p>
                <a href="{{route('home')}}">Go back</a>
            </p>

        </div>
    </div>
@endsection