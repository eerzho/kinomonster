<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $filmList = Post::orderBy('created_at','desc')
            ->where('category_id', 1)
            ->where('deleted_at', null)
            ->where('is_published', true)
            ->paginate(4);
        $serialList = Post::orderBy('created_at','desc')
            ->where('category_id', 2)
            ->where('is_published', true)
            ->where('deleted_at', null)
            ->paginate(4);
        return view('index', compact('filmList', 'serialList')) ;
    }
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();
        $commentList = Comment::orderBy('created_at','desc')->where('post_id', $post->id)->paginate(5);
        foreach ($commentList as $comment) {
            $array = DB::select('select name from users where id = ?', [$comment['user_id']]);
            $comment['user_name'] = $array[0]->name;
        }
        return view('show', compact('post', 'commentList'));
    }
    public function list($id)
    {
        $category = Category::where('id', $id)->first();
        $list = Post::all()->where('category_id', $id);
//        dd($list);
        return view('list', compact('list', 'category'));
    }
    public function search(Request $request)
    {
        $post = Post::where('title', $request['title'])->first();
        if($post == null) {
            return back()
                ->withErrors(['msg' => 'Ничего не найдено'])
                ->withInput();
        }
        return redirect()->route('home.show', [$post['slug']]);
    }
//    public function profile()
//    {
//        if (Auth::user()->role == true) {
//            return view('home');
//        }
//        else {
//            return view('main');
//        }
//    }

}
