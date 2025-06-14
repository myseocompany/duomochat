<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActionExtraTestSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $fechas = [
            'past' => $now->copy()->subDays(2)->setTime(10, 0),
            'today' => $now->copy()->setTime(14, 0),
            'future' => $now->copy()->addDays(2)->setTime(11, 0),
        ];

        $acciones = [];

        foreach ($fechas as $label => $fecha) {
            // Acción normal: sin due_date ni delivery_date
            $acciones[] = [
                'note' => "Normal {$label}",
                'due_date' => null,
                'delivery_date' => null,
            ];

            // Acción pendiente: con due_date, sin delivery_date
            $acciones[] = [
                'note' => "Pendiente {$label}",
                'due_date' => $fecha,
                'delivery_date' => null,
            ];

            // Acción realizada: con due_date y delivery_date
            $acciones[] = [
                'note' => "Realizada {$label}",
                'due_date' => $fecha,
                'delivery_date' => $fecha->copy()->addHours(4),
            ];
        }

        foreach ($acciones as $item) {
            DB::table('actions')->insert([
                'note' => $item['note'],
                'due_date' => $item['due_date'],
                'delivery_date' => $item['delivery_date'],
                'object_id' => null,
                'customer_id' => 1,
                'type_id' => 1,
                'status_id' => 1,
                'creator_user_id' => 1,
                'updator_user_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
