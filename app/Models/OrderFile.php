<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderFile extends Model
{
    protected $table = 'order_files';

    protected $fillable = ['order_id', 'url', 'name', 'is_deleted'];

    // Solo mostrar archivos que NO estén eliminados
    public static function getActiveFiles($order_id)
    {
        return self::where('order_id', $order_id)
                ->where(function ($query) {
                    $query->whereNull('is_deleted')  // Si está NULL, es activo
                            ->orWhere('is_deleted', 0); // Si es 0, también es activo
                })
                ->get();
    }

}
