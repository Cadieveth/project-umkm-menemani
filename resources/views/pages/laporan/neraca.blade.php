@extends('layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $judul }}</h1>
    </div>

    <form action="{{ route('lap.neraca') }}" method="GET">
        <div class="wrapper-table bg-white rounded ">
            <div class="card shadow ">
                <div class="card-header">
                    <div class="input-group flex-nowrap w-25">
                        <select id="tahun" name="tahun" class="btn btn-primary">
                            <option selected disabled class="text-white">-- Pilih Tahun --</option>
                            @foreach ($tahun as $tahunItem)
                                <option value="{{ $tahunItem }}">{{ $tahunItem }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-header text-center">
                            <h6 class="text-uppercase "><b>{{ $setting->company_name }}</b></h6>
                            <h6 class="text-capitalize"><b>laporan posisi keuangan (neraca)</b></h6>
                            <h6 class="text-capitalize"><b>Periode Akhir Desember {{ $selectedYear }}</b></h6>
                        </div>
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-sm-6 ">
                                    <center> <span class="text-uppercase"><b>aktiva</b></span></center>
                                    <span class="text-capitalize"><b>aktiva lancar</b></span>
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <span>Kas</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span>{{ 'Rp ' . number_format($saldoKas, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span><b>Jumlah</b></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span><b>{{ 'Rp ' . number_format($jumalhAktivaLancar, 0, ',', '.') }}</b></span>
                                        </div>
                                    </div>
                                    <span class="text-capitalize"><b>aktiva Tetap</b></span>
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <span>Persediaan Bahan Baku</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span>{{ 'Rp ' . number_format($saldoPbb, 0, ',', '.') }}</span>

                                        </div>
                                        <div class="col-sm-6">
                                            <span>Persediaan Produk Jadi</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span>{{ 'Rp ' . number_format($saldoPpj, 0, ',', '.') }}</span>

                                        </div>
                                        <div class="col-sm-6">
                                            <span><b>Jumlah</b></span>
                                        </div>
                                        <div class="col-sm-6 ">
                                            <span><u class="mt-2">
                                                    <b>{{ 'Rp ' . number_format($jumlahAktivaTetap, 0, ',', '.') }}</b></u>
                                                <sub>+</sub>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <span><b>Total Aktiva (Lancar + Tetap)</b></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span><b>{{ 'Rp ' . number_format($totalKiri, 0, ',', '.') }}</b></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <center> <span class="text-uppercase"><b>kewajiban</b></span></center>
                                    <span class="text-capitalize"><b>liabilitas</b></span>
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <span>Utang Gaji</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span><u>{{ 'Rp ' . number_format($saldoHutang, 0, ',', '.') }}
                                                    <sub>+</sub>
                                                </u></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span><b>Jumlah Liabilitas</b></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span><b>{{ 'Rp ' . number_format($jumlahLiabilitas, 0, ',', '.') }}</b></span>
                                        </div>
                                    </div>
                                    <span class="text-capitalize"><b>ekuitas</b></span>
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <span>Modal Awal</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span>{{ 'Rp ' . number_format($saldoModal, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="col-sm-6">
                                            @if ($saldoLabaRugi < 0)
                                                <span>Saldo Rugi</span>
                                            @else
                                                <span>Saldo Laba</span>
                                            @endif
                                        </div>
                                        <div class="col-sm-6">
                                            @if ($saldoLabaRugi < 0)
                                                <span><u class="mt-2">
                                                        ({{ 'Rp ' . number_format($saldoLabaRugi, 0, ',', '.') }})
                                                    </u><sub>+</sub>
                                                </span>
                                            @else
                                                <span><u class="mt-2">
                                                        {{ 'Rp ' . number_format($saldoLabaRugi, 0, ',', '.') }}
                                                    </u><sub>+</sub>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-sm-6">
                                            <span><b>Jumlah</b></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span>
                                                <b>{{ 'Rp ' . number_format($jumlahEkuitas, 0, ',', '.') }}</b>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <span><b>Total (Liabilitas + Ekuitas)</b></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span><b>{{ 'Rp ' . number_format($totalKanan, 0, ',', '.') }}</b></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil elemen dropdown tahun
            var dropdownTahun = document.getElementById('tahun');

            // Tambahkan event listener untuk perubahan nilai dropdown
            dropdownTahun.addEventListener('change', function() {
                // Submit form saat nilai dropdown berubah
                this.closest('form').submit();
            });
        });
    </script>
@endsection
