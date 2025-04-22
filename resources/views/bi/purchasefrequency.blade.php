@extends('layout')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Frecuencia de Compra Promedio por Semestre</h1>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
        <tr>
            <th>Semestre</th>
            <th>Total de Pedidos</th>
            <th>Pedidos de Clientes Recurrentes</th>
            <th>Número de Clientes Únicos</th>
            <th>Número de Clientes Recurrentes</th>
            <th>Frecuencia de Compra General (en días)</th>
            <th>Frecuencia de Compra Recurrentes (en días)</th>
        </tr>
        </thead>
        <tbody>
        @foreach($resultados as $resultado)
            <tr>
                <td>{{ $resultado['semestre'] }}</td>
                <td>{{ $resultado['num_pedidos_totales'] }}</td>
                <td>{{ $resultado['num_pedidos_recurrentes'] }}</td>
                <td>{{ $resultado['num_clientes_unicos'] }}</td>
                <td>{{ $resultado['num_clientes_recurrentes'] }}</td>
                <td>{{ number_format($resultado['frecuencia_compra_general'], 2) }}</td>
                <td>{{ number_format($resultado['frecuencia_compra_recurrente'], 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
