<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Products;

class ProductImages extends Model
{
	protected $fillable = ['image_path'];

    public function products(){
        return $this->belongsTo(Products::class); 
    }
}
