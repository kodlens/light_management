@extends('layouts.dentist-app')

@section('content')
    <dentist-service-patient prop-data='@json($data)' prop-admit-id={{ $admitid }} prop-tooth-id={{ $toothid }}></dentist-service-patient>
@endsection

