<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    Public function user()
  {
    return $this->belongsTo('App\User');
  }
  Public function review()
  {
    return $this->belongsTo('App\Review');
  }
  
}
