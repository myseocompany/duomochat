@extends('layout')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Average Ticket per Month</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Nómero de Orders</th>
                <th>Suma de Valores</th>
                <th>Ticket Promedio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($model as $item)
            <tr>
                <td>{{ $item->year }}-{{ $item->month }}</td>
                <td>{{ $item->num_orders }}</td>
                <td>{{ number_format($item->sum_values, 0) }}</td>
                <td>{{ number_format($item->average_ticket, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection