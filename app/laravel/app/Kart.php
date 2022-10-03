<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kart extends Model
{
    protected $fillable=['quantity'];

    public $timestamps=false;
}
