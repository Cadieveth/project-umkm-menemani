@extends('layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>

    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xl font-weight-bold text-success text-uppercase mb-1">
                                Total Produksi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalProduk->totalProduk }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">
                                Total Resep</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $resep->total }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pending Requests Card Example -->
    </div>
    <div class="card shadow mb-3">
        <div class="card-header">
            <h5 class="mb-2 font-weight-bold text-primary">Informasi Produk</h5>
        </div>
        <table class="table table-hover">
            <thead>
                <th>#</th>
                <th>Tanggal Produksi</th>
                <th>Nama Barang</th>
                <th>Sisa Stok</th>
                <th>Status</th>
            </thead>
            @foreach ($stokpro as $stok)
                @php
                    $qtyIn = $stok->qty_in;
                    $qtyOut = $stok->qty_out;
                    $sto = $qtyIn - $qtyOut;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $stok->created_at }}</td>
                    <td>{{ $stok->nama_product }}</td>
                    <td>
                        {{ $sto }}
                    </td>
                    <td>
                        @if ($sto >= 10 && $sto <= 30)
                            <span class="badge badge-warning"><b>Stok Menipis</b>
                            </span>
                        @elseif($sto < 10)
                            <span class="badge badge-danger"><b>Stok Habis</b>
                            </span>
                        @else
                            <span class="badge badge-success"><b>Stok Tersedia</b>
                            </span>
                        @endif
                    </td>
                </tr>
            @endforeach
            <tfoot>
                <tr>
                    <td colspan="6" class="text-center"><a href="{{ route('persediaan') }}" class=""> >> Liat
                            Semua Stok</a></td>
                </tr>
            </tfoot>
        </table>

    </div>
@endsection
