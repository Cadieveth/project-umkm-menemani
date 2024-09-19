<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Master;
use App\Models\Product;
use App\Models\ProductSell;
use App\Models\Setting;
use App\Models\StokKeluar;
use App\Models\Transaksi;
use App\Models\KasKeluar;
use App\Models\Margin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    //TRANSAKSI
    public function index()
    {
        $title = "Transaksi";
        $judul = "Transaksi";
        $setting = Setting::first();
        $margin = Margin::all();
        $dataMargin = Margin::first();

        $produks = ProductSell::orderBy('created_at', 'asc')->get();

        $subQuery = Transaksi::select('no_transaksi', DB::raw('MAX(created_at) as latest_created_at'))
            ->groupBy('no_transaksi');

        $transaksis = Transaksi::with(['produkSell'])
            ->joinSub($subQuery, 'latest_transaksis', function ($join) {
                $join->on('transaksis.no_transaksi', '=', 'latest_transaksis.no_transaksi');
            })
            ->orderBy('transaksis.created_at', 'desc')
            ->select(
                'transaksis.no_transaksi',
                'latest_transaksis.latest_created_at as tgl_transaksi',
                DB::raw('SUM(transaksis.sub_total) as total')
            )
            ->groupBy('transaksis.no_transaksi',  'latest_transaksis.latest_created_at')
            ->get();

        return view('pages.transaksi.index', compact('setting', 'title', 'judul', 'produks', 'transaksis', 'margin', 'dataMargin'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $date = Carbon::now()->format('mY');
        $dataMargin = Margin::first(); // Ambil data margin
        $nama_barang = $request->nama_barang;
        $qty = $request->qty;
        $no_transaksi = "TRS" . $date . rand(100000, 999999);
        $no_jurnal = "JU" . rand(001, 999);
        $harga = $request->harga;
        $sub_total = $request->subtotal;
        $totalSub = 0;
        $total = 0;
        $totalHpp = 0;

        // dd($dataMargin->margin);

        for ($i = 0; $i < count($nama_barang); $i++) {
            $produk = ProductSell::where('id', $nama_barang[$i])->first();
            if ($produk) {
                $hpp = $produk->hpp;

                // Hitung harga dengan margin
                if ($dataMargin) {
                    // Periksa jika margin tidak null
                    if ($dataMargin->margin !== null) {
                        $marginPercentage = $dataMargin->margin / 100;
                        $hargaDenganMargin = ($marginPercentage * $hpp) + $hpp;
                    } else {
                        $hargaDenganMargin = $hpp; // Tidak ada margin
                    }
                } else {
                    $hargaDenganMargin = $hpp; // Tidak ada data margin
                }

                // Hitung subtotal dengan harga yang sudah diperbarui
                $subtotal = $hargaDenganMargin * $qty[$i];

                // Simpan transaksi
                $transaksi = Transaksi::create([
                    'user_id' => Auth::user()->id,
                    'produk_sell_id' => $nama_barang[$i],
                    'no_transaksi' => $no_transaksi,
                    'harga_barang' => $hargaDenganMargin,
                    'qty' => $qty[$i],
                    'sub_total' => $subtotal,
                ]);

                // Update stok produk
                $produk->qty_out += $qty[$i];
                $produk->save();

                $total += $subtotal; // Total transaksi

                $totalHpp += $hpp * $qty[$i];
            }
        }

        $hpp = $produk->hpp;

        // new
        // $nilaiMargin = ($dataMargin->margin / 100) * $produk->hpp;
        // $hpp = $produk->hpp + $nilaiMargin;

        Laporan::create([
            'no_jurnal' => $no_jurnal,
            'ket' => $no_transaksi,
            'akun_debet' => 'Kas',
            'debit' => $total,
            'akun_hpp' => 'HPP',
            'hpp' => $totalHpp,
            'akun_kredit' => 'Penjualan',
            'kredit' => $total,
            'akun_persediaan' => 'Persediaan Barang Jadi',
            'persediaan' => $totalHpp,
        ]);


        return redirect()->route('invoice.transaksi', $transaksi->no_transaksi)
            ->with('success', 'Transaksi Berhasil');
    }

    public function destroy(string $no_transaksi)
    {
        $transaksis = Transaksi::where('no_transaksi', $no_transaksi)->get();

        foreach ($transaksis as $transaksi) {
            $produk_sell_id = $transaksi->produk_sell_id;
            $qty = $transaksi->qty;

            // Update ProductSell untuk mengembalikan qty_in dan qty_out
            $productSell = ProductSell::where('id', $produk_sell_id)->first();
            if ($productSell) {
                $productSell->qty_out -= $qty;

                // Pastikan nilai qty_out tidak negatif
                if ($productSell->qty_out < 0) {
                    $productSell->qty_out = 0;
                }
                $productSell->save();
            }
        }

        Transaksi::where('no_transaksi', $no_transaksi)->delete();
        return redirect()->back()->with('error', 'Data Transaksi Berhasil dihapus');
    }

    //MARGIN
    public function store_Margin(Request $request)
    {
        $request->validate([
            'margin' => 'required|numeric|min:0',
        ]);

        $existingMargin = Margin::count();
        if ($existingMargin >= 1) {
            return redirect()->route('transaksi')->with('error', 'Data margin sudah tersedia');
        }

        Margin::create([
            'margin' => $request->margin,
        ]);

        return redirect()->route('transaksi')->with('success', 'Berhasil menambahkan data margin');
    }

    public function update_Margin(Request $request, $id)
    {
        $request->validate([
            'margin' => 'required|numeric|min:0',
        ]);

        $margin = Margin::findOrFail($id);
        $margin->update([
            'margin' => $request->margin,
        ]);

        return redirect()->route('transaksi')->with('success', 'Berhasil update data margin');
    }

    //KAS KELUAR
    public function kas_keluar()
    {
        $title = "Transaksi - Kas Keluar";
        $judul = "Kas Keluar";
        $setting = Setting::first();
        $masters = Master::get();
        $masterName = $masters->pluck('name')->toArray();

        // Mengambil data dari model Laporan
        $kass = Laporan::whereIn('akun_debet', $masterName)
            ->where('akun_debet', '!=', 'Kas') // Memfilter agar tidak mengambil entri dengan akun "Kas" di debit
            ->select('akun_debet as akun', 'debit as nominal', 'no_jurnal', 'ket as keterangan', 'created_at', 'id')
            ->get();

        // Mengambil data dari model KasKeluar
        $cashOut = KasKeluar::select('akun', 'nominal', 'created_at', 'keterangan', 'id')->get();

        // Menggabungkan data dari Laporan dan KasKeluar
        $allCashOut = $kass->merge($cashOut)->sortBy('created_at');

        return view('pages.transaksi.kas_keluar', compact('setting', 'title', 'judul', 'allCashOut', 'cashOut', 'masters'));
    }

    public function store_kas(Request $request)
    {
        $no_jurnal = "JU" . rand(001, 999);

        Laporan::create([
            'no_jurnal' => $no_jurnal,
            'ket' => $request->ket,
            'akun_debet' => $request->akun,
            'debit' => $request->nominal,
            'akun_kredit' => 'Kas',
            'kredit' => $request->nominal,
        ]);

        return redirect()->route('kas')
            ->with('success', 'Pencatatan Kas Keluar Berhasil');
    }

    public function edit_kas($id)
    {
        $kas = Laporan::findOrFail($id);
        return response()->json($kas);
    }

    public function update_kas(Request $request)
    {
        $kas = Laporan::findOrFail($request->id);
        $kas->akun_debet = $request->akun;
        $kas->debit = $request->nominal;
        $kas->ket = $request->ket;

        $kas->save();

        return redirect()->back()->with('success', 'Data Kas Keluar Berhasil diubah');
    }

    public function destroy_kas($id)
    {
        Laporan::findOrFail($id)->delete();
        return redirect()->back()->with('error', 'Data Kas Keluar Berhasil dihapus');
    }
}
