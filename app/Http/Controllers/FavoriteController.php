<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function add(Request $request, $post_id)
    {
    	$count = DB::select('select post_id from favorites where post_id = ?', [$post_id]);
//    	dd($count);
    	if (!empty($count)) {
		    return back()
			    ->withErrors(['msg' => 'Вы уже добавили'])
			    ->withInput();
	    }
    	$request['post_id'] = $post_id;
        $request['user_id'] = Auth::user()->id;
        $data = $request->all();
        $item = (new Favorite())->create($data);
        if($item) {
            return back()
                ->with(['success' => 'Успешно добавлено в избранные']);
        }
        else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }
    public function show()
    {
//        $favorites = DB::select('select * from favorites where user_id = ?', [Auth::user()->id]);
//        foreach ($favorites as $favorite) {
//            $list = Post::all()->where('id', $favorite->post_id);
//        }
        $list = [];
        $favorites = DB::select('select * from favorites where user_id = ?', [Auth::user()->id]);
        foreach ($favorites as $favorite) {
            $post = Post::where('id', $favorite->post_id)->first();
            $list[]= [
                'image_name' => $post['image_name'],
                'title' => $post['title'],
                'content_raw' => $post['content_raw'],
                'id' => $post['id'],
                'slug' => $post['slug'],
            ];
        }
        return view('list', compact('list'));
    }
    public function delete($post_id)
    {
        $result = DB::delete('delete from favorites where post_id = ?', [$post_id]);
        if($result) {
            return back()
                ->with(['success' => 'Успешно']);
        }
        else {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }
    }
}
