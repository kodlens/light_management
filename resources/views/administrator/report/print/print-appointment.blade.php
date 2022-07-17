@extends('layouts.print-layout')

@section('content')

    <div class="section">
        <div class="printarea">
            <table class="table">
                <thead>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Appointment</th>
                    <th>Dentist Name</th>
                    <th>Status</th>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $item->appointment_id }}</td>
                            <td>{{ $item->user_lname }}, {{ $item->user_fname }} {{ $item->user_mname }}</td>
                            <td>{{ $item->appoint_date }}, {{ $item->appoint_time }} {{ $item->user_mname }}</td>
                            <td>{{ $item->dentist_lname }}, {{ $item->dentist_fname }} {{ $item->dentist_mname }}</td>
                            <td>
                                @if($item->appoint_status == 0)
                                    PENDING
                                @elseif($item->appoint_status == 1)
                                    ADMITTED
                                @else
                                    CANCELLED
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection


