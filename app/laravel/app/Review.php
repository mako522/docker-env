<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    Public function user()
  {
    return $this->belongsTo('App\User');
  }
  public function likes()
  {
    return $this->hasMany('App\Like');
  }
  Public function likedBy($user)
  {
    return Like::where('user_id', $user->id)->where('review_id', $this->id);
  }
}
