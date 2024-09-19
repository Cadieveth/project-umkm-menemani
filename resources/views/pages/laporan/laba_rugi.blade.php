@extends('layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $judul }}</h1>
    </div>
    <form action="{{ route('lap.laba') }}" method="GET">
        <div class="wrapper-table bg-white rounded">
            <div class="card shadow">
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
                            <h6 class="text-uppercase"><b>{{ $setting->company_name }}</b></h6>
                            <h6 class="text-capitalize"><b>laporan laba rugi</b></h6>
                            <h6 class="text-capitalize"><b>Periode Akhir Desember <span>{{ $selectedYear }}</span></b></h6>
                        </div>
                        <div class="card-body mx-5">
                            <span class="text-capitalize"><b>pendapatan</b></span>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <span>Pendapatan Usaha</span>
                                </div>
                                <div class="col-sm-6">
                                    <span>{{ 'Rp ' . number_format($penjualan, 0, ',', '.') }}</span>
                                </div>
                                <div class="col-sm-6">
                                    <span>HPP</span>
                                </div>
                                <div class="col-sm-6">
                                    <span><u class="mt-2">
                                            {{ 'Rp ' . number_format($hpp, 0, ',', '.') }}</u>
                                        <sub>_</sub>
                                    </span>
                                </div>
                                <div class="col-sm-6">
                                    <span><b>Jumlah</b></span>
                                </div>
                                <div class="col-sm-6">
                                    <span><b>{{ 'Rp ' . number_format($pendapatan, 0, ',', '.') }}</b></span>
                                </div>
                            </div>
                            <span class="text-capitalize"><b>Beban</b></span>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <span>Beban Usaha</span>
                                </div>
                                <div class="col-sm-6">
                                    <span>{{ 'Rp ' . number_format($bebanUsaha, 0, ',', '.') }}</span>
                                </div>
                                <div class="col-sm-6">
                                    <span><b>Jumlah</b></span>
                                </div>
                                <div class="col-sm-6">
                                    <span><b>{{ 'Rp ' . number_format($bebanUsaha, 0, ',', '.') }}</b></span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <span>Pajak Penghasilan</span>
                                </div>
                                <div class="col-sm-6">
                                    <span><u class="mt-2">
                                            {{ 'Rp ' . number_format($pajak, 0, ',', '.') }}</u>
                                        <sub>-</sub>
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <span><b>Laba Rugi Setelah Pajak Penghasilan</b></span>
                                </div>
                                <div class="col-sm-6">
                                    <span><b>{{ 'Rp ' . number_format($labaRugi, 0, ',', '.') }}</b></span>
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
