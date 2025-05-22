<?php 

namespace App\Services;

use Illuminate\Http\Request;
use App\Customer;
use App\CustomerStatus;
use App\Models\Action;

use Carbon;
use DB;


class ActionService{

    public function filterModel(Request $request, $useDueDate = false)
{
    $model = Action::where(function ($query) use ($request, $useDueDate) {
        // Filtro de acciones pendientes si está especificado en el request
        if ($request->filled('pending')) {
            $query->whereNotNull('due_date')->whereNull('delivery_date');
        }

        // Determinar la columna de fecha a usar
        $dateColumn = $useDueDate ? 'due_date' : 'created_at';
        
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $fromDate = Carbon\Carbon::parse($request->from_date)->startOfDay();
            $toDate = Carbon\Carbon::parse($request->to_date)->endOfDay(); // Ajustar la hora final del día
            $query->whereBetween($dateColumn, [$fromDate, $toDate]);
        } elseif ($request->filled('from_date')) {
            $fromDate = Carbon\Carbon::parse($request->from_date)->startOfDay();
            $query->where($dateColumn, '>=', $fromDate);
        } elseif ($request->filled('to_date')) {
            $toDate = Carbon\Carbon::parse($request->to_date)->endOfDay(); // Ajustar la hora final del día
            $query->where($dateColumn, '<=', $toDate);
        }

        if ($request->filled('user_id')) {
            $query->where('creator_user_id', $request->user_id);
        }
        if ($request->filled('type_id')) {
            $query->where('type_id', $request->type_id);
        }

        // Filtro de búsqueda general
        if ($request->filled('action_search')) {
            $query->where(function ($subQuery) use ($request) {
                $searchTerm = '%' . $request->action_search . '%';
                $subQuery->where('note', 'like', $searchTerm);
                         // Agrega más columnas según sea necesario
            });
        }
    })
    ->orderBy('updated_at', 'desc')
    ->orderBy('type_id', 'asc')
    ->paginate(15);

    $model->getActualRows = $model->currentPage() * $model->perPage();

    return $model;
}

    


    public function getAll(Request $request) {
        // Iniciar el query base para acciones pendientes
        $query = Action::whereNotNull('due_date')->whereNull('delivery_date');
    
        
        if ($request->filled('user_id')) {
            $query = $query->where('creator_user_id', $request->user_id);
        }
    
        if ($request->filled('type_id')) {
            $query = $query->where('type_id', $request->type_id);
        }
    
        // Ordenar los resultados
        $query = $query->orderBy('updated_at', 'desc')->orderBy('type_id', 'asc');
    
        // Paginar los resultados
        $model = $query->get();

        
        return $model;
    }
            

    public function createFilteredRequest($originalRequest, $dateRangeType) {
        $filteredRequest = clone $originalRequest;
        $now = Carbon\Carbon::now();
    
        switch ($dateRangeType) {
            case 'overdue':
                $fromDate = Carbon\Carbon::createFromTimestamp(0); // 1970-01-01 00:00:00
                $toDate = $now->copy()->subSecond(); // Justo un segundo antes de ahora para incluir todo el día hasta este momento
                break;
            case 'today':
                $fromDate = $now->copy()->startOfDay(); // El inicio del día de hoy
                $toDate = $now->copy()->endOfDay(); // El final del día de hoy
                break;
            case 'upcoming':
                $fromDate = $now->copy()->addDay()->startOfDay(); // El inicio del día de mañana
                $toDate = $now->copy()->addWeek(); // Una semana a partir de ahora
                break;
            default:
                throw new \Exception('Invalid date range type');
        }
    
        $filteredRequest->merge([
            'pending' => true,
            'from_date' => $fromDate->toDateTimeString(),
            'to_date' => $toDate->toDateTimeString(),
        ]);
    
        return $filteredRequest;
    }
}
