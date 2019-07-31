<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    public function countries(){
	  return $this->belongsToMany(Countries::class);
	}

	public function userdetails(){
        return $this->hasMany(UserDetails::class); 
    }
}
