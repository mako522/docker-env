<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['quantity'];
    public function user()
    {
        return $this->belongsTo('App\User');

        return $this->belongsTo('App\Time');
    }

}
