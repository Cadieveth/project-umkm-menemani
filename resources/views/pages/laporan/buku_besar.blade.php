@extends('layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $judul }}</h1>
    </div>

    <form action="{{ route('lap.neraca') }}" method="GET">
        <div class="wrapper-table bg-white rounded ">
            <div class="card shadow ">

                <div class="card-body">
                    <div class="card">
                        <div class="card-header text-center">
                            <h6 class="text-uppercase "><b>{{ $setting->company_name }}</b></h6>
                            <h6 class="text-capitalize"><b>laporan buku besar</b></h6>
                        </div>
                        <div class="card-body">
                            <div class="card p-2">
                                <ul class="nav nav-pills mb-3 mt-2" id="pills-tab" role="tablist">
                                    {{-- Kas  --}}
                                    <li class="nav-item mr-3 ml-3" role="presentation">
                                        <button class="nav-link active btn-sm" id="pills-home-tab" data-toggle="pill"
                                            data-target="#pills-home" type="button" role="tab"
                                            aria-controls="pills-home" aria-selected="true">Kas</button>
                                    </li>
                                    {{-- PBB  --}}
                                    <li class="nav-item mr-3" role="presentation">
                                        <button class="nav-link btn-sm" id="pills-pbb-tab" data-toggle="pill"
                                            data-target="#pills-pbb" type="button" role="tab" aria-controls="pills-pbb"
                                            aria-selected="false">Bahan Baku</button>
                                    </li>
                                    {{-- PPJ --}}
                                    <li class="nav-item mr-3" role="presentation">
                                        <button class="nav-link btn-sm" id="pills-beli-tab" data-toggle="pill"
                                            data-target="#pills-beli" type="button" role="tab"
                                            aria-controls="pills-beli" aria-selected="false">Produk Jadi</button>
                                    </li>
                                    {{-- Aset --}}
                                    <li class="nav-item mr-3" role="presentation">
                                        <button class="nav-link btn-sm" id="pills-aset-tab" data-toggle="pill"
                                            data-target="#pills-aset" type="button" role="tab"
                                            aria-controls="pills-aset" aria-selected="false">Peralatan</button>
                                    </li>
                                    {{-- Penjualan  --}}
                                    <li class="nav-item mr-3" role="presentation">
                                        <button class="nav-link btn-sm" id="pills-profile-tab" data-toggle="pill"
                                            data-target="#pills-profile" type="button" role="tab"
                                            aria-controls="pills-profile" aria-selected="false">Penjualan</button>
                                    </li>
                                    {{-- HPP  --}}
                                    <li class="nav-item mr-3" role="presentation">
                                        <button class="nav-link btn-sm" id="pills-hpp-tab" data-toggle="pill"
                                            data-target="#pills-hpp" type="button" role="tab" aria-controls="pills-hpp"
                                            aria-selected="false">HPP</button>
                                    </li>
                                    {{-- Beban  --}}
                                    <li class="nav-item mr-3" role="presentation">
                                        <button class="nav-link btn-sm" id="pills-contact-tab" data-toggle="pill"
                                            data-target="#pills-contact" type="button" role="tab"
                                            aria-controls="pills-contact" aria-selected="false">Beban</button>
                                    </li>
                                    {{-- Hutang Gaji --}}
                                    <li class="nav-item mr-3" role="presentation">
                                        <button class="nav-link btn-sm" id="pills-hg-tab" data-toggle="pill"
                                            data-target="#pills-hg" type="button" role="tab" aria-controls="pills-hg"
                                            aria-selected="false">Hutang</button>
                                    </li>
                                    {{-- Hutang Gaji --}}
                                    <li class="nav-item mr-3" role="presentation">
                                        <button class="nav-link btn-sm" id="pills-akm-tab" data-toggle="pill"
                                            data-target="#pills-akm" type="button" role="tab"
                                            aria-controls="pills-akm" aria-selected="false">Akm. Penyusutan
                                            Peralatan</button>
                                    </li>
                                    {{-- BTKL --}}
                                    {{-- <li class="nav-item" role="presentation">
                                        <button class="nav-link btn-sm" id="pills-btkl-tab" data-toggle="pill"
                                            data-target="#pills-btkl" type="button" role="tab"
                                            aria-controls="pills-btkl" aria-selected="false">BTKL</button>
                                    </li> --}}
                                </ul>
                                <div class="card-body">
                                    <div class="tab-content" id="pills-tabContent">
                                        {{-- kas  --}}
                                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                            aria-labelledby="pills-home-tab">
                                            <table class="table table-responsive-lg">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th scope="col">Tanggal</th>
                                                        <th scope="col">Keterangan</th>
                                                        <th scope="col">Referensi</th>
                                                        <th scope="col">Akun</th>
                                                        <th scope="col">Debit</th>
                                                        <th scope="col">Kredit</th>
                                                        <th scope="col">Saldo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $color = ''; // Nilai warna untuk saldo
                                                        $modalAwal = $modalAwal; // Nilai modal awal dari controller
                                                        $masterName = $masters->pluck('name')->toArray();
                                                    @endphp
                                                    <tr>
                                                        <td></td>
                                                        <td>Saldo Awal Kas</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-success">
                                                            {{ 'Rp ' . number_format($modalAwal, 0, ',', '.') }}</td>
                                                    </tr>
                                                    @foreach ($laporans as $lap)
                                                        @php
                                                            // Update nilai modal berdasarkan debit atau kredit
                                                            if ($lap->akun_debet == 'Kas') {
                                                                $modalAwal += $lap->debit;
                                                                $color = 'text-success';
                                                            } elseif (
                                                                $lap->akun_kredit == 'Kas' ||
                                                                $lap->akun_debet == 'Penjualan' ||
                                                                in_array($lap->akun_debet, $masterName)
                                                            ) {
                                                                $modalAwal -= $lap->kredit;
                                                                $color = 'text-danger';
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td>{{ date('d/M/Y', strtotime($lap->created_at)) }}</td>
                                                            <td>{{ $lap->ket }}</td>
                                                            <td>{{ $lap->no_jurnal }}</td>
                                                            <td>{{ $lap->akun_debet }}</td>
                                                            @if ($lap->akun_debet == 'Kas')
                                                                <td class="text-success">
                                                                    {{ 'Rp ' . number_format($lap->debit, 0, ',', '.') }}
                                                                </td>
                                                                <td>Rp. 0</td>
                                                            @elseif ($lap->akun_debet == 'Penjualan' || $lap->akun_kredit == 'Kas' || in_array($lap->akun_debet, $masterName))
                                                                <td>Rp. 0</td>
                                                                <td class="text-danger">
                                                                    {{ 'Rp ' . number_format($lap->kredit, 0, ',', '.') }}
                                                                </td>
                                                            @endif
                                                            <td class="{{ $color }}">
                                                                {{ 'Rp ' . number_format($modalAwal, 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- penjualan  --}}
                                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                            aria-labelledby="pills-profile-tab">
                                            <table class="table table-responsive-lg">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th scope="col">Tanggal</th>
                                                        <th scope="col">Keterangan</th>
                                                        <th scope="col">Referensi</th>
                                                        <th scope="col">Debit</th>
                                                        <th scope="col">Kredit</th>
                                                        <th scope="col">Saldo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $modalAwal = 0; // Nilai modal awal
                                                    @endphp
                                                    <tr>
                                                        <td></td>
                                                        <td>Saldo Awal Penjualan</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            {{ 'Rp ' . number_format($modalAwal, 0, ',', '.') }}</td>
                                                    </tr>
                                                    @foreach ($penjualan as $lap)
                                                        @php
                                                            // Update nilai modal berdasarkan debit atau kredit
                                                            if (
                                                                $lap->akun_debet == 'Penjualan' ||
                                                                $lap->akun_debet == 'Kas'
                                                            ) {
                                                                $modalAwal += $lap->debit;
                                                                $color = 'text-success';
                                                            } elseif ($lap->akun_kredit == 'Kas') {
                                                                $modalAwal -= $lap->kredit;
                                                                $color = 'text-danger';
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td>{{ date('d/M/Y', strtotime($lap->created_at)) }}</td>
                                                            <td>{{ $lap->ket }}</td>
                                                            <td>{{ $lap->no_jurnal }}</td>
                                                            @if ($lap->akun_debet == 'Penjualan' || $lap->akun_debet == 'Kas')
                                                                <td>Rp. 0</td>
                                                                <td class="{{ $color }}">
                                                                    {{ 'Rp ' . number_format($lap->debit, 0, ',', '.') }}
                                                                </td>
                                                            @endif

                                                            <td class="{{ $color }}">
                                                                {{ 'Rp ' . number_format($modalAwal, 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- persediaan bahan baku  --}}
                                        <div class="tab-pane fade" id="pills-pbb" role="tabpanel"
                                            aria-labelledby="pills-pbb-tab">
                                            <table class="table table-responsive-lg">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th scope="col">Tanggal</th>
                                                        <th scope="col">Keterangan</th>
                                                        <th scope="col">Referensi</th>
                                                        <th scope="col">Debit</th>
                                                        <th scope="col">Kredit</th>
                                                        <th scope="col">Saldo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td>Saldo Awal Persediaan Bahan Baku</td>
                                                        <td colspan="3"></td>
                                                        <td class="text-success">
                                                            {{ $awalPbb ? 'Rp ' . number_format($awalPbb->debit, 0, ',', '.') : 'Data tidak ditemukan' }}
                                                        </td>
                                                    </tr>
                                                    @php
                                                        // Inisialisasi saldo awal dengan nilai debit dari objek $awalPbb jika tersedia
                                                        $saldo = $awalPbb ? $awalPbb->debit : 0;
                                                    @endphp
                                                    @foreach ($mergePbb as $dataPbb)
                                                        @php
                                                            // Debugging untuk memastikan data yang benar
                                                            // dd($dataPbb);

                                                            // Tentukan apakah transaksi ini adalah debit atau kredit
                                                            $isDebit =
                                                                isset($dataPbb->debit) &&
                                                                $dataPbb->akun_debet == 'Persediaan Bahan Baku';
                                                            $isKredit =
                                                                isset($dataPbb->kredit) &&
                                                                $dataPbb->akun_kredit == 'Persediaan Bahan Baku';
                                                            $isNett = isset($dataPbb->bahanBakuNettTotal); // Periksa apakah bahanBakuNettTotal ada

                                                            // Hitung saldo berdasarkan nilai debit atau kredit
                                                            if ($isDebit) {
                                                                $saldo += $dataPbb->debit;
                                                                $color = 'text-success';
                                                            } elseif ($isKredit) {
                                                                $saldo -=
                                                                    $dataPbb->bahanBakuNettTotal ?? $dataPbb->kredit; // Gunakan bahanBakuNettTotal jika ada
                                                                $color = 'text-danger';
                                                            }

                                                        @endphp
                                                        <tr>
                                                            <td>{{ date('d/M/Y', strtotime($dataPbb->created_at)) }}</td>
                                                            <td>{{ $dataPbb->ket }}</td>
                                                            <td>{{ $dataPbb->no_jurnal }}</td>
                                                            <td class="{{ $color }}">
                                                                {{ $isDebit ? 'Rp ' . number_format($dataPbb->debit, 0, ',', '.') : '-' }}
                                                            </td>
                                                            <td class="{{ $color }}">
                                                                {{ $isKredit ? 'Rp ' . number_format($dataPbb->bahanBakuNettTotal ?? $dataPbb->kredit, 0, ',', '.') : '-' }}
                                                            </td>
                                                            <td class="{{ $saldo < 0 ? 'text-danger' : 'text-success' }}">
                                                                {{ 'Rp ' . number_format($saldo, 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>

                                            </table>
                                        </div>
                                        {{-- persediaan produk jadi  --}}
                                        <div class="tab-pane fade" id="pills-beli" role="tabpanel"
                                            aria-labelledby="pills-beli-tab">
                                            <table class="table table-responsive-lg">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th scope="col">Tanggal</th>
                                                        <th scope="col">Keterangan</th>
                                                        <th scope="col">Referensi</th>
                                                        <th scope="col">Debit</th>
                                                        <th scope="col">Kredit</th>
                                                        <th scope="col">Saldo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Tampilkan Saldo Awal Persediaan Produk Jadi -->
                                                    <tr>
                                                        <td></td>
                                                        <td>Saldo Awal Persediaan Produk Jadi</td>
                                                        <td colspan="3"></td>
                                                        <td class="text-success">
                                                            {{ $awalPpj ? 'Rp ' . number_format($awalPpj->debit, 0, ',', '.') : 'Data tidak ditemukan' }}
                                                        </td>
                                                    </tr>
                                                    @php
                                                        // Inisialisasi saldo awal dengan nilai debit dari objek $awalPpj jika tersedia
                                                        $saldo = $awalPpj ? $awalPpj->debit : 0;
                                                    @endphp
                                                    @foreach ($ppj as $dataPpj)
                                                        @php
                                                            // Tentukan apakah debit atau kredit menggunakan pengecekan yang lebih fleksibel
                                                            $isDebit = str_contains(
                                                                $dataPpj->akun_debet,
                                                                'Persediaan Barang Jadi',
                                                            );
                                                            $isKredit = str_contains(
                                                                $dataPpj->akun_persediaan,
                                                                'Persediaan Barang Jadi',
                                                            );

                                                            // Perbarui saldo berdasarkan apakah entri adalah debit atau kredit
                                                            if ($isDebit) {
                                                                $saldo += $dataPpj->debit;
                                                                $color = 'text-success';
                                                            } elseif ($isKredit) {
                                                                $saldo -= $dataPpj->persediaan; // Menggunakan $dataPpj->persediaan
                                                                $color = 'text-danger';
                                                            }
                                                        @endphp

                                                        <tr>
                                                            <td>{{ date('d/M/Y', strtotime($dataPpj->created_at)) }}</td>
                                                            <td>{{ $dataPpj->ket }}</td>
                                                            <td>{{ $dataPpj->no_jurnal }}</td>
                                                            <td class="{{ $color }}">
                                                                {{ $isDebit ? 'Rp ' . number_format($dataPpj->debit, 0, ',', '.') : '-' }}
                                                            </td>
                                                            <td class="{{ $color }}">
                                                                {{ $isKredit ? 'Rp ' . number_format($dataPpj->persediaan, 0, ',', '.') : '-' }}
                                                            </td>
                                                            <td class="{{ $saldo < 0 ? 'text-danger' : 'text-success' }}">
                                                                {{ 'Rp ' . number_format($saldo, 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>

                                            </table>
                                        </div>
                                        {{-- persediaan produk jadi  --}}
                                        <div class="tab-pane fade" id="pills-aset" role="tabpanel"
                                            aria-labelledby="pills-aset-tab">
                                            <table class="table table-responsive-lg">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th scope="col">Tanggal</th>
                                                        <th scope="col">Keterangan</th>
                                                        <th scope="col">Referensi</th>
                                                        <th scope="col">Debit</th>
                                                        <th scope="col">Kredit</th>
                                                        <th scope="col">Saldo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Tampilkan Saldo Awal Persediaan Produk Jadi -->
                                                    <tr>
                                                        <td></td>
                                                        <td>Saldo Awal Peralatan</td>
                                                        <td colspan="3"></td>
                                                        <td class="text-success">
                                                            {{ $awalAset ? 'Rp ' . number_format($awalAset->debit, 0, ',', '.') : 'Data tidak ditemukan' }}
                                                        </td>
                                                    </tr>
                                                    @php
                                                        // Inisialisasi saldo awal dengan nilai debit dari objek $awalPpj jika tersedia
                                                        $saldo = $awalAset ? $awalAset->debit : 0;
                                                    @endphp
                                                    {{-- @foreach ($ppj as $dataPpj)
                                                        @php
                                                            // Tentukan apakah debit atau kredit menggunakan pengecekan yang lebih fleksibel
                                                            $isDebit = str_contains(
                                                                $dataPpj->akun_debet,
                                                                'Persediaan Barang Jadi',
                                                            );
                                                            $isKredit = str_contains(
                                                                $dataPpj->akun_persediaan,
                                                                'Persediaan Barang Jadi',
                                                            );

                                                            // Perbarui saldo berdasarkan apakah entri adalah debit atau kredit
                                                            if ($isDebit) {
                                                                $saldo += $dataPpj->debit;
                                                                $color = 'text-success';
                                                            } elseif ($isKredit) {
                                                                $saldo -= $dataPpj->persediaan; // Menggunakan $dataPpj->persediaan
                                                                $color = 'text-danger';
                                                            }
                                                        @endphp

                                                        <tr>
                                                            <td>{{ date('d/M/Y', strtotime($dataPpj->created_at)) }}</td>
                                                            <td>{{ $dataPpj->ket }}</td>
                                                            <td>{{ $dataPpj->no_jurnal }}</td>
                                                            <td class="{{ $color }}">
                                                                {{ $isDebit ? 'Rp ' . number_format($dataPpj->debit, 0, ',', '.') : '-' }}
                                                            </td>
                                                            <td class="{{ $color }}">
                                                                {{ $isKredit ? 'Rp ' . number_format($dataPpj->persediaan, 0, ',', '.') : '-' }}
                                                            </td>
                                                            <td class="{{ $saldo < 0 ? 'text-danger' : 'text-success' }}">
                                                                {{ 'Rp ' . number_format($saldo, 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach --}}

                                                </tbody>

                                            </table>
                                        </div>
                                        {{-- hpp  --}}
                                        <div class="tab-pane fade" id="pills-hpp" role="tabpanel"
                                            aria-labelledby="pills-hpp-tab">
                                            <table class="table table-responsive-lg">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th scope="col">Tanggal</th>
                                                        <th scope="col">Keterangan</th>
                                                        <th scope="col">Referensi</th>
                                                        <th scope="col">Debit</th>
                                                        <th scope="col">Kredit</th>
                                                        <th scope="col">Saldo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td>Saldo Awal Harga Pokok Penjualan</td>
                                                        <td colspan="3"></td>
                                                        <td class="text-success">
                                                            {{ 'Rp ' . number_format(0, 0, ',', '.') }}
                                                        </td>
                                                    </tr>
                                                    @php
                                                        // Inisialisasi saldo awal dengan nilai debit dari objek $awalPpj jika tersedia
                                                        $saldo = 0;
                                                    @endphp
                                                    @foreach ($hpp as $hpp)
                                                        @php
                                                            if ($hpp->akun_hpp == 'HPP') {
                                                                $saldo += $hpp->hpp; // Dikurangi
                                                                $color = 'text-danger'; // Warna merah karena dianggap rugi (nilai negatif)
                                                            } else {
                                                                $saldo -= $hpp->hpp; // Ditambah
                                                                $color = 'text-success'; // Warna hijau untuk keuntungan (positif)
                                                            }
                                                            $color = $saldo < 0 ? 'text-danger' : 'text-success';
                                                        @endphp
                                                        <tr>
                                                            <td>{{ date('d/M/Y', strtotime($hpp->created_at)) }}</td>
                                                            <td>{{ $hpp->ket }}</td>
                                                            <td>{{ $hpp->no_jurnal }}</td>
                                                            <td class="text-success">
                                                                {{ 'Rp ' . number_format($hpp->hpp, 0, ',', '.') }}
                                                            </td>
                                                            <td>Rp 0</td>
                                                            <td class="{{ $color }}">
                                                                {{ 'Rp ' . number_format($saldo, 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- beban  --}}
                                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                            aria-labelledby="pills-contact-tab">
                                            <table class="table table-responsive-lg">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th scope="col">Tanggal</th>
                                                        <th scope="col">Keterangan</th>
                                                        <th scope="col">Referensi</th>
                                                        <th scope="col">Debit</th>
                                                        <th scope="col">Kredit</th>
                                                        <th scope="col">Saldo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $modalAwal = 0; // Nilai modal awal
                                                    @endphp
                                                    <tr>
                                                        <td></td>
                                                        <td>Saldo Awal Beban</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            {{ 'Rp ' . number_format($modalAwal, 0, ',', '.') }}</td>
                                                    </tr>
                                                    @foreach ($beban as $lap)
                                                        @php
                                                            if ($lap->akun_debet == 'Beban') {
                                                                $modalAwal += $lap->debit;
                                                                $color = 'text-danger';
                                                            } else {
                                                                $modalAwal += $lap->debit;
                                                                $color = 'text-success';
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td>{{ date('d/M/Y', strtotime($lap->created_at)) }}</td>
                                                            <td>{{ $lap->akun_debet }}</td>
                                                            <td>{{ $lap->no_jurnal }}</td>
                                                            <td class="{{ $color }}">
                                                                {{ 'Rp ' . number_format($lap->debit, 0, ',', '.') }}
                                                            </td>
                                                            <td>Rp. 0</td>
                                                            <td class="{{ $color }}">
                                                                {{ 'Rp ' . number_format($modalAwal, 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- hutang  --}}
                                        <div class="tab-pane fade" id="pills-hg" role="tabpanel"
                                            aria-labelledby="pills-hg-tab">
                                            <table class="table table-responsive-lg">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th scope="col">Tanggal</th>
                                                        <th scope="col">Keterangan</th>
                                                        <th scope="col">Referensi</th>
                                                        <th scope="col">Debit</th>
                                                        <th scope="col">Kredit</th>
                                                        <th scope="col">Saldo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $modalAwal = $awalHutang->kredit ?? 0;
                                                    @endphp

                                                    <tr>
                                                        <td></td>
                                                        <td>Saldo Awal Hutang Gaji</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            {{ 'Rp ' . number_format($modalAwal, 0, ',', '.') }}</td>
                                                    </tr>
                                                    @foreach ($hutang as $data)
                                                        @php
                                                            if ($data->akun_debet == 'Hutang Gaji') {
                                                                $modalAwal -= $data->debit;
                                                                $color = 'text-danger';
                                                            } else {
                                                                $modalAwal += $data->kredit;
                                                                $color = 'text-success';
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td>{{ date('d/M/Y', strtotime($data->created_at)) }}</td>
                                                            <td>{{ $data->ket }}</td>
                                                            <td>{{ $data->no_jurnal }}</td>
                                                            @if ($data->akun_kredit == 'Hutang Gaji')
                                                                <td>Rp 0</td>
                                                                <td class="{{ $color }}">
                                                                    {{ 'Rp ' . number_format($data->kredit, 0, ',', '.') }}
                                                                </td>
                                                            @elseif ($data->akun_debet == 'Hutang Gaji')
                                                                <td class="{{ $color }}">
                                                                    {{ 'Rp ' . number_format($data->debit, 0, ',', '.') }}
                                                                </td>
                                                                <td>Rp 0</td>
                                                            @endif
                                                            <td class="{{ $color }}">
                                                                {{ 'Rp ' . number_format($modalAwal, 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- hutang  --}}
                                        <div class="tab-pane fade" id="pills-akm" role="tabpanel"
                                            aria-labelledby="pills-akm-tab">
                                            <table class="table table-responsive-lg">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th scope="col">Tanggal</th>
                                                        <th scope="col">Keterangan</th>
                                                        <th scope="col">Referensi</th>
                                                        <th scope="col">Debit</th>
                                                        <th scope="col">Kredit</th>
                                                        <th scope="col">Saldo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $modalAwal = 0;
                                                    @endphp

                                                    <tr>
                                                        <td></td>
                                                        <td>Saldo Awal Akm. Penyusutan Peralatan</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            {{ 'Rp ' . number_format($modalAwal, 0, ',', '.') }}</td>
                                                    </tr>
                                                    @foreach ($akm as $data)
                                                        @php
                                                            if (
                                                                $data->akun_kredit == 'Akumulasi Penyusutan Peralatan'
                                                            ) {
                                                                $modalAwal += $data->kredit;
                                                                $color = 'text-success';
                                                            } else {
                                                                $modalAwal -= $data->debit;
                                                                $color = 'text-danger';
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td>{{ date('d/M/Y', strtotime($data->created_at)) }}</td>
                                                            <td>{{ $data->ket }}</td>
                                                            <td>{{ $data->no_jurnal }}</td>
                                                            @if ($data->akun_kredit == 'Akumulasi Penyusutan Peralatan')
                                                                <td>Rp 0</td>
                                                                <td class="{{ $color }}">
                                                                    {{ 'Rp ' . number_format($data->kredit, 0, ',', '.') }}
                                                                </td>
                                                            @elseif ($data->akun_debet == 'Akumulasi Penyusutan Peralatan')
                                                                <td class="{{ $color }}">
                                                                    {{ 'Rp ' . number_format($data->debit, 0, ',', '.') }}
                                                                </td>
                                                                <td>Rp 0</td>
                                                            @endif
                                                            <td class="{{ $color }}">
                                                                {{ 'Rp ' . number_format($modalAwal, 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- btkl  --}}
                                        {{-- <div class="tab-pane fade" id="pills-btkl" role="tabpanel"
                                            aria-labelledby="pills-btkl-tab">
                                            <table class="table table-responsive-lg">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th scope="col">Tanggal</th>
                                                        <th scope="col">Keterangan</th>
                                                        <th scope="col">Referensi</th>
                                                        <th scope="col">Debit</th>
                                                        <th scope="col">Kredit</th>
                                                        <th scope="col">Saldo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $modalAwal = 0; // Nilai modal awal
                                                    @endphp
                                                    <tr>
                                                        <td></td>
                                                        <td>Saldo Awal Biaya Tenaga Kerja Langsung</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            {{ 'Rp ' . number_format($modalAwal, 0, ',', '.') }}</td>
                                                    </tr>
                                                    @foreach ($btkl as $data)
                                                        @php
                                                            if ($data->akun_debet == 'Biaya Tenaga Kerja Langsung') {
                                                                $modalAwal += $data->debit;
                                                                $color = 'text-success';
                                                            } else {
                                                                $modalAwal -= $data->kredit;
                                                                $color = 'text-danger';
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td>{{ date('d/M/Y', strtotime($data->created_at)) }}</td>
                                                            <td>{{ $data->ket }}</td>
                                                            <td>{{ $data->no_jurnal }}</td>
                                                            <td class="text-success">
                                                                {{ 'Rp ' . number_format($data->debit, 0, ',', '.') }}
                                                            </td>
                                                            <td>Rp. 0</td>
                                                            <td class="text-success">
                                                                {{ 'Rp ' . number_format($modalAwal, 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div> --}}
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
        $(document).ready(function() {
            $('#pills-tab button').on('click', function(e) {
                e.preventDefault();
                $(this).tab('show');
            });
        });
    </script>
@endsection
