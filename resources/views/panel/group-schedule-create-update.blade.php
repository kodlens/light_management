@extends('layouts.app')

@section('content')
    @if($id > 0)
        <group-schedule-create-update
            prop-data='@json($data)'
            prop-id="{{ $id }}">
        </group-schedule-create-update>
    @else
        <group-schedule-create-update
            prop-data=''
            prop-id="0">
        </group-schedule-create-update>
    @endif

@endsection
