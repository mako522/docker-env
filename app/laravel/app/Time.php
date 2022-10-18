<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $fillable=['time_name'];
    
    public function user() {
    return $this->belongsTo('App\User');
    }
    public function order() {
        return $this->belongsTo('App\Order');
        }

}