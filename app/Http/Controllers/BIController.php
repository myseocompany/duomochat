<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BI;
use DB;

class BIController extends Controller
{

    public function newcustomers()
    {
        // Obtener todos los registros ordenados por fecha
        $allRecords = BI::selectRaw('YEAR(FECHA) as year, MONTH(FECHA) as month, TERCERO')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $newCustomersByMonth = [];
        $seenCustomers = [];
        $totalCustomers = 0;

        foreach ($allRecords as $record) {
            $yearMonth = $record->year . '-' . $record->month;

            if (!isset($newCustomersByMonth[$yearMonth])) {
                $newCustomersByMonth[$yearMonth] = [
                    'new_count' => 0,
                    'total_count' => 0
                ];
            }

            // Si el cliente es nuevo
            if (!in_array($record->TERCERO, $seenCustomers)) {
                $newCustomersByMonth[$yearMonth]['new_count']++;
                $seenCustomers[] = $record->TERCERO;
            }
        }

        // Calcular el total acumulado
        $totalSoFar = 0;
        foreach ($newCustomersByMonth as $yearMonth => &$counts) {
            $totalSoFar += $counts['new_count'];
            $counts['total_count'] = $totalSoFar;
        }

        // Convertir el resultado a una colección para pasarlo a la vista y ordenar por año y mes
        $newCustomersByMonth = collect($newCustomersByMonth)->map(function ($counts, $yearMonth) {
            [$year, $month] = explode('-', $yearMonth);
            return (object) [
                'year' => $year,
                'month' => $month,
                'new_count' => $counts['new_count'],
                'total_count' => $counts['total_count']
            ];
        })->sortBy(function ($item) {
            return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
        });

        return view('bi.newcustomers', compact('newCustomersByMonth'));
    }


    public function purchaseFrequency()
{
    $resultados = []; // Almacenar el resultado final

    // Obtener todos los semestres en los que hubo compras
    $semestres = BI::select(DB::raw('DISTINCT CONCAT(YEAR(FECHA), "-S", IF(QUARTER(FECHA) IN (1,2), 1, 2)) as semestre'))
        ->orderBy('semestre')
        ->pluck('semestre');

    foreach ($semestres as $semestre) {
        // Número total de pedidos (facturas únicas) en el semestre
        $numPedidos = BI::where(DB::raw('CONCAT(YEAR(FECHA), "-S", IF(QUARTER(FECHA) IN (1,2), 1, 2))'), $semestre)
            ->distinct('NUMERO')
            ->count('NUMERO');

        // Número total de clientes únicos en el semestre
        $numClientesUnicos = BI::where(DB::raw('CONCAT(YEAR(FECHA), "-S", IF(QUARTER(FECHA) IN (1,2), 1, 2))'), $semestre)
            ->distinct('TERCERO')
            ->count('TERCERO');

        // Subconsulta para obtener los clientes que compraron más de una vez en el semestre
        $clientesRecurrentes = BI::select('TERCERO')
            ->where(DB::raw('CONCAT(YEAR(FECHA), "-S", IF(QUARTER(FECHA) IN (1,2), 1, 2))'), $semestre)
            ->groupBy('TERCERO')
            ->havingRaw('COUNT(DISTINCT NUMERO) > 1')
            ->pluck('TERCERO');

        // Número de pedidos de clientes que compraron más de una vez
        $numPedidosRecurrentes = BI::whereIn('TERCERO', $clientesRecurrentes)
            ->where(DB::raw('CONCAT(YEAR(FECHA), "-S", IF(QUARTER(FECHA) IN (1,2), 1, 2))'), $semestre)
            ->distinct('NUMERO')
            ->count('NUMERO');

        // Número de clientes que compraron más de una vez
        $numClientesRecurrentes = $clientesRecurrentes->count();

        // Calcular la frecuencia de compra general (180 días por semestre)
        $frecuenciaCompraGeneral = $numClientesUnicos > 0 ? (180 / ($numPedidos / $numClientesUnicos)) : 0;

        // Calcular la frecuencia de compra de los clientes que compraron más de una vez
        $frecuenciaCompraRecurrente = $numClientesRecurrentes > 0 ? (180 / ($numPedidosRecurrentes / $numClientesRecurrentes)) : 0;

        // Almacenar el resultado en el array final
        $resultados[] = [
            'semestre' => $semestre,
            'num_pedidos_totales' => $numPedidos,
            'num_pedidos_recurrentes' => $numPedidosRecurrentes,
            'num_clientes_unicos' => $numClientesUnicos,
            'num_clientes_recurrentes' => $numClientesRecurrentes,
            'frecuencia_compra_general' => $frecuenciaCompraGeneral,
            'frecuencia_compra_recurrente' => $frecuenciaCompraRecurrente,
        ];
    }

    return view('bi.purchasefrequency', compact('resultados'));
}



    //-----------------------------------------------------------------------------\\
    //funcion para calcular el tiket promedio
    public function averageTicket()
    {
        $results = []; // Almacenar el resultado final
    
        // Obtener todos los meses en los que hubo compras
        $months = BI::select(DB::raw('DISTINCT DATE_FORMAT(FECHA, "%Y-%m") as month'))
            ->orderBy('month')
            ->pluck('month');
    
        foreach ($months as $month) {
            // Número de pedidos (facturas únicas) en el mes
            $numOrders = BI::where(DB::raw('DATE_FORMAT(FECHA, "%Y-%m")'), $month)
                ->distinct('NUMERO')
                ->count('NUMERO');
    
            // Suma de los valores de las facturas en el mes
            $sumValues = BI::where(DB::raw('DATE_FORMAT(FECHA, "%Y-%m")'), $month)
                ->sum(DB::raw('BRUTO * CANTIDAD'));
    
            // Calcular el ticket promedio
            $averageTicket = $numOrders > 0 ? $sumValues / $numOrders : 0;
    
            // Almacenar el resultado en el array final
            $results[] = [
                'month' => $month,
                'num_orders' => $numOrders,
                'sum_values' => $sumValues,
                'average_ticket' => $averageTicket,
            ];
        }
    
        // Convertir el resultado a una colección para pasarlo a la vista y ordenar por mes
        $model = collect($results)->map(function ($result) {
            [$year, $month] = explode('-', $result['month']);
            return (object) [
                'year' => $year,
                'month' => $month,
                'num_orders' => $result['num_orders'],
                'sum_values' => $result['sum_values'],
                'average_ticket' => $result['average_ticket']
            ];
        })->sortBy(function ($item) {
            return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
        });
    
  
        return view('bi.averageTicket', compact('model'));
    }
}
