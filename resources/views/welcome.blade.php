@extends('layouts.user')

@section('content')
    <welcome-page></welcome-page>

    <booking-component></booking-component>

    @auth
        <services-component></services-component>
    @endauth

@endsection
