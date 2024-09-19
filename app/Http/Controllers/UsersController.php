<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        # code...
        $this->middleware(['permission:users-list|users-create|users-edit|users-delete']);
    }

    public function index()
    {
        $title = "Data Users";
        $judul = "Data Users";
        $setting = Setting::first();

        $users = User::get();
        $role = Role::get();
        return view('pages.users.index', compact('setting', 'title', 'judul', 'role', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'gender'  => 'required',
            'email'     => 'required|email|unique:users',
            'password'      => 'required|min:6',
        ];

        $messages = [
            'name.required'  => 'Nama Lengkap wajib diisi',
            'name.min'       => 'Nama Lengkap minimal 3 karakter',
            'gender.required'  => 'Jenis Kelamin wajib dipilih',
            'name.required'  => 'Nama Lengkap Wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique'      => 'Email Sudah Terdaftar, Coba Email yang Lain',
            'password.required'  => 'Password wajib diisi',
            'password.min'       => 'Password minimal 3 karakter',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role = Role::find($request->role);
        $user = User::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => ($role->name == 'gudang') ? 2 : (($role->name == 'produksi') ? 3 : 1),
        ]);

        $user->assignRole($role->name);
        return redirect()->route('users')
            ->with('success', 'Data Users Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'sometimes|nullable|min:6'
        ]);

        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->back()->with('success', 'Data User Berhasil diubah');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users')
            ->with('error', 'Data Users berhasil dihapus');
    }
}