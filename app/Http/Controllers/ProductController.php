<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Laporan;
use App\Models\Product;
use App\Models\Setting;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $title = "Product - Stok Barang";
        $judul = "Stok Barang";
        $setting = Setting::first();

        $getProduk = BahanBaku::with(['stokMasuk', 'stokKeluar'])->orderBy('created_at', 'asc')->get();
        $produks = $getProduk->groupBy('name')->map(function ($group) {
            $averagePrice = $group->avg('harga');
            $group[0]->harga = $averagePrice;
            return $group[0];
        });

        // Mengubah hasil menjadi koleksi
        $products = collect($produks->values());
        return view('pages.product.index', compact('setting', 'title', 'judul', 'products'));
    }

    // bahan baku masuk
    public function masuk()
    {
        $stok_masuk = StokMasuk::with('baku', 'supplier')->orderBy('created_at', 'asc')->get();
        $suppliers = Supplier::get();
        $produks = BahanBaku::get();
        $baku = BahanBaku::get();
        $produks = $baku->groupBy('name')->map(function ($group) {
            return $group[0];
        });
        // Mengubah hasil menjadi koleksi
        $bakus = collect($produks->values());
        $setting = Setting::first();

        $title = "Product - Barang Masuk";
        $judul = "Barang Masuk";
        return view('pages.product.masuk', compact('setting', 'title', 'judul', 'stok_masuk', 'suppliers', 'produks', 'bakus'));
    }

    public function masuk_store(Request $request)
    {
        $rules = [
            'supplier' => 'required',
            'invoice' => 'required',
            'jml_masuk'     => 'required',
            'harga'      => 'required',
            'keterangan'      => 'required',
        ];

        $messages = [
            'supplier.required'  => 'Supplier wajib dipilih',
            'invoice.required'  => 'Nomor Invoice Wajib diisi',
            'jml_masuk.required' => 'Quantity Barang wajib diisi',
            'keterangan.required'  => 'Keterangan wajib diisi',
            'harga.required'  => 'Harga wajib diisi',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $baku = BahanBaku::where('id', $request->nama_barang)->first();

        if ($baku->harga == null) {
            $harga = $baku->satuan === "Gram" ? $request->harga / 1000 : $request->harga;
            $baku->harga = $harga;
            $baku->save();
        } else {
            $kdBarang = "PRD" . $baku->satuan . rand(1000, 9999) . date('dm');
            $harga = $baku->satuan === "Gram" ? $request->harga / 1000 : $request->harga;
            BahanBaku::create([
                'kode_barang' => $kdBarang,
                'name' => $baku->name,
                'satuan' => $baku->satuan,
                'harga' => $harga
            ]);
        }

        $stokMasuk = $baku->satuan === "Gram" ? $request->jml_masuk * 1000 : $request->jml_masuk;

        StokMasuk::create([
            'baku_id' => $baku->id,
            'supplier_id' => $request->supplier,
            'invoice' => $request->invoice,
            'stok_masuk' => $stokMasuk,
            'keterangan' => $request->keterangan,
        ]);

        $no_jurnal = "JU" . rand(001, 999);
        $total = $request->harga * $request->jml_masuk;
        Laporan::create([
            'no_jurnal' => $no_jurnal,
            'ket' => 'Pembelian Bahan Baku' . ' (' . $request->invoice . ')',
            'akun_debet' => 'Persediaan Bahan Baku',
            'debit' => $total,
            'akun_kredit' => 'Kas',
            'kredit' => $total,
        ]);

        return redirect()->route('product.masuk')
            ->with('success', 'Data Berhasil ditambahkan');
    }

    public function edit_masuk($id)
    {
        $product = StokMasuk::findOrFail($id);
        return response()->json($product);
    }

    public function update_masuk(Request $request)
    {
        $rules = [
            'produk' => 'required',
            'supplier' => 'required',
            'invoice' => 'required',
            'jml_masuk'     => 'required',
            'keterangan'      => 'required',
        ];

        $messages = [
            'produk.required'  => 'Supplier wajib dipilih',
            'supplier.required'  => 'Supplier wajib dipilih',
            'invoice.required'  => 'Nomor Invoice Wajib diisi',
            'jml_masuk.required' => 'Quantity Barang wajib diisi',
            'keterangan.required'  => 'Keterangan wajib diisi',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $masuk = StokMasuk::findOrFail($request->id);
        $bahanBaku = BahanBaku::findOrFail($request->produk);

        if ($bahanBaku->satuan === "Gram") {
            $stok_masuk = $request->jml_masuk * 1000; // Kalikan dengan 1000 jika satuan adalah Gram
        } else {
            $stok_masuk = $request->jml_masuk; // Jika tidak, gunakan nilai jml_masuk langsung
        }

        $masuk->baku_id = $request->produk;
        $masuk->supplier_id = $request->supplier;
        $masuk->invoice = $request->invoice;
        $masuk->stok_masuk = $stok_masuk;
        $masuk->keterangan = $request->keterangan;

        $masuk->save();

        return redirect()->back()->with('success', 'Data Berhasil diubah');
    }

    public function destroy_masuk($id)
    {
        StokMasuk::find($id)->delete();
        return redirect()->back()->with('error', 'Data Berhasil dihapus');
    }

    // bahan baku keluar
    public function keluar()
    {
        $stok_keluar = StokKeluar::with('baku')->orderBy('created_at', 'desc')->get();
        $baku = BahanBaku::get();
        $bakus = $baku->groupBy('name')->map(function ($group) {
            return $group[0];
        });
        // Mengubah hasil menjadi koleksi
        $produks = collect($bakus->values());

        $setting = Setting::first();

        $title = "Product - Barang Keluar";
        $judul = "Barang Keluar";
        return view('pages.product.keluar', compact('setting', 'title', 'judul', 'stok_keluar', 'produks'));
    }

    public function keluar_store(Request $request)
    {
        $rules = [
            'no_dokumen' => 'required',
            'jml_keluar'     => 'required',
            'keterangan'      => 'required',
        ];

        $messages = [
            'no_dokumen.required' => 'Nomor Dokumen wajib diisi',
            'jml_keluar.required' => 'Quantity Barang wajib diisi',
            'keterangan.required'  => 'Keterangan wajib diisi',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $baku = BahanBaku::where('id', $request->produk)->first();
        // $produk = Product::where('baku_id', $request->produk)->first();

        StokKeluar::create([
            'baku_id' => $baku->id,
            'stok_keluar' => $request->jml_keluar,
            'no_dokumen' => $request->no_dokumen,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('product.keluar')
            ->with('success', 'Data Berhasil ditambahkan');
    }

    public function edit_keluar($id)
    {
        $product = StokKeluar::findOrFail($id);
        return response()->json($product);
    }

    public function update_keluar(Request $request)
    {
        $rules = [
            'produk' => 'required',
            'no_dokumen' => 'required',
            'jml_keluar'     => 'required',
            'keterangan'      => 'required',
        ];

        $messages = [
            'produk.required'  => 'Nama Barang wajib dipilih',
            'no_dokumen.required'  => 'Nomor Dokumen wajib diisi',
            'jml_keluar.required' => 'Quantity Barang wajib diisi',
            'keterangan.required'  => 'Keterangan wajib diisi',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $keluar = StokKeluar::findOrFail($request->id);
        $keluar->produk_id = $request->produk;
        $keluar->no_dokumen = $request->no_dokumen;
        $keluar->stok_keluar = $request->jml_keluar;
        $keluar->keterangan = $request->keterangan;

        $keluar->save();

        return redirect()->back()->with('success', 'Data Berhasil diubah');
    }

    public function destroy_keluar($id)
    {
        StokKeluar::find($id)->delete();
        return redirect()->back()->with('error', 'Data Berhasil dihapus');
    }

    // Menu Bahan Baku
    public function bahan_baku()
    {
        $setting = Setting::first();
        $title = "Product - Bahan Baku";
        $judul = "Bahan Baku";

        $baku = BahanBaku::get();
        $produks = $baku->groupBy('name')->map(function ($group) {
            return $group[0];
        });
        // Mengubah hasil menjadi koleksi
        $bakus = collect($produks->values());
        return view('pages.product.bahan_baku', compact('setting', 'title', 'judul', 'bakus'));
    }

    public function baku_store(Request $request)
    {
        $kdBarang = "PRD" . $request->satuan . rand(1000, 9999) . date('dm');

        BahanBaku::create([
            'kode_barang' => $kdBarang,
            'name' => $request->name,
            'satuan' => $request->satuan,
        ]);

        return redirect()->route('product.baku')
            ->with('success', 'Data Berhasil ditambahkan');
    }

    public function edit_baku($id)
    {
        $product = BahanBaku::findOrFail($id);
        return response()->json($product);
    }

    public function update_baku(Request $request)
    {

        $baku = BahanBaku::findOrFail($request->id);
        $baku->name = $request->name;
        $baku->satuan = $request->satuan;
        $baku->save();

        return redirect()->back()->with('success', 'Data Berhasil diubah');
    }

    public function destroy_baku($id)
    {
        BahanBaku::find($id)->delete();
        return redirect()->back()->with('error', 'Data Berhasil dihapus');
    }
}
