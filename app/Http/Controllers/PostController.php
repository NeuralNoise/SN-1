<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Post;
use App\User;
use Auth;
use App\Like;
use Session;
use App\Http\Requests;
class PostController extends Controller
{
	public function postCreatePost(Request $request){
		$this->validate($request,['new-post' => 'required|max:2000']);
		$post = new Post;
		$post->body =$request->input('new-post');
		Auth::user()->posts()->save($post);
		Session::flash('success','Post Successfully Created !');
		return redirect()->route('dashboard');
	}
	public function getDeletePost($post_id){
		$post = Post::find($post_id)->first();
		if (Auth::user() != $post->user) {
			return redirect()->route('dashboard');
		}
		$post->delete();
		Session::flash('success','Post Deleted Created !');
		return redirect()->route('dashboard');
	}
	public function postEditPost(Request $request){
		$this->validate($request , [
			'body' => 'required'
			]);
		$post = Post::find($request['postId']);
		$post->body = $request['body'];
		$post->update();
		return response()->json(['new_body' => $post->body], 200);
	}
	public function postLikePost(Request $request){
		$post_id = $request['postId'];
		$is_like = $request['isLike'] === 'true';
		$update = false;
		$post = Post::find($post_id);
		if (!$post){
			return null;
		}
		$user = Auth::user();
		$like = $user->likes()->where('post_id', $post_id)->first();
		if($like){
			$already_like = $like->like;
			$update = true;
			if($already_like == $is_like){
				$like->delete();
				return null;
			}
		}else{
			$like = new Like();
		}
		$like->like = $is_like;
		$like->user_id = $user->id;
		$like->post_id = $post->id;
		if($update){
			$like->update();
		}else{
			$like->save();
		}
		return null;
	}
}
