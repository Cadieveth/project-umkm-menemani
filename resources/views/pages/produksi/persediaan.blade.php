@extends('layouts.main')

@section('content')
    <div class="wrapper-table bg-white rounded ">
        <div class="card shadow ">
            <div class="card-header">
                <h4 class="mb-2 font-weight-bold text-primary">{{ $judul }}</h4>

                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="card-body" id="tableStok">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Harga Pokok</th>
                            <th>Jumlah Produksi</th>
                            <th>Produksi Masuk</th>
                            <th>Produksi Keluar</th>
                            <th>Tanggal Produksi</th>
                        </tr>
                    </thead>
                    {{-- <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Harga Jual</th>
                            <th>Jumlah Produksi</th>
                            <th>Produksi Masuk</th>
                            <th>Produksi Keluar</th>
                            <th>Tanggal Produksi</th>
                        </tr>
                    </tfoot> --}}
                    <tbody>
                        @foreach ($products as $produk)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $produk->kode_product }}</td>
                                <td>{{ $produk->nama_product }}</td>
                                <td>{{ 'Rp ' . number_format($produk->hpp, 0, ',', '.') }}</td>
                                {{-- <td>
                                    {{ 'Rp ' . number_format($produk->harga_jual, 0, ',', '.') }}
                                </td> --}}
                                <td>
                                    @php
                                        $qtyIn = $produk->qty_in;
                                        $qtyOut = $produk->qty_out;
                                    @endphp
                                    {{ $qtyIn - $qtyOut }}
                                </td>
                                <td>{{ $qtyIn }}</td>
                                <td>{{ $qtyOut }}</td>
                                <td>{{ $produk->created_at }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
