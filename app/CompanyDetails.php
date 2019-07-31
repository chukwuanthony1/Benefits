<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class CompanyDetails extends Model
{
	protected $fillable = [
        'company_name', 'company_code','address', 'address1', 'city_id', 'state_id', 'country_id'
    ];

    public function user(){
        return $this->belongsTo(User::class); 
    }

    
}
