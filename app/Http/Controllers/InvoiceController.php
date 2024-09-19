<?php

namespace App\Http\Controllers;

use App\Models\OrderStok;
use App\Models\Resep;
use App\Models\Setting;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function invoice_transaksi($no)
    {

        $transaksi = Transaksi::with('user')->where('no_transaksi', '=', $no)->first();
        $transaksis = Transaksi::with('produkSell')->where('no_transaksi', '=', $no)->get();
        $setting = Setting::first();


        $total = Transaksi::select(
            DB::raw('SUM(sub_total) as total_harga'),
        )->where('no_transaksi', $no)->first();
        return view('pages.invoice.transaksi', compact('setting', 'transaksi', 'transaksis', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function invoice_orderan($no)
    {
        $orders = OrderStok::where('no_order', '=', $no)->get();
        $order = OrderStok::where('no_order', '=', $no)->first();
        $total = OrderStok::select(
            DB::raw('SUM(qty) as qty'),
            DB::raw('SUM(sub_total) as total_harga'),
        )->where('no_order', $no)->first();
        return view('pages.invoice.orderan', compact('orders', 'order', 'total'));
    }

    public function invoice_resep($no)
    {
        $reseps = Resep::where('no_resep', '=', $no)->get();
        $resep = Resep::where('no_resep', '=', $no)->first();
        return view('pages.invoice.resep', compact('reseps', 'resep'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
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
