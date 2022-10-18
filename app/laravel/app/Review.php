<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Review extends Model
{
    Public function user()
  {
    return $this->belongsTo('App\User');
  }
  public function like()
  {
    return $this->hasMany('App\Like');
  }
  public function isLikedBy($user): bool {
    return Like::where('user_id', $user->id)->where('review_id', $this->id)->first() !==null;
  }
}
