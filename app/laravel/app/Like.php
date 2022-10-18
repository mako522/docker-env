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
  protected $fillable = ['review_id','user_id'];
    
  public function like_exist($id, $review_id)
  {
    $exist = Like::where('user_id', '=', $id)->where('review_id', '=', $review_id)->get();

        if (!$exist->isEmpty()) {
            return true;
        } else {
            return false;
        }
    }
}

