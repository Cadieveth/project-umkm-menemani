<?php

namespace App\Http\Controllers;

use App\Models\NeracaAwal;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NeracaAwalController extends Controller
{
    public function index(Request $request)
    {
        $title = "Laporan - Neraca Saldo Awal";
        $judul = "Laporan Neraca Saldo Awal";
        $setting = Setting::first();

        // Query untuk mendapatkan semua data NeracaAwal
        $NeracaAwal = NeracaAwal::all();

        // Query untuk mendapatkan saldo Aktiva
        $saldoKas = NeracaAwal::where('akun_debet', 'Kas')->sum('debit');
        $saldoPBB = NeracaAwal::where('akun_debet', 'Persediaan Bahan Baku')->sum('debit');
        $saldoPPJ = NeracaAwal::where('akun_debet', 'Persediaan Produk Jadi')->sum('debit');

        // Query untuk mendapatkan saldo Liabilitas dan Ekuitas
        $saldoHutangGaji = NeracaAwal::where('akun_kredit', 'Hutang Gaji')->sum('kredit');
        $saldoModal = NeracaAwal::where('akun_kredit', 'Modal')->sum('kredit');
        $saldoLR = NeracaAwal::where('akun_kredit', 'Laba/Rugi')->sum('kredit');

        $totalSaldoKas = $saldoKas + $saldoPBB + $saldoPPJ;
        $totalPersediaan = $saldoPBB + $saldoPPJ;
        $totalLiabilitas = $saldoHutangGaji;

        $totalAktiva = $totalSaldoKas;

        $totalModal = ($totalAktiva - $totalLiabilitas) - $saldoLR;
        $totalEkuitas = $totalModal + $saldoLR;
        $totalLiabilitasDanEkuitas = $totalLiabilitas + $totalEkuitas;

        return view('pages.laporan.neraca_awal', compact('setting', 'title', 'judul', 'NeracaAwal', 'saldoKas', 'saldoPBB', 'saldoPPJ', 'saldoHutangGaji', 'saldoModal', 'totalSaldoKas', 'totalPersediaan', 'totalLiabilitas', 'totalEkuitas', 'totalAktiva', 'totalLiabilitasDanEkuitas', 'totalModal', 'saldoLR'));
    }

    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'akun' => 'required|string',
        'nominal' => 'required|numeric',
    ]);

    $akun = $request->input('akun');
    $nominal = $request->input('nominal');

    // Cek jika akun sudah ada
    $existingRecord = NeracaAwal::where('akun_debet', $akun)
                                ->orWhere('akun_kredit', $akun)
                                ->first();

    if ($existingRecord) {
        return redirect()->back()->with('error', "Data attribute($akun) Sudah Ditambahkan");
    }

    // Insert data baru
    if ($akun == 'Hutang Gaji') {
        // Simpan ke akun_kredit dan kredit
        NeracaAwal::create([
            'akun_kredit' => $akun,
            'kredit' => $nominal,
        ]);

        // Kurangi nilai Modal
        $modal = NeracaAwal::where('akun_kredit', 'Modal')->first();
        if ($modal) {
            $modal->kredit -= $nominal; // Kurangi nilai modal
            $modal->save();
        } else {
            return redirect()->back()->with('error', 'Akun Modal tidak ditemukan untuk mengurangi nilai.');
        }
    } else {
        // Simpan ke akun_debet dan debit
        NeracaAwal::create([
            'akun_debet' => $akun,
            'debit' => $nominal,
        ]);

        // Update Modal akun_kredit
        $modal = NeracaAwal::where('akun_kredit', 'Modal')->first();
        if ($modal) {
            $modal->kredit += $nominal; // Tambah nilai modal
            $modal->save();
        } else {
            NeracaAwal::create([
                'akun_kredit' => 'Modal',
                'kredit' => $nominal,
            ]);
        }
    }

    return redirect()->route('neraca_awal')->with('success', 'Data berhasil ditambahkan');
}


}
