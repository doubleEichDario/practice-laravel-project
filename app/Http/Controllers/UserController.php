<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UserController extends Controller
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
     * Show all users
     *
     * @author Darío Hernández
     * @param $search
     * @return \Illuminate\Contracts\Support\Renderable
     *
     */
    public function index($search = null) {

      if(!$search) {

        $user = User::orderBy('id', 'desc') -> paginate(5);

      } else {

        $user = User::where('nick', 'LIKE', '%'.$search.'%')
                    -> orWhere('name', 'LIKE', '%'.$search.'%')
                    -> orWhere('surname', 'LIKE', '%'.$search.'%')
                    -> orderBy('id', 'desc')
                    -> paginate(5);

      }

      return view('user.index', [
        'users' => $user
      ]);

    }

    /**
     * Returns a filled form with values to update
     *
     * @author Darío Hernández
     * @return \Illuminate\Contracts\Support\Renderable
     *
     */
    public function config() {

      return view('user.config');

    }

    /**
     * Updates current authenticated user record on database
     *
     * @author Darío Hernández
     * @param Request $request
     * @return void
     *
     */
    public function update(Request $request) {

      // Getting authenticated user
      $user = \Auth::user();
      $id = $user -> id;

      // Validating form data
      $validate = $this -> validate($request, [
        'name' => ['required', 'string', 'max:255'],
        'surname' => ['required', 'string', 'max:255'],
        'nick' => ['required', 'string', 'max:255', 'unique:users,nick,'.$id],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
      ]);

      // Getting form data
      $name = $request -> input('name');
      $surname = $request -> input('surname');
      $nick = $request -> input('nick');
      $email = $request -> input('email');

      $image_name_path = $request -> file('image_path');

      if($image_name_path) {


        // Setting a unique name to image
        $full_image_name_path = time().$image_name_path -> getClientOriginalName();
        // Saving image on Storage\app\users folder
        Storage::disk('users') -> put($full_image_name_path, File::get($image_name_path));
        // Setting image name to user object var
        $user -> image = $full_image_name_path;
      }

      // Assign new values to user object
      $user -> name = $name;
      $user -> surname = $surname;
      $user -> nick = $nick;
      $user -> email = $email;

      // Querying database
      $user -> update();

      return redirect() -> route('config') -> with(['message' => 'User updated succesfully']);

    }

    /**
     * Gets avatar image from Storage
     *
     * @author Darío Hernández
     * @param string $filename
     * @return Response $file
     *
     */
    public function getImage($filename) {

      $file = Storage::disk('users') -> get($filename);

      return new Response($file, 200);
    }

    public function profile($id) {

      $user = User::find($id);

      return view('user.profile', [
        'user' => $user]);

    }

}
