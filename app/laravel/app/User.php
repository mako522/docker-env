<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public function order(){
        return $this->hasMany('App\Order');
    }
    public function ordersdetail(){
        return $this->hasMany('App\Ordersdetail');
    }
    public function product(){
        return $this->hasMany('App\Product');
    }
    public function time() { 
        return $this->hasMany('App\Time');
    }
    public function post()
    {
        return $this->hasMany('App\Review');
    }
    public function like()
    {
        return $this->hasMany('App\Like');
    }
    
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
}
