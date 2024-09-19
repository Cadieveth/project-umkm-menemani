<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Supplier - Data Supplier";
        $judul = "Data Supplier";
        $setting = Setting::first();

        $suppliers = Supplier::get();
        return view('pages.supplier.index', compact('setting', 'title', 'judul', 'suppliers'));
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
        $rules = [
            'name' => 'required|min:3',
            'alamat'  => 'required',
            'email'     => 'required',
            'kontak'      => 'required',
        ];

        $messages = [
            'name.required'  => 'Nama Lengkap wajib diisi',
            'name.min'       => 'Nama Lengkap minimal 3 karakter',
            'alamat.required'  => 'Alamat wajib diisi',
            'email.required' => 'Email wajib diisi',
            'kontak.required'  => 'Kontak wajib diisi',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Supplier::create([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'kontak' => $request->kontak,

        ]);

        return redirect()->route('supplier')
            ->with('success', 'Supplier Berhasil ditambahkan');
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
        $supplier = Supplier::findOrFail($id);
        return response()->json($supplier);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'alamat' => 'required',
            'email' => 'required|email',
            'kontak' => 'required',
        ]);

        $supplier = Supplier::findOrFail($request->id);
        $supplier->name = $request->name;
        $supplier->alamat = $request->alamat;
        $supplier->email = $request->email;
        $supplier->kontak = $request->kontak;

        $supplier->save();

        return redirect()->back()->with('success', 'Data Supplier Berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Supplier::find($id)->delete();
        return redirect()->route('supplier')
            ->with('error', 'Data Supplier berhasil dihapus');
    }
}