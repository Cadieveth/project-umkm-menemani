@extends('layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $judul }}</h1>
    </div>
    <form action="{{ route('lap.modal') }}" method="GET">

        <div class="wrapper-table bg-white rounded ">
            <div class="card shadow ">
                <div class="card-header">
                    <div class="input-group flex-nowrap w-25">
                        {{-- <select id="tahun" name="tahun" class="btn btn-primary">
                            <option selected disabled class="text-white">-- Pilih Tahun --</option>
                            @foreach ($tahun as $tahunItem)
                                <option value="{{ $tahunItem }}">{{ $tahunItem }}</option>
                            @endforeach
                        </select> --}}
                        <select id="bulan_tahun" name="bulan_tahun" class="btn btn-primary ml-2">
                            <option selected disabled class="text-white">-- Pilih Bulan --</option>
                            @foreach ($bulanTahun as $item)
                                <option value="{{ $item->bulanTahun }}"
                                    {{ $selectedBulanTahun == $item->bulanTahun ? 'selected' : '' }}>
                                    {{ $item->bulanTahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card">
                        {{-- <div class="card-header text-center">
                            <h6 class="text-uppercase "><b>{{ $setting->company_name }}</b></h6>
                            <h6 class="text-capitalize"><b>laporan Perubahan modal</b></h6>
                            <h6 class="text-capitalize"><b>Periode Akhir Desember {{ $selectedYear }}</b></h6>
                        </div> --}}
                        <div class="card-header text-center">
                            <h6 class="text-uppercase"><b>{{ $setting->company_name }}</b></h6>
                            <h6 class="text-capitalize"><b>laporan Perubahan modal</b></h6>
                            <h6 class="text-capitalize"><b>Periode Akhir {{ $selectedBulanTahun }}</b></h6>
                        </div>
                        <div class="card-body mx-5">
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <span>Modal Awal</span>
                                </div>
                                <div class="col-sm-4">
                                    <span></span>
                                </div>
                                <div class="col-sm-4">
                                    <span>{{ 'Rp ' . number_format($saldoModal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <span class="text-capitalize"><b>Penambahan Modal</b></span>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <span>Laba Bersih</span>
                                </div>

                                <div class="col-sm-6">
                                    <span>{{ 'Rp ' . number_format($labaRugi, 0, ',', '.') }}</span>

                                </div>
                                <div class="col-sm-6">
                                    <span>Prive</span>
                                </div>
                                <div class="col-sm-6">
                                    <span>{{ 'Rp ' . number_format(0, 0, ',', '.') }}</span>
                                </div>
                                <div class="col-sm-6">
                                    <span>Laba ditahan</span>
                                </div>
                                <div class="col-sm-6">
                                    <span>{{ 'Rp ' . number_format(0, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <span>Total</span>
                                </div>
                                <div class="col-sm-4">
                                    <span></span>
                                </div>
                                <div class="col-sm-4">
                                    <span><u class="mt-2">
                                            <b>{{ 'Rp ' . number_format($total, 0, ',', '.') }}</b></u>
                                        <sub>-</sub>
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <span><b>Modal Akhir</b></span>
                                </div>
                                <div class="col-sm-4">
                                    <span></span>
                                </div>
                                <div class="col-sm-4">
                                    <span><b>{{ 'Rp ' . number_format($modalAkhir, 0, ',', '.') }}</b></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil elemen dropdown tahun
            var dropdownTahun = document.getElementById('tahun');

            // Tambahkan event listener untuk perubahan nilai dropdown
            dropdownTahun.addEventListener('change', function() {
                // Submit form saat nilai dropdown berubah
                this.closest('form').submit();
            });
        });
    </script> --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil elemen dropdown bulan_tahun
            var dropdownBulanTahun = document.getElementById('bulan_tahun');

            // Tambahkan event listener untuk perubahan nilai dropdown
            dropdownBulanTahun.addEventListener('change', function() {
                // Submit form saat nilai dropdown berubah
                this.closest('form').submit();
            });
        });
    </script>
@endsection
