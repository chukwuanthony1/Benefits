<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class MerchantDetails extends Model
{
	protected $fillable = [
        'company_name', 'site_url', 'address', 'address1', 'city_id', 'state_id', 'country_id','image_path'
    ];

    public function user(){
        return $this->belongsTo(User::class); 
    }
}
