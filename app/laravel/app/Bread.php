<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bread extends Model
{
    protected $fillable=['bread_name','stock','price'];
    
    public function cart(){
        return $this->belongsTo('App\Cart');
    }
}
