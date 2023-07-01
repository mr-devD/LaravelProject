<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Usertype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {

        $users = User::all();
        return view('users', compact('users'));
    }

    public function getUser($id = null)
    {
        if ($id === null) {
            $id = Auth::id();
        }
        $user = User::find($id);

        if ($user === null) {
            abort(404, 'USER NOT FOUND');
        }
        $types = Usertype::all();
        return view('user', compact('user', 'types'));
    }

    public function getTypes()
    {
        $types = Usertype::all();
        return view('user-types', compact('types'));
    }

    public function addType(Request $request)
    {
        $request->validate([
            'name' => ['required', Rule::unique('usertypes')->ignore($request->name)],
            'priority' => ['required', 'numeric', 'min:1', 'max:9']
        ]);

        Usertype::create([
            'name' => $request->name,
            'priority' => $request->priority
        ]);

        return back();
    }

    public function delete_type(Request $request)
    {
        $type = Usertype::find($request->id);

        $type->delete();

        return back();
    }

    public function edit(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'username' => ['required', Rule::unique('users')->ignore($request->id)],
            'email' => ['email', 'required', Rule::unique('users')->ignore($request->id)],
            'phone' => [Rule::unique('users')->ignore($request->id)],
        ]);


        $user = User::find($request->id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->type_id = $request->type;
        $user->phone = $request->phone;
        $user->birthdate = $request->birthdate;

        $user->save();

        return back();
    }
}
