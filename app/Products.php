<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductImages;

class Products extends Model
{
    public function productImages(){
        return $this->hasMany(ProductImages::class); 
    }
}
