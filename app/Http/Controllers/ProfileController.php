<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('profile');
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::find($id);

        if($request['new_password'] != $request['new_confirm_password']) {
            return back()->withErrors(['msg' => 'Пароли не совпадают']);
        }

        $request['password'] = $request['new_password'];

        $rules = [
            'password' => ['required', 'string', 'min:8'],
        ];

        $this->validate($request, $rules);

        $request['password'] = Hash::make($request['new_password']);

        $data = $request->all();
        $result = $user->update($data);

        if($result) {
            return redirect()
                ->route('profile.index')
                ->with(['success' => 'Пароль успешно изменен']);
        }
        else{
            return back()
                ->withErrors(['msg' => 'Ошибка изменения']);
        }
    }
    public function updateName(Request $request, $id)
    {
        $user = User::find($id);

        if($user['name'] == $request['new_name']){
            return back()
                ->withErrors(['msg' => 'Это имя уже используется'])
                ->withInput();
        }

        $check = User::withTrashed()->where('name', $request['new_name'])->first();
        if (!empty($check)) {
            return back()
                ->withErrors(['msg' => 'Это имя занято']);
        }

        $request['name'] = $request['new_name'];

        $rules = [
            'name' => ['required', 'string', 'max:255'],
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $result = $user->update($data);

        if($result) {
            return redirect()
                ->route('profile.index')
                ->with(['success' => 'Имя изменено']);
        }
        else {
            return back()
                ->withErrors(['msg' => 'Ошибка изменения'])
                ->withInput();
        }
    }
    public function destroy($id)
    {
        $result = User::destroy($id);
        if($result) {
            return redirect()
                ->route('login')
                ->with(['success' => 'Пользователь удален']);
        }
        else {
            return back()->withErrors(['msg' => 'Ошибка удаления']);
        }
    }
}
