<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\NeracaAwal;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsetController extends Controller
{
    public function index(Request $request)
    {
        $title = "Aset - Aset Tetap";
        $judul = "Rincian Aset Tetap";
        $setting = Setting::first();

        $asets = Aset::all();
        $dataEdit = Aset::get();

        $saldoAset = 0;

        foreach ($asets as $aset) {
            $nilai = $aset->harga_aset * $aset->jumlah_aset;
            $saldoAset += $nilai;
        }

        return view('pages.laporan.aset', compact('setting', 'title', 'judul', 'asets', 'saldoAset'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'nama_aset' => 'required|string',
            'jumlah_aset' => 'required|numeric',
            'harga_aset' => 'required|numeric',
        ]);

        $kode = "PRLTA" . rand(100, 999);
        $name = $request->input('nama_aset');
        $jumlah = $request->input('jumlah_aset');
        $harga = $request->input('harga_aset');

        Aset::create([
            'kode_aset' => $kode,
            'nama_aset' => $name,
            'jumlah_aset' => $jumlah,
            'harga_aset' => $harga,
        ]);

        // dd($request->all());


        // Hitung nilai aset
        $nilaiAset = $jumlah * $harga;

        // Update atau tambahkan ke NeracaAwal
        $this->updateNeracaAwal($nilaiAset);

        return redirect()->route('aset')->with('success', 'Data Aset berhasil ditambahkan');
    }

    public function edit($id)
    {
        $aset = Aset::findOrFail($id);

        return response()->json($aset);
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_aset' => 'required|string',
            'jumlah_aset' => 'required|numeric',
            'harga_aset' => 'required|numeric',
        ]);

        $aset = Aset::findOrFail($request->id);

        // Hitung nilai lama aset sebelum update
        $nilaiAsetLama = $aset->jumlah_aset * $aset->harga_aset;

        // Update data Aset
        $aset->update([
            'nama_aset' => $request->input('nama_aset'),
            'jumlah_aset' => $request->input('jumlah_aset'),
            'harga_aset' => $request->input('harga_aset'),
        ]);

        // Hitung nilai baru aset
        $nilaiAsetBaru = $aset->jumlah_aset * $aset->harga_aset;

        // Update NeracaAwal: kurangi nilai lama, tambahkan nilai baru
        $this->updateNeracaAwal(-$nilaiAsetLama); // Kurangi nilai lama
        $this->updateNeracaAwal($nilaiAsetBaru); // Tambah nilai baru

        return redirect()->route('aset')->with('success', 'Data Aset berhasil diupdate');
    }

    public function destroy($id)
    {
        // Temukan data Aset yang akan dihapus
        $aset = Aset::findOrFail($id);

        // Hitung nilai aset
        $nilaiAset = $aset->jumlah_aset * $aset->harga_aset;

        // Hapus data Aset
        $aset->delete();

        // Kurangi nilai di NeracaAwal
        $this->updateNeracaAwal(-$nilaiAset, true);

        return redirect()->route('aset')->with('success', 'Data Aset berhasil dihapus');
    }

    private function updateNeracaAwal($nilaiAset, $isDeleting = false)
    {
        // Cek apakah ada entri di NeracaAwal dengan akun_debet = 'Peralatan'
        $neraca = NeracaAwal::where('akun_debet', 'Peralatan')->first();

        if ($neraca) {
            // Jika ada, tambahkan atau kurangi nilai debit tergantung operasi (tambah/hapus)
            if ($isDeleting) {
                $neraca->debit -= $nilaiAset; // Kurangi nilai saat delete
            } else {
                $neraca->debit += $nilaiAset; // Tambah nilai saat create atau update
            }
            $neraca->save();
        } else {
            // Jika tidak ada, buat entri baru di NeracaAwal
            NeracaAwal::create([
                'akun_debet' => 'Peralatan',
                'debit' => $nilaiAset,
                'akun_kredit' => null,
                'kredit' => 0,
            ]);
        }
    }
}
