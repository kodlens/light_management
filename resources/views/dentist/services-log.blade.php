@extends('layouts.dentist-app')

@section('content')
    <services-log prop-patient-id={{ $patient }} prop-app-id={{ $appid }}></services-log>
@endsection

