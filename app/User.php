<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\MerchantDetails;
use App\UserDetails;
use App\CompanyDetails;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    public function getJWTIdentifier()
    {
      return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
      return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
    }
    
    public function roles(){
      return $this->belongsToMany(Role::class);
    }

    public function authorizeRoles($roles){
      if (is_array($roles)) {
          return $this->hasAnyRole($roles) || 
                 abort(401, 'This action is unauthorized.');
      }
      return $this->hasRole($roles) || 
             abort(401, 'This action is unauthorized.');
    }

    public function hasAnyRole($roles){
      return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    public function hasRole($role){
      return null !== $this->roles()->where('name', $role)->first();
    }

    public function merchants(){
        return $this->hasMany(MerchantDetails::class); 
    }

    public function hasMerchant($user_id){
      return null !== $this->merchants()->where('user_id', $user_id)->first();
    }

    public function company(){
      return $this->belongsTo(CompanyDetails::class);
    }

    public function companies(){
        return $this->hasMany(CompanyDetails::class); 
    }

    public function userdetails(){
        return $this->hasMany(UserDetails::class); 
    }

}
