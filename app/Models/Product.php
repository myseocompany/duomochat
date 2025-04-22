<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Laravel\Scout\Searchable;

class Product extends Model
{
    // use Searchable;
    //
    function status(){
    	return $this->belongsTo('App\Models\ProductStatus');
    }
    function customer(){
    	return $this->belongsTo('App\Models\Customer');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    function getParentCategoryText(){
    	
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    public function getURL(){
        return str_replace("%", "_", str_replace(" ", "-", $this->name)). ".png";
    }

    public function getPrice()
    {
        // Asumiendo que el precio se obtiene de alguna propiedad del modelo, por ejemplo $this->price
        $price = $this->price;
    
        // Formatear el precio
        $formattedPrice = '$ ' . number_format($price, 0, ',', '.');
    
        return $formattedPrice;
    }
}
