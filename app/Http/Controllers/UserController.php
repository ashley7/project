<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Validator;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:user-list');
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['users'] = User::all();
        return view('users.index')->with($data);
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'surname' => ['required', 'string', 'max:255'],
            'othername' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:255', 'unique:users,phone_number'],
        ])->validate();
        $password = $this->generateRandomString(6);
        $user = User::create([
            'surname' => $request->surname,
            'othername' => $request->othername,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($password),
        ]);
        $user->assignRole($request->input('roles'));
        if ($user) {
            return back()->with('success', 'User has been added successfully');
        }
        return back()->with('success', 'Oops error has occurried try again');
    }

    public function edit($id)
    {
        $user = User::findOrfail($id);
        $data['roles'] = Role::pluck('name', 'name')->all();
        $data['userRole'] = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user'))->with($data);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'surname' => ['required', 'string', 'max:255'],
            'othername' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ])->validate();
        $user = User::findOrfail($id);
        $user->update([
            'surname' => $request->surname,
            'othername' => $request->othername,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
        ]);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));
        if ($user) {
            return redirect('users')->with('success', 'User has been updated successfully');
        }
        return back()->with('success', 'Oops error has occurried try again');
    }
    public function destroy($id)
    {
        $success = User::where('id', $id)->delete();
        if ($success) {
            return redirect('users')->with('success', 'record has been deleted successfully');
        }
        return back()->with('error', 'Oops error has occurried please try again');

    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
