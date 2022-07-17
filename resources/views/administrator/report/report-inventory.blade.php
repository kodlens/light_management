@extends('layouts.print-layout')

@section('content')



    <div class="section">
        <div class="columns">
            <div class="column">
                <div class="buttons">
                    <button class="button is-info" onclick="history.back()">BACK</button>
                </div>
                <div class="printarea">
                    <table class="table">
                        <thead>
                        <th>ID</th>
                        <th>Item Name</th>
                        <th>Item Type</th>
                        <th>Quantity</th>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->item_id }}</td>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->item_type }}</td>
                                <td>{{ $item->qty }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


@endsection


