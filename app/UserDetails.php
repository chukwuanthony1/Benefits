<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\States;
use App\Countries;
use App\Cities;

class UserDetails extends Model
{
	protected $fillable = [
        'first_name', 'last_name', 'phone_no', 'email', 'address', 'address1', 'company_id', 'city_id', 'state_id', 'country_id'
    ];

    public function user(){
        return $this->belongsTo(User::class); 
    }

    public function states(){
	  return $this->belongsToMany(States::class);
	}

	public function countries(){
	  return $this->belongsToMany(Countries::class);
	}

	public function cities(){
	  return $this->belongsToMany(Cities::class);
	}
}
