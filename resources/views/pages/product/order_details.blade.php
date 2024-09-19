@extends('layouts.main')

@section('content')
    <div class="wrapper-table bg-white rounded ">
        <div class="card shadow ">
            <div class="card-header">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('product.order') }}">PO Barang</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $judul }}</li>
                    </ol>
                </nav>
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
            <div class="card shadow p-3">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 for="">{{ $order->supplier->name }}</h4>
                                <label class="small" for="">{{ $order->supplier->alamat }}</label><br>
                                <label class="small" for="">{{ $order->supplier->email }}</label><br>
                                <label class="small" for="">{{ $order->supplier->kontak }}</label><br>
                            </div>
                            <div class="col-sm-6 text-right">
                                <span for="" class="badge badge-dark ">No Order :
                                    {{ $order->no_order }}</span><br>
                                <span for="">Tanggal : {{ date('d F Y', strtotime($order->created_at)) }}</>
                                </span>
                            </div>
                            <div class="col">
                                <hr class="sidebar-divider">
                                <table class="table table-hover">
                                    <thead>
                                        <th>#</th>
                                        <th>Nama Barang</th>
                                        <th>Satuan</th>
                                        <th>Qty</th>
                                        <th class="text-right">@ Harga</th>
                                        <th class="text-right">Sub total</th>
                                    </thead>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $order->produk->nama_barang }}</td>
                                            <td>{{ $order->satuan }}</td>
                                            <td>{{ $order->qty }}</td>
                                            <td class="text-right">
                                                {{ 'Rp ' . number_format($order->harga, 0, ',', '.') }}
                                            </td>
                                            <td class="text-right">
                                                {{ 'Rp ' . number_format($order->sub_total, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tfoot>
                                        <td colspan="3" class="text-right">Total :</td>
                                        <td colspan="2">{{ $total->qty }}</td>

                                        <td class="text-right">
                                            {{ 'Rp ' . number_format($total->total_harga, 0, ',', '.') }}
                                        </td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 px-4 d-block justify-content-center align-content-center">
                        <a href="{{ route('invoice.order', $order->no_order) }}" class="btn btn-primary w-100"><i
                                class="fas fa-print"></i> Invoice</a>
                    </div>
                </div>


            </div>
        </div>
    @endsection
