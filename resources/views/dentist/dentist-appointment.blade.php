@extends('layouts.dentist-app')

@section('content')
    <dentist-appointment prop-services='@json($services)'></dentist-appointment>
@endsection

