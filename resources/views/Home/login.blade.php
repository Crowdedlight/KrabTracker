@extends('layout.master')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron">
                <h1 class="text-center">KrabTracker </h1>
                <a href="{{URL::route('auth.login')}}"><img style="margin-top:50px;" class="center-block" src="{{URL::asset('/img/login_sso.png')}}"></a>

                @if (count($errors->all()) > 0)
                    <div class="alert alert-danger" role="alert" style="margin-top:50px">{{$errors->first()}}</div>
                @endif
            </div>
        </div>
    </div>

@endsection