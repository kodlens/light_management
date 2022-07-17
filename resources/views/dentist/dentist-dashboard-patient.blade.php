@extends('layouts.dentist-app')


@section('content')
    <dentist-dashboard-patient prop-data='@json($data)'></dentist-dashboard-patient>
@endsection

