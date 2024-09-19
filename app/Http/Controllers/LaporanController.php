<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Laporan;
use App\Models\Master;
use App\Models\OrderStok;
use App\Models\Product;
use App\Models\ProductSell;
use App\Models\Setting;
use App\Models\StokMasuk;
use App\Models\Transaksi;
use App\Models\NeracaAwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $title = "Laporan - Neraca";
        $judul = "Laporan Neraca";
        $setting = Setting::first();

        $tahun = BahanBaku::select(DB::raw('YEAR(created_at) as year'))
            ->distinct()
            ->pluck('year')
            ->sort()
            ->toArray();

        $selectedYear = $request->input('tahun', reset($tahun));

        // Hutang Gaji
        $totalDebit = Laporan::where('akun_debet', 'Hutang Gaji')
            ->sum('debit');

        $totalKredit = Laporan::where('akun_kredit', 'Hutang Gaji')
            ->sum('kredit');

        $awalHutang = NeracaAwal::where('akun_kredit', 'Hutang Gaji')
            ->select('kredit')
            ->first();

        $awalHutangKredit = $awalHutang ? $awalHutang->kredit : 0;

        // Modal Awal
        $totalDebitNA = NeracaAwal::whereIn('akun_debet', ['Kas', 'Persediaan Bahan Baku', 'Persediaan Produk Jadi'])
            ->sum('debit');

        $totalKreditNA = NeracaAwal::where('akun_kredit', 'Hutang Gaji')
            ->sum('kredit');

        // Laba/Rugi
        $transaksi = Transaksi::select(
            DB::raw('(SELECT SUM(transaksis.sub_total)) AS sell')
        )
            ->whereYear('created_at', $selectedYear)
            ->whereNull('transaksis.deleted_at')
            ->first();

        $produkSell = ProductSell::whereYear('created_at', $selectedYear)->sum(DB::raw('hpp'));

        $penjualan = Laporan::where('akun_kredit', 'Penjualan')
            ->whereYear('created_at', $selectedYear)
            ->sum('kredit');

        $masters = Master::get();
        $masterName = $masters->pluck('name')->toArray();
        $kass = Laporan::whereIn('akun_debet', $masterName)
            ->sum(DB::raw('debit'));
        $bebanUsaha = $kass;

        if ($tahun != null) {
            $tahun;
        } else {
            $tahun[] = 2024;
        }

        $hppOperation = Laporan::where('akun_hpp', 'HPP')
            ->select('akun_hpp', 'hpp', 'no_jurnal', 'ket', 'created_at')
            ->sum('hpp');

        $hppAwal = NeracaAwal::where('akun_kredit', 'Laba/Rugi')
            ->select('kredit')
            ->first();

        $hppAwalValue = $hppAwal ? $hppAwal->kredit : 0; // Pastikan $hppAwal tidak null

        $hpp = $hppAwalValue + $hppOperation; // Melakukan pengurangan antara nilai kredit dan hasil sum

        $pendapatan = $penjualan - $hpp;

        // Hitung saldo PBB dan PPJ
        $saldoPbb = $this->calculatePBB();
        $saldoPpj = $this->calculatePPJ();

        // Hitung Kas
        $saldoKas = $this->CalculateKas();

        // Perhitungan Saldo
        $saldoHutang = $awalHutangKredit + ($totalKredit - $totalDebit);
        $saldoModal = $totalDebitNA - $totalKreditNA;
        $saldoLabaRugi = $pendapatan - $bebanUsaha;

        // Perhitungan jumlah Saldo
        $jumlahLiabilitas = $saldoHutang;
        $jumlahEkuitas = $saldoModal + $saldoLabaRugi;
        $jumlahAktivaTetap = $saldoPbb + $saldoPpj;
        $jumalhAktivaLancar = $saldoKas;

        // Balance Kanan-Kiri
        $totalKanan = $jumlahLiabilitas + $jumlahEkuitas;
        $totalKiri = $jumlahAktivaTetap + $jumalhAktivaLancar;

        return view('pages.laporan.neraca', compact('setting', 'judul', 'title', 'tahun', 'selectedYear', 'saldoHutang', 'saldoModal', 'saldoLabaRugi', 'jumlahLiabilitas', 'jumlahEkuitas', 'totalKanan', 'saldoPbb', 'saldoPpj', 'jumlahAktivaTetap', 'saldoKas', 'jumalhAktivaLancar', 'totalKiri'));
    }

    private function calculatePBB()
    {
        // Persediaan Bahan Baku
        $pbbDebit = Laporan::where('akun_debet', 'Persediaan Bahan Baku')
            ->select('akun_debet', 'debit', 'no_jurnal', 'ket', 'created_at')
            ->get();

        $pbbKredit = Laporan::where('akun_kredit', 'Persediaan Bahan Baku')
            ->select('akun_kredit', 'kredit', 'no_jurnal', 'ket', 'created_at')
            ->get();

        // $pbbKredit = Laporan::where('akun_kredit', 'Persediaan Bahan Baku')
        //     ->get()
        //     ->map(function ($item) {
        //         // Cari semua bahan baku yang ada di dalam kurung pada akun_debet
        //         preg_match_all('/Persediaan Barang Jadi \((.*?)\)/', $item->akun_debet, $matches);
        //         $namaBahanBakuArray = explode(', ', $matches[1][0] ?? '');

        //         $bahanBakuNettTotal = 0;

        //         // Iterasi setiap nama bahan baku yang ditemukan
        //         foreach ($namaBahanBakuArray as $namaBahanBaku) {
        //             if ($namaBahanBaku) {
        //                 $bahanBaku = BahanBaku::where('name', $namaBahanBaku)->first();
        //                 if ($bahanBaku) {
        //                     $harga = $bahanBaku->harga;

        //                     preg_match('/Produksi (.*?) \((.*?)\)/', $item->ket, $ketMatches);
        //                     $kdProduct = $ketMatches[2] ?? null;

        //                     if ($kdProduct) {
        //                         $productSell = ProductSell::where('kode_product', $kdProduct)->first();
        //                         if ($productSell) {
        //                             $qty_in = $productSell->qty_in;

        //                             // Hitung bahanBakuNett untuk setiap bahan baku dan tambahkan ke total
        //                             $bahanBakuNettTotal += $harga * $qty_in;
        //                         }
        //                     }
        //                 }
        //             }
        //         }

        //         // Simpan total bahanBakuNett pada item
        //         $item->kredit = $bahanBakuNettTotal;

        //         return $item;
        //     });

        $totalDebit = $pbbDebit->sum('debit');
        $totalKredit = $pbbKredit->sum('kredit');

        $awalPbb = NeracaAwal::where('akun_debet', 'Persediaan Bahan Baku')
            ->select('debit')
            ->first();

        $awalPbbDebit = $awalPbb ? $awalPbb->debit : 0;

        return $awalPbbDebit + ($totalDebit - $totalKredit);
    }

    private function calculatePPJ()
    {
        // Persediaan Barang Jadi
        $ppj = Laporan::where('akun_debet', 'like', 'Persediaan Barang Jadi%')
            ->orWhere('akun_persediaan', 'like', 'Persediaan Barang Jadi%')
            ->select('akun_debet', 'debit', 'akun_persediaan', 'persediaan')
            ->get();

        $totalDebitPpj = Laporan::where('akun_debet', 'like', 'Persediaan Barang Jadi%')
            ->sum('debit');

        $totalPersediaanPpj = Laporan::where('akun_persediaan', 'like', 'Persediaan Barang Jadi%')
            ->sum('persediaan');

        $awalPpj = NeracaAwal::where('akun_debet', 'Persediaan Produk Jadi')
            ->select('debit')
            ->first();

        $awalPpjDebit = $awalPpj ? $awalPpj->debit : 0;

        return ($totalDebitPpj - $totalPersediaanPpj) + $awalPpjDebit;
    }

    private function CalculateKas()
    {
        $masters = Master::get();
        $masterName = $masters->pluck('name')->toArray();

        $laporans = Laporan::where(function ($query) use ($masterName) {
            $query->whereIn('akun_debet', $masterName)
                ->orWhere('akun_debet', 'Penjualan')
                ->orWhere('akun_debet', 'Kas')
                ->orWhere('akun_kredit', 'Kas');
        })
            ->select('akun_debet', 'debit', 'akun_kredit', 'kredit', 'no_jurnal', 'ket', 'created_at')
            ->get();

        $totalKasDebit = $laporans->where('akun_debet', 'Kas')->sum('debit');
        $totalKasKredit = $laporans->where('akun_kredit', 'Kas')->sum('kredit');

        // dd($totalKasDebit - $totalKasKredit);

        $awalKas = NeracaAwal::where('akun_debet', 'Kas')
            ->select('debit')
            ->first();

        $modalAwal = $awalKas ? $awalKas->debit : 0;

        return ($totalKasDebit - $totalKasKredit) + $modalAwal;
        // dd($saldoKas);
    }

    public function laba_rugi(Request $request)
    {
        $title = "Laporan - Laba Rugi";
        $judul = "Laporan Laba Rugi";
        $setting = Setting::first();

        $pendapatanAwal = 2450000;
        $bebanUsaha = 0;
        $pajak = 0;

        $tahun = BahanBaku::select(DB::raw('YEAR(created_at) as year'))
            ->distinct()
            ->pluck('year')
            ->sort()
            ->toArray();

        $selectedYear = $request->input('tahun', reset($tahun));

        // Ambil data transaksi berdasarkan tahun yang dipilih
        $transaksi = Transaksi::select(
            DB::raw('(SELECT SUM(transaksis.sub_total)) AS sell')
        )
            ->whereYear('created_at', $selectedYear)
            ->whereNull('transaksis.deleted_at')
            ->first();

        $produkSell = ProductSell::whereYear('created_at', $selectedYear)->sum(DB::raw('hpp'));

        $penjualan = Laporan::where('akun_kredit', 'Penjualan')
            ->whereYear('created_at', $selectedYear)
            ->sum('kredit');

        $hargaProduk = BahanBaku::join('stok_masuks', 'bahan_bakus.id', '=', 'stok_masuks.baku_id')
            ->whereYear('stok_masuks.created_at', $selectedYear) // Filter berdasarkan tahun
            ->sum(DB::raw('bahan_bakus.harga * stok_masuks.stok_masuk'));

        $masters = Master::get();
        $masterName = $masters->pluck('name')->toArray();
        $kass = Laporan::whereIn('akun_debet', $masterName)
            ->sum(DB::raw('debit'));
        // dd($kass);
        $bebanUsaha = $kass;
        // $labaKotor = ($pendapatanAwal + $transaksi->sell) - $produkSell;
        $labaKotor = ($pendapatanAwal + $transaksi->sell);
        // dd([$labaKotor, $labaKotor1]);
        // }

        if ($tahun != null) {
            $tahun;
        } else {
            $tahun[] = 2024;
        }

        $hppOperation = Laporan::where('akun_hpp', 'HPP')
            ->select('akun_hpp', 'hpp', 'no_jurnal', 'ket', 'created_at')
            ->sum('hpp');

        $hppAwal = NeracaAwal::where('akun_kredit', 'Laba/Rugi')
            ->select('kredit')
            ->first();

        $hppAwalValue = $hppAwal ? $hppAwal->kredit : 0; // Pastikan $hppAwal tidak null

        $hpp = $hppAwalValue + $hppOperation; // Melakukan pengurangan antara nilai kredit dan hasil sum

        $pendapatan = $penjualan - $hpp;
        $labaRugi = $pendapatan - $bebanUsaha - $pajak;

        return view('pages.laporan.laba_rugi', compact('penjualan', 'setting', 'title', 'judul', 'tahun', 'labaKotor', 'hpp', 'pendapatan', 'bebanUsaha', 'pajak', 'labaRugi', 'selectedYear'));
    }

    public function per_modal(Request $request)
    {
        $title = "Laporan - Perubahan Modal";
        $judul = "Laporan Perubahan Modal";
        $setting = Setting::first();

        $modalAwal = 6000000;
        $persediaan = 2450000;
        $labaBersih = 0;
        $prive = 0;
        $pajak = 0;

        $tahun = BahanBaku::select(DB::raw('YEAR(created_at) as year'))
            ->distinct()
            ->pluck('year')
            ->sort()
            ->toArray();

        $selectedYear = $request->input('tahun', reset($tahun));

        $debit = Laporan::whereYear('created_at', $selectedYear)->where('akun_debet', 'Kas')->sum(DB::raw('debit'));
        $kredit = Laporan::whereYear('created_at', $selectedYear)->where('akun_kredit', 'Kas')->sum(DB::raw('kredit'));

        $transaksi = Transaksi::select(
            DB::raw('(SELECT SUM(transaksis.sub_total)) AS sell')
        )
            ->whereYear('created_at', $selectedYear)
            ->whereNull('transaksis.deleted_at')
            ->first();

        $produkSell = ProductSell::whereYear('created_at', $selectedYear)->sum(DB::raw('hpp'));

        // Hitung total debit untuk akun_debet yang diinginkan
        $totalDebit = NeracaAwal::whereIn('akun_debet', ['Kas', 'Persediaan Bahan Baku', 'Persediaan Produk Jadi'])
            ->sum('debit');

        // Hitung total kredit untuk akun_kredit yang diinginkan
        $totalKredit = NeracaAwal::where('akun_kredit', 'Hutang Gaji')
            ->sum('kredit');

        // Kurangi total debit dengan total kredit
        $saldoModal = $totalDebit - $totalKredit;

        $penjualan = Laporan::where('akun_kredit', 'Penjualan')
            ->whereYear('created_at', $selectedYear)
            ->sum('kredit');

        $hargaProduk = BahanBaku::join('stok_masuks', 'bahan_bakus.id', '=', 'stok_masuks.baku_id')
            ->whereYear('stok_masuks.created_at', $selectedYear) // Filter berdasarkan tahun
            ->sum(DB::raw('bahan_bakus.harga * stok_masuks.stok_masuk'));

        $masters = Master::get();
        $masterName = $masters->pluck('name')->toArray();
        $kass = Laporan::whereIn('akun_debet', $masterName)
            ->sum(DB::raw('debit'));
        // dd($kass);
        $modal = ($modalAwal + $debit) - $kredit;
        $bebanUsaha = $kass;
        $labaKotor = ($persediaan + $transaksi->sell) - $produkSell;

        $labaBersih = $labaKotor - $bebanUsaha - $pajak;

        if ($tahun != null) {
            $tahun;
        } else {
            $tahun[] = 2024;
        }

        $hppOperation = Laporan::where('akun_hpp', 'HPP')
            ->select('akun_hpp', 'hpp', 'no_jurnal', 'ket', 'created_at')
            ->sum('hpp');

        $hppAwal = NeracaAwal::where('akun_kredit', 'Laba/Rugi')
            ->select('kredit')
            ->first();

        $hppAwalValue = $hppAwal ? $hppAwal->kredit : 0; // Pastikan $hppAwal tidak null

        $hpp = $hppAwalValue + $hppOperation;

        $pendapatan = $penjualan - $hpp;
        $labaRugi = $pendapatan - $bebanUsaha - $pajak;

        $labaDitahan = NeracaAwal::where('akun_kredit', 'Laba/Rugi')
        ->select('kredit')
        ->first();

        $total = $labaRugi + $labaDitahan->kredit;
        $modalAkhir = $saldoModal + $total;

        return view('pages.laporan.perubahan_modal', compact('labaDitahan', 'labaRugi', 'saldoModal', 'setting', 'title', 'judul', 'tahun', 'modalAwal', 'labaBersih', 'prive', 'total', 'modalAkhir', 'selectedYear'));
    }

    public function jurnal_umum(Request $request)
    {
        $title = "Laporan - Jurnal Umum";
        $judul = "Laporan Jurnal Umum";
        $setting = Setting::first();

        $laporans = Laporan::get()->sortBy(function ($item) {
            return [
                -strtotime($item->created_at),
                ($item->akun_debet === "Hutang Gaji" && $item->akun_kredit === "Kas") ? 1 : 0,
            ];
        });

        return view('pages.laporan.jurnal', compact('setting', 'title', 'judul', 'laporans'));
    }

    public function buku_besar(Request $request)
    {
        $title = "Laporan - Buku Besar";
        $judul = "Laporan Buku Besar";
        $setting = Setting::first();
        $masters = Master::get();
        $masterName = $masters->pluck('name')->toArray();

        $penjualan = Laporan::where('akun_debet', 'Penjualan')
            ->orWhere('akun_debet', 'Kas')
            ->select('akun_debet', 'debit', 'no_jurnal', 'ket', 'created_at')
            ->get();

        $beli = Laporan::where('akun_debet', 'Persediaan')
            ->select('akun_debet', 'debit', 'no_jurnal', 'ket', 'created_at')
            ->get();

        $hpps = Laporan::where('akun_hpp', 'HPP')
            ->select('akun_hpp', 'hpp', 'no_jurnal', 'ket', 'created_at')
            ->get();

        $btkl = Laporan::where('akun_debet', 'Biaya Tenaga Kerja Langsung')
            ->select('akun_debet', 'debit', 'no_jurnal', 'ket', 'created_at')
            ->get();

        // HPP
        $hpp = Laporan::where('akun_hpp', 'HPP')
            ->select('akun_hpp', 'hpp', 'no_jurnal', 'ket', 'created_at')
            ->get();

        $hppAwal = NeracaAwal::where('akun_kredit', 'Laba/Rugi')
            ->select('kredit')
            ->first();

        // HUTANG GAJI
        $hutang = Laporan::where('akun_debet', 'Hutang Gaji')
            ->orWhere('akun_kredit', 'Hutang Gaji')
            ->select('akun_debet', 'debit', 'akun_kredit', 'kredit', 'no_jurnal', 'ket', 'created_at')
            ->get()
            ->sortBy(function ($item) {
                // Jika 'akun_debet' adalah 'Hutang Gaji', beri nilai 1 (paling bawah)
                return $item->akun_debet == 'Hutang Gaji' ? 1 : 0;
            })
            ->sortByDesc('created_at'); // Urutkan berdasarkan tanggal terbaru terlebih dahulu

        $awalHutang = NeracaAwal::where('akun_kredit', 'Hutang Gaji')
            ->select('kredit')
            ->first();

        $beban = Laporan::whereIn('akun_debet', $masterName)
            ->select('akun_debet', 'debit', 'no_jurnal', 'ket', 'created_at')
            ->get();

        // KAS
        $laporans = Laporan::where(function ($query) use ($masterName) {
            $query->whereIn('akun_debet', $masterName)
                ->orWhere('akun_debet', 'Penjualan')
                ->orWhere('akun_debet', 'Kas')
                ->orWhere('akun_kredit', 'Kas');
        })
            ->select('akun_debet', 'debit', 'akun_kredit', 'kredit', 'no_jurnal', 'ket', 'created_at')
            ->get();

        $awalKas = NeracaAwal::where('akun_debet', 'Kas')
            ->select('debit')
            ->first();

        $modalAwal = $awalKas ? $awalKas->debit : 0;

        // BAHAN BAKU
        $pbbDebit = Laporan::where('akun_debet', 'Persediaan Bahan Baku')
            ->select('akun_debet', 'debit', 'no_jurnal', 'ket', 'created_at')
            ->get();

        $pbbKredit = Laporan::where('akun_kredit', 'Persediaan Bahan Baku')
            ->select('akun_kredit', 'kredit', 'no_jurnal', 'ket', 'created_at')
            ->get();

        // $pbbKredit = Laporan::where('akun_kredit', 'Persediaan Bahan Baku')
        //     ->get()
        //     ->map(function ($item) {
        //         // Cari semua bahan baku yang ada di dalam kurung pada akun_debet
        //         preg_match_all('/Persediaan Barang Jadi \((.*?)\)/', $item->akun_debet, $matches);
        //         $namaBahanBakuArray = explode(', ', $matches[1][0] ?? '');

        //         $bahanBakuNettTotal = 0;

        //         // Iterasi setiap nama bahan baku yang ditemukan
        //         foreach ($namaBahanBakuArray as $namaBahanBaku) {
        //             if ($namaBahanBaku) {
        //                 $bahanBaku = BahanBaku::where('name', $namaBahanBaku)->first();
        //                 if ($bahanBaku) {
        //                     $harga = $bahanBaku->harga;

        //                     preg_match('/Produksi (.*?) \((.*?)\)/', $item->ket, $ketMatches);
        //                     $kdProduct = $ketMatches[2] ?? null;

        //                     if ($kdProduct) {
        //                         $productSell = ProductSell::where('kode_product', $kdProduct)->first();
        //                         if ($productSell) {
        //                             $qty_in = $productSell->qty_in;

        //                             // Hitung bahanBakuNett untuk setiap bahan baku dan tambahkan ke total
        //                             $bahanBakuNettTotal += $harga * $qty_in;
        //                         }
        //                     }
        //                 }
        //             }
        //         }

        //         // Simpan total bahanBakuNett pada item
        //         $item->kredit = $bahanBakuNettTotal;

        //         return $item;
        //     });


        // $pbb = Laporan::where('akun_debet', 'Persediaan Bahan Baku')
        //     ->orWhere('akun_kredit', 'Persediaan Bahan Baku')
        //     ->select('akun_debet', 'debit', 'no_jurnal', 'ket', 'created_at')
        //     ->get()
        //     ->map(function ($item) {
        //         preg_match('/Persediaan Barang Jadi \((.*?)\)/', $item->akun_debet, $matches);
        //     $namaBahanBaku = $matches[1] ?? null;

        //     if ($namaBahanBaku) {
        //         $bahanBaku = BahanBaku::where('name', $namaBahanBaku)->first();
        //         if ($bahanBaku) {
        //             $harga = $bahanBaku->harga;

        //             preg_match('/Produksi (.*?) \((.*?)\)/', $item->ket, $ketMatches);
        //             $kdProduct = $ketMatches[2] ?? null;

        //             if ($kdProduct) {
        //                 $productSell = ProductSell::where('kode_product', $kdProduct)->first();
        //                 if ($productSell) {
        //                     $qty_in = $productSell->qty_in;
        //                     $bahanBakuNett = $harga * $qty_in;
        //                     $item->kredit = $bahanBakuNett;
        //                 }
        //             }
        //         }
        //     }

        //         return $item;
        //     });

        $awalPbb = NeracaAwal::where('akun_debet', 'Persediaan Bahan Baku')
            ->select('debit')
            ->first();

        // Gunakan concat untuk menggabungkan kedua Collection
        $mergePbb = $pbbDebit->concat($pbbKredit);

        // Atau, jika Anda ingin menggunakan method push
        $mergePbb = collect($pbbDebit);
        foreach ($pbbKredit as $item) {
            $mergePbb->push($item);
        }

        // PRODUK JADI
        $ppj = Laporan::where('akun_debet', 'like', 'Persediaan Barang Jadi%')
            ->orWhere('akun_persediaan', 'like', 'Persediaan Barang Jadi%')
            ->select('akun_debet', 'debit', 'akun_persediaan', 'persediaan', 'no_jurnal', 'ket', 'created_at')
            ->get();

        $awalPpj = NeracaAwal::where('akun_debet', 'Persediaan Produk Jadi')
            ->select('debit')
            ->first();

        return view('pages.laporan.buku_besar', compact('btkl', 'awalHutang', 'hutang', 'mergePbb', 'modalAwal', 'setting', 'title', 'judul', 'awalKas', 'awalPpj', 'ppj', 'awalPbb', 'hpps', 'laporans', 'penjualan', 'beli', 'beban', 'masters', 'masterName', 'hpp', 'hppAwal'));
    }
}
