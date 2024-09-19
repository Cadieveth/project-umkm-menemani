<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Product;
use App\Models\ProductSell;
use App\Models\Resep;
use App\Models\Setting;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use App\Models\Supplier;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Dashboard";

        $setting = Setting::first();

        $modelrole = DB::table('model_has_roles')->where('model_id', auth()->user()->id)->first();
        $role = Role::where('id', $modelrole->role_id)->first();

        $currance = Transaksi::select(DB::raw('SUM(transaksis.sub_total) as total'))->first();
        $totalProduk = ProductSell::select(DB::raw('COUNT(id) as totalProduk'))->first();
        $totalBaku = BahanBaku::select(DB::raw('COUNT(id) as totalBaku'))->first();
        $masuk = StokMasuk::select(DB::raw('COUNT(id) as total'))->first();
        $keluar = StokKeluar::select(DB::raw('COUNT(id) as total'))->first();
        $resep = Resep::select(DB::raw('COUNT(id) as total'))->first();


        $supplier = Supplier::select(DB::raw('COUNT(id) as total'))->first();
        $stok = BahanBaku::with(['stokMasuk', 'stokKeluar'])->orderBy('created_at', 'desc')->paginate(3);
        $stokpro = ProductSell::orderBy('created_at', 'desc')->paginate(10);
        $stok_masuk = StokMasuk::with('baku', 'supplier')->orderBy('created_at', 'desc')->paginate(3);
        $stok_keluar = StokKeluar::with('baku')->orderBy('created_at', 'desc')->paginate(3);
        $transaksi = Transaksi::with(['user'])->orderBy('created_at', 'desc')
            ->select(
                'no_transaksi',
                'created_at',
                DB::raw('SUM(transaksis.sub_total) as total')
            )
            ->groupBy('no_transaksi', 'created_at')
            ->paginate(3);
        $usersTransaksi = Transaksi::with('user')->orderBy('no_transaksi')->first();

        if ($role->name == 'administrator') {
            return view('pages.dashboard.index', compact('setting', 'supplier', 'title', 'stok', 'stok_masuk', 'stok_keluar', 'transaksi', 'usersTransaksi', 'currance', 'totalBaku', 'totalProduk'));
        } elseif ($role->name == 'gudang') {
            return view('pages.dashboard.gudang', compact('setting', 'masuk', 'title', 'stok', 'stok_masuk', 'stok_keluar', 'keluar', 'totalBaku'));
        } else {
            return view('pages.dashboard.produksi', compact('setting', 'title', 'stokpro', 'resep', 'totalProduk'));
        }
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