<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;
class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');

    }

    public function index()
    {
//        $postList = DB::select('select id,slug,title,year,producer,image_name, is_published from posts');
        $postList = Post::orderBy('created_at','desc')->paginate(5);
        return view('admin.index', compact('postList'));
    }

    public function create()
    {
        $item = new Post();
        $categoryList = DB::select('select title,id from categories');
        return view('admin.create', compact('item','categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $data
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:150',
            'producer' => 'required|max:150',
            'year' => 'required:integer',
            'category_id' => 'required|integer|exists:categories,id',
            'content_raw' => 'min:10|max:1000',
        ];

        $this->validate($request, $rules);
        $proverka = Post::where('slug', \Str::slug($request->title))->first();

        if (!empty($proverka)) {
            return back()
                ->withErrors(['msg' => 'Это имя занято'])
                ->withInput();
        }

        if(!$request->file('image')){
            return back()
                ->withErrors(['msg' => 'Выберите картинку'])
                ->withInput();
        }

        if($request['is_published']){
            $request['published_at'] = Carbon::now();
        }

        $request['slug']= \Str::slug($request->title);
        $request['user_id'] = Auth::user()->id;

        $extension = '.'.$request->file('image')->extension();
        $image_name = time().$request['slug'].$request['year'].\Str::slug($request->producer).$request['user_id'].$extension;
        $request->file('image')->storeAs('public', $image_name);
        $request['image_name'] = $image_name;

        $data = $request->all();
        $item =  (new Post())->create($data);

        if($item) {
            return redirect()
                ->route('admin.edit', [$item->slug])
                ->with(['success' => 'Успешно сохранено']);
        }
        else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $postList = Post::withTrashed()->where('user_id', $id)->paginate(5);
        return view('admin.index', compact('postList'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  mixed  $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($slug)
    {
        $item = Post::withTrashed()->where('slug', $slug)->first();
        $categoryList = DB::select('select title,id from categories');
//        $user = DB::select('select name from users where id = ?', [$item->user_id]);
//        dd($item);
        $user = DB::table('users')->where('id', $item->user_id)->first();
        return view('admin.edit', compact('item', 'categoryList', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $slug)
    {
        $rules = [
            'title' => 'required|max:150',
            'producer' => 'required|max:150',
            'year' => 'required:integer',
            'category_id' => 'required|integer|exists:categories,id',
            'content_raw' => 'min:10|max:1000',
        ];
        $this->validate($request, $rules);

        $proverka = Post::where('slug', \Str::slug($request->title))->first();
        if (!empty($proverka) && $slug != $proverka['slug']) {
            return back()
                ->withErrors(['msg' => 'Это имя занято'])
                ->withInput();
        }

        if($request->file('image')){
            $extension = '.'.$request->file('image')->extension();
            $image_name = time().$request['slug'].$request['year'].\Str::slug($request->producer).$request['user_id'].$extension;
            $request->file('image')->storeAs('public', $image_name);
            $request['image_name'] = $image_name;
        }

        $item = Post::where('slug', $slug)->first();
        if(empty($item)){
            return back()
                ->withErrors(['msg'=>"Запись не найдена"])
                ->withInput();
        }

        if($request['is_published']){
            $request['published_at'] = Carbon::now();
        }

        $request['slug'] = \Str::slug($request->title);
        $data = $request->all();
        $result = $item->update($data);

        if($result) {
            return redirect()
                ->route('admin.edit', $request['slug'])
                ->with(['success' => 'Успешно изменено']);
        }
        else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $result = Post::destroy($id);
        DB::delete('delete from comments where post_id = ?', [$id]);
        if($result) {
            return redirect()
                ->route('admin.index')
                ->with(['success' => 'Отмена', 'id' => $id]);
        }
        else {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }
    }
    public function restore($id) {
        $result = Post::withTrashed()
            ->where('id', $id)
            ->restore();
        DB::update('update posts set is_published = false where id = ?', [$id]);
        if($result) {
            return redirect()
                ->route('admin.index')
                ->with(['success' => "Запись id[$id] восстановлена"]);
        }
        else {
            return back()->withErrors(['msg' => 'Не возможно восстановить']);
        }
    }
    public function trash() {
        $postList = Post::onlyTrashed()->paginate(5);
        return view('admin.index', compact('postList'));
    }
}
