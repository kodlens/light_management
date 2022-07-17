@extends('layouts.app')

@section('content')
    <appointment prop-services='@json($services)'></appointment>
@endsection

