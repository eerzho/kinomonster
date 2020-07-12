<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');

    }

    public function index()
    {
//        $postList = DB::select('select id,slug,title,year,producer,image_name, is_published from posts');
        $userList = User::where('role', false)->paginate(10);
        return view('admin.user', compact('userList'));
    }
    public function destroy($id)
    {
        $result = User::destroy($id);
        DB::delete('delete from comments where user_id = ?', [$id]);
        if($result) {
            return redirect()
                ->route('admin.user')
                ->with(['success' => 'Пользователь удален']);
        }
        else {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }
    }
}
