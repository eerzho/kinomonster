<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Request $request, $post_id)
    {
        $rules = [
            'comment' => 'max:500'
        ];
        $this->validate($request, $rules);
        $request['user_id'] = Auth::user()->id;
        $request['post_id'] = $post_id;

        $data = $request->all();
        $item =  (new Comment())->create($data);
        $array = DB::select('select slug from posts where id = ?', [$post_id]);
        $slug = $array[0]->slug;
        if($item) {
            return redirect()
                ->route('home.show', [$slug])
                ->with(['success' => 'Успешно сохранено']);
        }
        else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }
    public function deleteComment($comment_id)
    {
        if(Auth::user()->role) {
            $result = Comment::destroy($comment_id);
            if($result) {
                return back()
                    ->with(['success' => 'Комментарий удален']);
            }
            else {
                return back()->withErrors(['msg' => 'Ошибка удаления']);
            }
        }
        else {
            return back()->withErrors(['msg' => 'У вас нет доступа']);
        }
    }
}
