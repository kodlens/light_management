@extends('layouts.user')

@section('content')
    
    @auth
        <my-appointment prop-services='@json($services)' prop-user='@json($user)'></my-appointment>
    @endauth

@endsection
