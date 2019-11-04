<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    // One to many relationship
    public function comments() {
      return $this -> hasMany('App\Comment') -> orderBy('id', 'desc');
    }

    public function likes() {
      return $this -> hasMany('App\Like');
    }

    // Many to one relationship

    public function user() {
      return $this -> belongsTo('App\User', 'user_id');
    }


}
