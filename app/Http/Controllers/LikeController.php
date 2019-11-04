<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;

class LikeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function like($image_id) {

    $user = \Auth::user();

    $is_set_like = Like::where('user_id', $user -> id) -> where('image_id', (int)$image_id) -> count();

    if($is_set_like == 0) {
      $like = new Like();
      $like -> user_id = $user -> id;
      $like -> image_id = (int)$image_id;

      $like -> save();

      return response() -> json([
        'like' => $like,
        'message' => 'Liked succesfully'
      ]);

    } else {

      return response() -> json([
        'message' => 'Like already exists'
      ]);

    }

  }

  public function dislike($image_id) {

    $user = \Auth::user();

    $like = Like::where('user_id', $user -> id) -> where('image_id', $image_id) -> first();

    if($like) {

      $like -> delete();

      return response() -> json([
        'like' => $like,
        'message' => 'You disliked it succesfully'
      ]);

    } else {

      return response() -> json([
        'message' => 'Like doesn\'t exist'
      ]);

    }



  }

}
