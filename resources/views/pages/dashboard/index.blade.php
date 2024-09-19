@extends('layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xl font-weight-bold text-success text-uppercase mb-1">
                                Earnings (Annual)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ 'Rp ' . number_format($currance->total, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">
                                Total Bahan Baku</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $totalBaku->totalBaku }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">
                                Total Produk</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $totalProduk->totalProduk }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->


        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xl font-weight-bold text-info text-uppercase mb-1">Total Supplier
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h4 mb-0 mr-3 font-weight-bold text-gray-800">{{ $supplier->total }}</div>
                                </div>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card shadow mb-3">
                <div class="card-header">
                    <h5 class="mb-2 font-weight-bold text-primary">Informasi Stok</h5>
                </div>
                <table class="table table-hover">
                    <thead>
                        <th>Nama Barang</th>
                        <th>Sisa Stok</th>
                        <th>Status</th>
                    </thead>
                    @foreach ($stok as $stok)
                        @php
                            $id_stok = $stok->id;
                            $totalStokMasuk = $stok->stokMasuk->sum('stok_masuk');
                            $totalStokKeluar = $stok->stokKeluar->sum('stok_keluar');
                            $stoks = $totalStokMasuk - $totalStokKeluar;
                            $sto = intval($stoks);
                        @endphp

                        @if ($sto == 0)
                            <div></div>
                        @else
                            <tr>
                                <td>{{ $stok->name }}</td>
                                <td>
                                    {{ $sto }}
                                </td>
                                <td>
                                    @if ($sto >= 10 && $sto <= 30)
                                        <span class="badge badge-warning">Stok Menipis
                                        @elseif($sto < 10)
                                            <span class="badge badge-danger"><b>Segera Order Stok</b>
                                            </span>
                                        @else
                                            <span class="badge badge-primary"><b>Stok Normal</b>
                                            </span>
                                    @endif
                                </td>

                            </tr>
                        @endif
                    @endforeach
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-center"><a href="{{ route('product') }}" class=""> >> Liat
                                    Semua Stok</a></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card shadow mb-3">
                <div class="card-header">
                    <h5 class="mb-2 font-weight-bold text-success">Transaksi History</h5>
                </div>
                <table class="table table-hover">
                    <thead>
                        <th>#</th>
                        <th>Nomor Transaksi</th>
                        <th>Income</th>
                        <th>Datetime</th>
                    </thead>
                    @foreach ($transaksi as $tr)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $tr->no_transaksi }}</td>
                            <td> {{ 'Rp ' . number_format($tr->total, 0, ',', '.') }}
                            </td>
                            <td>{{ $tr->created_at }}</td>
                        </tr>
                    @endforeach
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-center"><a href="{{ route('transaksi') }}" class=""> >>
                                    Liat
                                    Semua Transaksi</a></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-2 font-weight-bold text-success">Barang Masuk</h5>
                </div>
                <table class="table table-hover">
                    <thead>
                        <th>#</th>
                        <th>Supplier</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Datetime</th>
                    </thead>
                    @foreach ($stok_masuk as $masuk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $masuk->supplier->name }}</td>
                            <td>{{ $masuk->baku->name }}</td>
                            <td>{{ $masuk->stok_masuk }}</td>
                            <td>{{ $masuk->created_at }}</td>
                        </tr>
                    @endforeach
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-center"><a href="{{ route('product.masuk') }}" class="">
                                    >> Liat Semua
                                    Stok Masuk</a></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-2 font-weight-bold text-danger">Barang Keluar</h5>
                </div>
                <table class="table table-hover">
                    <thead>
                        <th>#</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Keterangan</th>
                        <th>Datetime</th>
                    </thead>
                    @foreach ($stok_keluar as $keluar)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $keluar->baku->name }}</td>
                            <td>{{ $keluar->stok_keluar }}</td>
                            <td>{{ $keluar->keterangan }}</td>
                            <td>{{ $keluar->created_at }}</td>
                        </tr>
                    @endforeach
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-center"><a href="{{ route('product.keluar') }}" class="">
                                    >> Liat Semua
                                    Stok Keluar</a></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
