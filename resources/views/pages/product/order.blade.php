@extends('layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $judul }}</h1>
    </div>

    <div class="wrapper-table bg-white rounded ">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-2 font-weight-bold"><a href="#" data-toggle="modal" data-target="#orderModal"
                        class="btn btn-primary ">+ Orderan</a></h6>

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

            <div class="card-body" id="tableStok">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal Order</th>
                                <th>Nomor Orderan</th>
                                <th>Jumlah Barang</th>
                                <th>Qty</th>
                                <th>Supplier</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Tanggal Order</th>
                                <th>Nomor Orderan</th>
                                <th>Jumlah Barang</th>
                                <th>Qty</th>
                                <th>Supplier</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ date('d F Y', strtotime($order->tgl_order)) }}</td>
                                    <td>{{ $order->no_order }}</td>
                                    <td>{{ $order->jml_produk }}</td>
                                    <td>{{ $order->qty }}</td>
                                    <td>{{ $order->supplier->name }}</td>
                                    <td><a href="{{ route('order.details', $order->no_order) }}"
                                            class="btn btn-primary btn-circle btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('order.delete', $order->no_order) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-sm btn-circle btn-danger"
                                                onclick="return confirm('Anda Yakin Akan Menghapus Data Ini ?')"
                                                type="submit">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Data Orderan</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row ">
                            <div class="col-sm-5">
                                <form id="formOrder" action="{{ route('order.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card shadow mb-4">
                                        <!-- Card Header - Accordion -->
                                        <div class="col-md-12 mt-2 mb-4 mp-2">
                                            <label for="inputState"
                                                class="form-label ml-1 font-weight-bold text-primary">Supplier</label>
                                            <select id="inputState" class="form-select form-control" name="supplier">
                                                <option selected disabled>Pilih Supplier</option>
                                                @foreach ($suppliers as $sup)
                                                    <option value="{{ $sup->id }}" class="text-capitalize">
                                                        {{ $sup->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <a href="#collapseCardExample" class="d-block card-header py-3"
                                            data-toggle="collapse" role="button" aria-expanded="true"
                                            aria-controls="collapseCardExample">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <h6 class="m-0 font-weight-bold text-primary">Nama Product</h6>
                                                </div>
                                                <div class="col-sm-3">
                                                    <h6 class="m-0 font-weight-bold text-primary">Satuan</h6>
                                                </div>
                                                <div class="col-sm-3">
                                                    <h6 class="m-0 font-weight-bold text-primary">Qty</h6>
                                                </div>

                                            </div>
                                        </a>
                                        <!-- Card Content - Collapse -->
                                        <div class="collapse show" id="collapseCardExample">
                                            <div class="card-body">
                                                <div id="selectedProductsContainer">
                                                    {{-- input nama_barang, satuan, qty, dan total --}}

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-sm-5">
                                            <label for="">Total :</label>
                                        </div>
                                        <div class="col-sm-5 text-right">
                                            <label class="mr-5" id="totalLabel"></label>
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-sm-6">
                                            <button class="btn btn-warning w-100" type="button"
                                                data-dismiss="modal">Cancel</button>
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-primary w-100">Order</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-7">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3" id="product">
                                        <h6 class="m-0 font-weight-bold text-primary">List Bahan Baku</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach ($produks as $produk)
                                                @php
                                                    $id_produk = $produk->id;
                                                    $totalStokMasuk = $produk->stokMasuk
                                                        ->where('produk_id', $id_produk)
                                                        ->sum('stok_masuk');
                                                    $totalStokKeluar = $produk->stokKeluar
                                                        ->where('produk_id', $id_produk)
                                                        ->sum('stok_keluar');

                                                    $stok = $totalStokMasuk - $totalStokKeluar;
                                                @endphp

                                                <div class="col-sm-3">
                                                    <a href="#" class="btn produk-btn"
                                                        data-nama-barang="{{ $produk->nama_barang }}"
                                                        data-satuan="{{ $produk->satuan }}"
                                                        data-harga="{{ $produk->harga }}"
                                                        data-id-barang="{{ $produk->id }}">
                                                        <div class="card shadow" style="width: 110px;height:160px">
                                                            <div class="container  d-flex align-items-center justify-content-center"
                                                                style="width: 110px;height:110px;background-color:rgb(171, 170, 170)">
                                                                <h1 class="m-0 text-bold text-white">
                                                                    {{ strtoupper(substr($produk->nama_barang, 0, 1)) }}{{ strtoupper(substr($produk->nama_barang, strpos($produk->nama_barang, ' ') + 1, 1)) }}
                                                                </h1>
                                                            </div>
                                                            <span for="" class="text-center mt-2"
                                                                style="font-size: 12px">{{ $produk->nama_barang }}</span>

                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var productButtons = document.querySelectorAll('.produk-btn');
            var selectedProductsContainer = document.getElementById('selectedProductsContainer');

            productButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    var productName = this.getAttribute('data-nama-barang');
                    var existingProductRow = document.querySelector(
                        `[data-product-name="${productName}"]`);

                    if (existingProductRow) {
                        // Jika produk sudah ada, tambahkan quantity
                        var qtyInput = existingProductRow.querySelector('.qty-input');
                        var currentQty = parseInt(qtyInput.value);
                        qtyInput.value = currentQty + 1;
                    } else {
                        // Jika produk belum ada, tambahkan row baru
                        var satuan = this.getAttribute('data-satuan');
                        var harga = this.getAttribute('data-harga');
                        var idBarang = this.getAttribute('data-id-barang');
                        addProductRow(productName, satuan, harga, idBarang);
                    }
                    updateTotal();
                });
            });

            function addProductRow(productName, satuan, harga, idBarang) {
                var productRow = document.createElement('div');
                productRow.className = 'row mb-2';
                productRow.setAttribute('data-product-name', productName);

                var productNameDiv = document.createElement('div');
                productNameDiv.className = 'col-sm-4';
                productNameDiv.textContent = productName;

                var satuanDiv = document.createElement('div');
                satuanDiv.className = 'col-sm-3';
                satuanDiv.textContent = satuan;

                var qtyDiv = document.createElement('div');
                qtyDiv.className = 'col-sm-3';
                qtyDiv.innerHTML =
                    '<input type="number" class="form-control qty-input" name="qty[]" value="1" min="1" onchange="updateTotal()">';

                var deleteButtonDiv = document.createElement('div');
                deleteButtonDiv.className = 'col-sm-2';
                deleteButtonDiv.innerHTML =
                    '<a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>';
                deleteButtonDiv.addEventListener('click', function(event) {
                    event.preventDefault();
                    selectedProductsContainer.removeChild(productRow);
                    updateTotal();
                });

                var hiddenProductNameInput = document.createElement('input');
                hiddenProductNameInput.type = 'hidden';
                hiddenProductNameInput.name = 'nama_barang[]';
                hiddenProductNameInput.value = idBarang;

                var hiddenSatuanInput = document.createElement('input');
                hiddenSatuanInput.type = 'hidden';
                hiddenSatuanInput.name = 'satuan[]';
                hiddenSatuanInput.value = satuan;

                var hiddenHargaInput = document.createElement('input');
                hiddenHargaInput.type = 'hidden';
                hiddenHargaInput.name = 'harga[]';
                hiddenHargaInput.value = harga;

                // Append all elements to the product row
                productRow.appendChild(productNameDiv);
                productRow.appendChild(satuanDiv);
                productRow.appendChild(qtyDiv);
                productRow.appendChild(deleteButtonDiv);
                productRow.appendChild(hiddenProductNameInput);
                productRow.appendChild(hiddenSatuanInput);
                productRow.appendChild(hiddenHargaInput);

                selectedProductsContainer.appendChild(productRow);

            }

            selectedProductsContainer.addEventListener('input', function(event) {
                if (event.target.classList.contains('qty-input')) {
                    updateTotal();
                }
            });

            function updateTotal() {
                var qtyInputs = selectedProductsContainer.querySelectorAll('.qty-input');
                var total = 0;

                qtyInputs.forEach(function(input) {
                    total += parseInt(input.value);
                });

                document.getElementById('totalLabel').textContent = total;
            }
        });
    </script>
@endsection
