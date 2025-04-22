<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SaleType extends Model
{
    protected $fillable = ['name', 'description'];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'sale_type_id');
    }
}
