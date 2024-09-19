<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\NeracaAwal;
use App\Models\Setting;
use App\Models\BahanBaku;
use App\Models\StokMasuk;
use App\Models\ProductSell;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailController extends Controller
{
    public function index(Request $request)
    {
        $title = "Detail - Saldo Persediaan";
        $judul = "Rincian Saldo Persediaan";
        $setting = Setting::first();

        $saldoPBB = 0;
        $saldoPPJ = 0;

        // Ambil semua detail
        $details = Detail::all();
        $dataEdit = Detail::get();

        // Loop melalui setiap detail
        foreach ($details as $detail) {
            $nilai = $detail->harga * $detail->jumlah_stok;
            if ($detail->ket === 'Persediaan Bahan Baku') {
                $saldoPBB += $nilai;
            } elseif ($detail->ket === 'Persediaan Produk Jadi') {
                $saldoPPJ += $nilai;
            }
        }

        return view('pages.laporan.detail_saldo', compact('setting', 'title', 'judul', 'details', 'saldoPBB', 'saldoPPJ'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'harga' => 'required|numeric',
            'jumlah_stok' => 'required|numeric',
            'satuan' => 'required|string',
            'ket' => 'required|string',
        ]);

        $name = $request->input('name');
        $kode = "PRDAWAL" . rand(10000, 99999);
        $harga = $request->input('harga');
        $jumlah_stok = $request->input('jumlah_stok');
        $satuan = $request->input('satuan');
        $ket = $request->input('ket');

        Detail::create([
            'name' => $name,
            'kode' => $kode,
            'harga' => $harga,
            'jumlah_stok' => $jumlah_stok,
            'satuan' => $satuan,
            'ket' => $ket,
        ]);

        if ($ket === "Persediaan Bahan Baku") {
            if ($satuan === "Gram") {
                $harga = $harga / 1000;  // Harga dalam kilogram
                $jumlah_stok = $jumlah_stok * 1000;  // Stok dalam gram
            }

            $bahanBaku = BahanBaku::create([
                'kode_barang' => $kode,
                'name' => $name,
                'satuan' => $satuan,
                'harga' => $harga,
            ]);

            StokMasuk::create([
                'baku_id' => $bahanBaku->id,
                'supplier_id' => 4,
                'invoice' => "SA" . rand(10, 99),
                'stok_masuk' => $jumlah_stok,
                'keterangan' => "Saldo Awal",
            ]);
        } elseif ($ket === "Persediaan Produk Jadi") {
            $date = Carbon::now()->format('mY');
            ProductSell::create([
                'no_resep' => "RESA" . $date . rand(100000, 999999),
                'kode_product' => $kode,
                'nama_product' => $name,
                'hpp' => $harga,
                'harga_jual' => $harga,
                'qty_in' => $jumlah_stok,
                'qty_out' => 0,
            ]);
        }

        // Update or create entry in NeracaAwal
        $this->updateNeracaAwal($ket, $harga * $jumlah_stok);

        return redirect()->route('detail_saldo')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        // Cari data berdasarkan ID
        $detail = Detail::findOrFail($id);

        // Kirim data ke view dalam bentuk JSON untuk digunakan di JavaScript
        return response()->json($detail);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:details,id',
            'name' => 'required|string',
            'harga' => 'required|numeric',
            'jumlah_stok' => 'required|numeric',
            'satuan' => 'required|string',
            'ket' => 'required|string',
        ]);

        // Ambil data berdasarkan ID
        $detail = Detail::findOrFail($request->id);

        // Dapatkan nilai lama sebelum update
        $oldKet = $detail->ket;
        $oldDebit = $detail->harga * $detail->jumlah_stok;

        // Update data detail
        $detail->update([
            'name' => $request->input('name'),
            'harga' => $request->input('harga'),
            'jumlah_stok' => $request->input('jumlah_stok'),
            'satuan' => $request->input('satuan'),
            'ket' => $request->input('ket'),
        ]);

        // Kurangi nilai lama dari NeracaAwal
        $this->updateNeracaAwal($oldKet, -$oldDebit);

        // Tambahkan nilai baru ke NeracaAwal
        $newKet = $request->input('ket');
        $newDebit = $request->input('harga') * $request->input('jumlah_stok');
        $this->updateNeracaAwal($newKet, $newDebit);

        if ($oldKet !== $newKet) {
            if ($oldKet === "Persediaan Bahan Baku") {
                BahanBaku::where('kode_barang', $detail->kode)->delete();
                StokMasuk::where('baku_id', function ($query) use ($detail) {
                    $query->select('id')
                        ->from('bahan_bakus')
                        ->where('kode_barang', $detail->kode);
                })->delete();

                if ($newKet === "Persediaan Produk Jadi") {
                    $date = Carbon::now()->format('mY');
                    ProductSell::create([
                        'no_resep' => "RESA" . $date . rand(100000, 999999),
                        'kode_product' => $detail->kode,
                        'nama_product' => $request->input('name'),
                        'hpp' => $this->calculatePrice($request->input('harga'), $request->input('satuan')),
                        'harga_jual' => $this->calculatePrice($request->input('harga'), $request->input('satuan')),
                        'qty_in' => $this->adjustStock($request->input('jumlah_stok'), $request->input('satuan')),
                        'qty_out' => 0,
                    ]);
                }
            } elseif ($oldKet === "Persediaan Produk Jadi") {
                ProductSell::where('kode_product', $detail->kode)->delete();

                if ($newKet === "Persediaan Bahan Baku") {
                    $bahanBaku = BahanBaku::create([
                        'kode_barang' => $detail->kode,
                        'name' => $request->input('name'),
                        'satuan' => $request->input('satuan'),
                        'harga' => $this->calculatePrice($request->input('harga'), $request->input('satuan')),
                    ]);

                    StokMasuk::create([
                        'baku_id' => $bahanBaku->id,
                        'supplier_id' => 4,
                        'invoice' => "SA" . rand(10, 99),
                        'stok_masuk' => $this->adjustStock($request->input('jumlah_stok'), $request->input('satuan')),
                        'keterangan' => "Saldo Awal",
                    ]);
                }
            }
        } else {
            // Update data yang sesuai dengan ket lama dan baru
            if ($newKet === "Persediaan Bahan Baku") {
                $bahanBaku = BahanBaku::where('kode_barang', $detail->kode)->first();
                if ($bahanBaku) {
                    $bahanBaku->update([
                        'name' => $request->input('name'),
                        'satuan' => $request->input('satuan'),
                        'harga' => $this->calculatePrice($request->input('harga'), $request->input('satuan')),
                    ]);
                    $stokMasuk = StokMasuk::where('baku_id', $bahanBaku->id)->first();
                    if ($stokMasuk) {
                        $stokMasuk->update([
                            'stok_masuk' => $this->adjustStock($request->input('jumlah_stok'), $request->input('satuan')),
                        ]);
                    }
                }
            } elseif ($newKet === "Persediaan Produk Jadi") {
                $productSell = ProductSell::where('kode_product', $detail->kode)->first();
                if ($productSell) {
                    $productSell->update([
                        'nama_product' => $request->input('name'),
                        'hpp' => $this->calculatePrice($request->input('harga'), $request->input('satuan')),
                        'harga_jual' => $this->calculatePrice($request->input('harga'), $request->input('satuan')),
                        'qty_in' => $this->adjustStock($request->input('jumlah_stok'), $request->input('satuan')),
                    ]);
                }
            }
        }

        return redirect()->route('detail_saldo')->with('success', 'Data berhasil diperbarui');
    }

    private function calculatePrice($harga, $satuan)
    {
        return $satuan === 'Gram' ? $harga / 1000 : $harga;
    }

    private function adjustStock($jumlah_stok, $satuan)
    {
        return $satuan === 'Gram' ? $jumlah_stok * 1000 : $jumlah_stok;
    }

    public function destroy($id)
    {
        $detail = Detail::findOrFail($id);

        $detail->delete();

        // Kurangi nilai dari NeracaAwal
        $this->updateNeracaAwal($detail->ket, -($detail->harga * $detail->jumlah_stok));

        return redirect()->route('detail_saldo')->with('success', 'Data berhasil dihapus');
    }

    private function updateNeracaAwal($ket, $debitChange)
    {
        $akunDebet = null;
        if ($ket === "Persediaan Bahan Baku") {
            $akunDebet = "Persediaan Bahan Baku";
        } elseif ($ket === "Persediaan Produk Jadi") {
            $akunDebet = "Persediaan Produk Jadi";
        }

        if ($akunDebet) {
            // Update existing entry or create new one for debit accounts
            $neraca = NeracaAwal::where('akun_debet', $akunDebet)->first();

            if ($neraca) {
                // Update existing entry
                $neraca->debit += $debitChange;
                $neraca->save();
            } else {
                // Create new entry if not exist
                NeracaAwal::create([
                    'akun_debet' => $akunDebet,
                    'debit' => $debitChange,
                    'akun_kredit' => null,
                    'kredit' => 0,
                ]);
            }
        }
    }

}
