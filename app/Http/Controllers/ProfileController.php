<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $gender = User::get('gender');
        $setting = Setting::first();

        $title = "Profile - " . $user->name;
        return view('pages.users.profile', compact('setting', 'gender', 'user', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function update_profile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $namefile = str_replace(' ', '_', $request->profile->getClientOriginalName());
        $filename  = $namefile . '_' . time() . '.' . $request->profile->extension();
        $request->profile->move(public_path('uploads'), $filename);

        $user->profile = $filename;

        $user->save();
        return redirect()->back()->with('success', 'Upload Photo Berhasil');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();
        return redirect()->back()->with('success', 'Profile Berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}