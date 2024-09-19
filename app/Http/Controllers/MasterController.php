<?php

namespace App\Http\Controllers;

use App\Models\Master;
use App\Models\Setting;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index()
    {
        $title = "Master - Master Akun";
        $judul = "Data Akun";
        $setting = Setting::first();

        $masters = Master::get();
        return view('pages.setting.master', compact('setting', 'title', 'judul', 'masters'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        Master::create([
            'name' => $request->name,
            'kategori' => $request->kategori,
        ]);

        return redirect()->route('master')->with('success', 'Data Master Akun berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $master = Master::findOrFail($id);
        return response()->json($master);
    }

    public function update(Request $request)
    {
        $master = Master::findOrFail($request->id);
        $master->name = $request->name;
        $master->kategori = $request->kategori;
        $master->save();

        return redirect()->back()->with('success', 'Data Master Berhasil diubah');
    }

    public function destroy(string $id)
    {
        Master::find($id)->delete();
        return redirect()->back()->with('error', 'Data Berhasil dihapus');
    }
}
