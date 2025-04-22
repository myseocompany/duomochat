<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CustomerFrequency extends Model
{
    protected $fillable = ['name', 'description'];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'customer_frequency_id');
    }
}
