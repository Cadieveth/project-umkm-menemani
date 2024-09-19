<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Setting";
        $judul = "Setting";
        $setting = Setting::first();

        $settings = Setting::get();
        return view('pages.setting.index', compact('setting', 'settings', 'title', 'judul'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {



        $user = Setting::findOrFail($request->id);
        $user->name = $request->name;
        $user->company_name = $request->company_name;
        $user->alamat = $request->alamat;
        $user->pimpinan = $request->pimpinan;
        if ($request->image) {
            $namefile = str_replace(' ', '_', $request->image->getClientOriginalName());
            $filename  = $namefile . '_' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $filename);

            $user->image = $filename;
        }

        $user->save();

        return redirect()->back()->with('success', 'Data Setting Berhasil diubah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Setting::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}