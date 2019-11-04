<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Image;
use App\Comment;
use App\Like;

class ImageController extends Controller
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

  /**
   * Returns a view where to upload images
   *
   * @author Darío Hernández
   * @return \Illuminate\Contracts\Support\Renderable
   *
   */
  public function create() {

    return view('image.create');

  }


  /**
   * It saves photos/images on storage\app\images and data on database
   *
   * @author Darío Hernández
   * @param Request $request
   * @return \Illuminate\Contracts\Support\Renderable
   *
   */
  public function save(Request $request) {

    // Validation
    $validate = $this -> validate($request, [
      'description' => 'required',
      'image_path' => ['required', 'image']
    ]);

    $image_path = $request -> file('image_path');
    $description = $request -> input('description');

    $image = new Image();

    $user = \Auth::user();
    $image -> description = $description;
    $image -> user_id = $user -> id;

    if($image_path) {
      $image_path_name = time().$image_path -> getClientOriginalName();
      Storage::disk('images') -> put($image_path_name, File::get($image_path));
      $image -> image_path = $image_path_name;
    }

    $image -> save();

    return redirect() -> route('home') -> with([
      'message' => 'Photo was succesfully uploaded!'
    ]);
  }

  /**
   * Returns requested image
   *
   * @author Darío Hernández
   * @param $filename
   * @return Response $file
   *
   */
  public function getImage($filename) {

    $file = Storage::disk('images') -> get($filename);
    return new Response($file, 200);

  }

  /**
   * Returns post details page
   *
   * @param $id
   * @author Darío Hernández
   * @return \Illuminate\Contracts\Support\Renderable
   *
   */
  public function detail($id) {

    $image = Image::find($id);
    return view('image.detail', [
      'image' => $image
    ]);

  }

  /**
   * Deletes an image post
   *
   * @author Darío Hernández
   * @param $id
   * @return \Illuminate\Contracts\Support\Renderable
   *
   */
  public function delete($id) {

    $user = \Auth::user();
    $image = Image::find($id);
    $comments = Comment::where('image_id', $id) -> get();
    $likes = Like::where('image_id', $id) -> get();

    if($user && $image -> user -> id == $user -> id) {

      // Delete comments
      if($comments && count($comments) >= 1) {
        foreach($comments as $comment) {
          $comment -> delete();
        }
      }

      // Delete likes
      if($likes && count($likes) >= 1) {
        foreach($likes as $like) {
          $like -> delete();
        }
      }

      // Delete image file
      Storage::disk('images') -> delete($image -> image_path);

      // Delete image databse record
      $image -> delete();

    }

    return redirect() -> route('home') -> with([
      'message' => 'Image deleted succesfully'
    ]);

  }

  /**
   * Edits an image post
   *
   * @author Darío Hernández
   * @param $id
   * @return \Illuminate\Contracts\Support\Renderable
   *
   */
  public function edit($id) {

    $user = \Auth::user();
    $image = Image::find($id);

    if($user && $image && $image -> user -> id == $user -> id) {

      return view('image.edit', [
        'image' => $image
      ]);

    } else {

      return redirect() -> route('home');

    }
  }


  /**
   * Updates post image
   *
   * @author Darío Hernández
   * @param Request $request
   * @return \Illuminate\Contracts\Support\Renderable
   *
   */
  public function update(Request $request) {

    // Validation
    $validate = $this -> validate($request, [
      'description' => 'required',
      'image_path' => 'image'
    ]);

    // Get post data
    $image_id = $request -> input('image_id');
    $description = $request -> input('description');
    $image_path = $request -> file('image_path');

    // Look for this record on database
    $image = Image::find($image_id);

    // Hydrate field description
    $image -> description = $description;

    // Save updated image
    if($image_path) {
      $image_path_name = time().$image_path -> getClientOriginalName();
      Storage::disk('images') -> put($image_path_name, File::get($image_path));
      $image -> image_path = $image_path_name;
    }

    // Update record
    $image -> update();

    return redirect() -> route('image-detail', ['id' => $image_id]) -> with([
      'message' => 'Photo was successfully updated'
    ]);
  }

}
