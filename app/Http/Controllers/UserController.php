<?php
namespace App\Http\Controllers;
use Auth;
use App\user;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests;
use Storage;
use File;
use Illuminate\Http\Response;
class UserController extends Controller
{
	public function getDashboard(){
		$posts = Post::orderBy('id','desc')->get();
		return view('dashboard')->withPosts($posts);
	}
	public function getAccount(){

		return view('account')->withUser(Auth::user());
	}
	public function postSaveAccount(Request $request){
		$this->validate($request,[
			'name' => 'required|max:255'
			]);
		$user = Auth::user();
		$user->name = $request->name;
		$user->update();
		$file = $request->file('image');
		$filename = $request->name . '-' . $user->id . '.jpg';
		if ($file) {
			Storage::disk('local')->put($filename , File::get($file));
		}
		return redirect()->route('account');
	}
	public function getUserImage($filename){
		$file = Storage::disk('local')->get($filename);
		return new Response($file, 200);
	}
}
