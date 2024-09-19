<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Laporan;
use App\Models\Product;
use App\Models\ProductSell;
use App\Models\Resep;
use App\Models\Setting;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use App\Models\KasKeluar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProduksiController extends Controller
{
    // RESEP
    public function index()
    {
        $title = "Produksi - Data Resep";
        $judul = "Data Resep";
        $setting = Setting::first();

        $resep = Resep::first();
        $reseps = Resep::with(['baku'])
            ->select(
                'no_resep',
                'nama_resep',
                'keterangan',
            )->orderBy('created_at', 'desc')
            ->groupBy('no_resep', 'nama_resep', 'keterangan')
            ->get();
        $getBarangs = BahanBaku::get();
        // $getBarangs = Product::with('stokMasuk', 'stokKeluar')->get();
        // $produks = $getBarangs->unique('nama_barang');
        $produks = $getBarangs->unique('name');
        // dd($produks);
        return view('pages.produksi.index', compact('setting', 'title', 'judul', 'reseps', 'produks', 'resep'));
    }

    public function store(Request $request)
    {

        $date = Carbon::now()->format('mY');
        $nama_resep = $request->nama_resep;
        $keterangan = $request->keterangan;
        $nama_barang = $request->nama_barang;
        $qty = $request->qty;
        $instruksi = $request->instruksi;
        $no_resep = "RES" . $date . rand(100000, 999999);

        for ($i = 0; $i < count($nama_barang); $i++) {
            // $baku = BahanBaku::where('id', $nama_barang[$i])->first();

            Resep::create([
                'no_resep' => $no_resep,
                'baku_id' => $nama_barang[$i],
                'qty' => $qty[$i],
                'nama_resep' => $nama_resep,
                'keterangan' => $keterangan,
                'instruksi' => $instruksi,
            ]);
        }

        return redirect()->route('resep')
            ->with('success', 'Resep Berhasil Berhasil ditambahkan');
    }

    public function show(string $no)
    {

        $title = "Produksi - Details Resep";
        $judul = "Details Resep";
        $setting = Setting::first();

        $reseps = Resep::where('no_resep', '=', $no)->get();
        $resep = Resep::where('no_resep', '=', $no)->first();
        return view('pages.produksi.resep_details', compact('setting', 'title', 'judul', 'resep', 'reseps'));
    }

    // PERSEDIAAN BY RESEP
    public function persediaan()
    {
        $title = "Produksi - Persediaan Produksi";
        $judul = "Persediaan Produksi";
        $setting = Setting::first();

        $products = ProductSell::orderBy('created_at', 'desc')->get();
        // $product = ProductSell::with(['stokMasuk', 'stokKeluar'])->first();
        return view('pages.produksi.persediaan', compact('setting', 'title', 'judul', 'products'));
    }

    public function produksi_store(Request $request, string $no)
    {
        $noResep = $no;
        $reseps = Resep::with('baku')->where('no_resep', '=', $noResep)->get();
        $totalHargaBaku = 0;
        $namaProduk = $request->nama_produk;
        $qtyIn = $request->qty_in;
        $btk = $request->biaya_pekerja;
        $ovh = $request->biaya_overhead;
        $avgProduksi = 20;

        // Mengambil semua produk terkait resep dan menghitung harga rata-rata
        $produkIds = $reseps->pluck('baku_id')->unique();
        // $produkHargaRataRata = BahanBaku::whereIn('id', $produkIds)->get()->groupBy('name')->map(function ($group) {
        //     return $group->avg('harga');
        // });
        $produkHargaRataRata = $this->getProdukHargaRataRata($produkIds);

        foreach ($reseps as $resep) {
            if ($resep->baku) {
                $baku_id = $resep->baku_id;
                $qty = $resep->qty;
                $hargaBaku = $produkHargaRataRata[$resep->baku->name];
                $hargaProduksi = $qty * $hargaBaku;
                $totalHargaBaku += $hargaProduksi;

                $totalStokMasuk = StokMasuk::where('baku_id', $baku_id)->sum('stok_masuk');
                $totalStokKeluar = StokKeluar::where('baku_id', $baku_id)->sum('stok_keluar');
                $stokTersedia = $totalStokMasuk - $totalStokKeluar;

                if ($qty * $qtyIn > $stokTersedia) {
                    return redirect()->back()->with('error', 'Stok tidak mencukupi untuk bahan baku ' . $resep->baku->name);
                }
            }
        }

        $biayaTenagaKerjaAll = ($qtyIn / $avgProduksi) * $btk;
        $biayaTenagaKerja = $biayaTenagaKerjaAll / $qtyIn;
        $biayaOverheadAll = $ovh;
        $biayaOverhead = $ovh / $qtyIn;

        if($ovh === 0) {
            $hpp = $totalHargaBaku + $biayaTenagaKerja;
        } else {
            $hpp = $totalHargaBaku + $biayaTenagaKerja + $biayaOverhead;
        }

        // Hitung nilai $n
        $tanggalSekarang = Carbon::now()->toDateString();
        $existingLaporan = Laporan::whereDate('created_at', $tanggalSekarang)
            ->where('akun_debet', 'Biaya Tenaga Kerja Langsung') // Menargetkan entri yang relevan
            ->get();

        $n = $existingLaporan->count() + 1; // $n = 1 untuk entri pertama

        // Jika ada entri sebelumnya, update entri-entri tersebut
        if ($existingLaporan->count() > 0) {
            foreach ($existingLaporan as $laporan) {
                // Update entri sebelumnya dengan nilai $n yang baru
                $laporan->update([
                    'debit' => $laporan->debit * ($n - 1) / $n,
                    'kredit' => $laporan->kredit * ($n - 1) / $n,
                ]);
            }
        }

        // Membuat jurnal no_jurnal
        $no_jurnal = "JU" . rand(001, 999);

        // Mengambil nama bahan baku untuk entri 1
        $namaBahanBaku = $reseps->map(function ($resep) {
            return $resep->baku->name;
        })->implode(', ');

        foreach ($reseps as $resep) {
            StokKeluar::create([
                'baku_id' => $resep->baku_id,
                'stok_keluar' => $resep->qty * $qtyIn,
                'no_dokumen' => $resep->no_resep,
                'keterangan' => 'Bahan Baku Produksi Resep',
            ]);
        }

        $kdProduct = "SLL" . rand(1000, 9999) . date('dm');
        ProductSell::create([
            'no_resep' => $resep->no_resep,
            'kode_product' => $kdProduct,
            'nama_product' => $namaProduk,
            'hpp' => $hpp, // salah
            'overhead' => $biayaOverheadAll,
            'bb_keluar' => $totalHargaBaku * $qtyIn,
            'qty_in' => $qtyIn,
            'qty_out' => 0,
        ]);

        // Entri 1: Persediaan Barang Jadi vs Persediaan Bahan Baku
        Laporan::create([
            'no_jurnal' => $no_jurnal,
            'ket' => "Produksi $namaProduk ($kdProduct)",
            'akun_debet' => "Persediaan Barang Jadi ($namaBahanBaku)",
            'debit' => ($totalHargaBaku * $qtyIn) + $biayaOverheadAll,
            'akun_kredit' => 'Persediaan Bahan Baku',
            'kredit' => ($totalHargaBaku * $qtyIn) + $biayaOverheadAll,
            'created_at' => Carbon::now(),
        ]);

        // Entri 2: Biaya Tenaga Kerja Langsung vs Hutang Gaji
        Laporan::create([
            'no_jurnal' => $no_jurnal,
            'ket' => "Produksi $namaProduk ($kdProduct)",
            'akun_debet' => "Persediaan Barang Jadi ($namaBahanBaku)",
            'debit' => $biayaTenagaKerjaAll,
            'akun_kredit' => 'Hutang Gaji',
            'kredit' => $biayaTenagaKerjaAll,
            'created_at' => Carbon::now(),
        ]);

        // // Mengecek jika entri ketiga belum ada pada hari ini
        // $existingEntriKetiga = Laporan::whereDate('created_at', $tanggalSekarang)
        // ->where('akun_debet', 'Hutang Gaji')
        // ->where('akun_kredit', 'Kas')
        // ->first();

        // // Entri 3: Hutang Gaji vs Kas
        // if (!$existingEntriKetiga) {
        //     Laporan::create([
        //         'no_jurnal' => $no_jurnal,
        //         'ket' => "Pembayaran Gaji $tanggalSekarang",
        //         'akun_debet' => 'Hutang Gaji',
        //         'debit' => $biayaTenagaKerja,
        //         'akun_kredit' => 'Kas',
        //         'kredit' => $biayaTenagaKerja,
        //         'created_at' => Carbon::now(),
        //     ]);
        // }

        // $entriKasKeluar = KasKeluar::whereDate('created_at', $tanggalSekarang)
        // ->first();

        // if (!$entriKasKeluar) {
        //     KasKeluar::create([
        //         'created_at' => Carbon::now(),
        //         'akun' => 'Hutang Gaji',
        //         'nominal' => $biayaTenagaKerja,
        //         'keterangan' => "Pembayaran Gaji $tanggalSekarang",
        //     ]);
        // }

        return redirect()->route('persediaan')->with('success', 'Produksi Berhasil Ditambahkan');
    }

    // AVERAGE BAHAN BAKU
    public function getProdukHargaRataRata($produkIds)
    {
        // Ambil semua bahan baku berdasarkan produkIds
        $produk = BahanBaku::whereIn('id', $produkIds)->get();

        // Membuat array kosong untuk menyimpan harga rata-rata per nama
        $produkHargaRataRata = [];

        foreach ($produk as $item) {
            $name = $item->name;

            // Jika nama belum ada di array, ambil semua bahan baku dengan nama tersebut dan hitung rata-rata harga
            if (!isset($produkHargaRataRata[$name])) {
                $hargaRataRata = BahanBaku::where('name', $name)->avg('harga');
                $produkHargaRataRata[$name] = $hargaRataRata;
            }
        }

        return $produkHargaRataRata;
    }

    public function edit($id)
    {
        $product = ProductSell::findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request)
    {

        $produk = ProductSell::findOrFail($request->id);
        $produk->nama_product = $request->nama_produk;
        $produk->qty_in = $request->qty;
        $produk->save();

        return redirect()->back()->with('success', 'Update Stok Berhasil');
    }

    public function destroy(string $no_resep)
    {

        $reseps = Resep::where('no_resep', $no_resep)->get();

        foreach ($reseps as $resep) {
            if ($resep->produk) {
                $produk_id = $resep->produk_id;
                $qty = $resep->qty;

                // Kurangi stok pada tabel StokKeluar
                $stokKeluar = StokKeluar::where('produk_id', $produk_id)
                    ->where('no_dokumen', $resep->no_resep)
                    ->first();
                if ($stokKeluar) {
                    $stokKeluar->stok_keluar -= $qty;
                    if ($stokKeluar->stok_keluar <= 0) {
                        $stokKeluar->delete();
                    } else {
                        $stokKeluar->save();
                    }
                }
            }
        }

        ProductSell::where('no_resep', $no_resep)->delete();
        // Hapus resep
        Resep::where('no_resep', $no_resep)->delete();

        return redirect()->back()->with('error', 'Data Resep Berhasil dihapus');
    }
}
