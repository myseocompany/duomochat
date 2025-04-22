@extends('layout')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Clientes nuevos por mes</h1>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Año</th>
                <th>Mes</th>
                <th>Nuevos Clientes</th>
                <th>Total Acumulado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($newCustomersByMonth as $data)
                <tr>
                    <td>{{ $data->year }}</td>
                    <td>{{ $data->month }}</td>
                    <td>{{ $data->new_count }}</td>
                    <td>{{ $data->total_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection