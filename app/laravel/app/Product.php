<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $fillable=['bread_name','stock','price'];
    
    public function kart(){
        return $this->belongsTo('App\Kart');
    }
}
