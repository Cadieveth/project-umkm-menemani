@extends('layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $judul }}</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex">
                <h6 class="mb-2 font-weight-bold mr-3"><a href="#" data-toggle="modal" data-target="#orderModal"
                        class="btn btn-primary ">+ Transaksi</a></h6>
                <div class="mb-2 font-weight-bold"><a href="#" data-toggle="modal" data-target="#marginModal"
                        class="btn btn-primary ">Set Margin</a></div>
            </div>
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

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Nomor Transaksi</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Nomor Transaksi</th>
                            <th>Total </th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($transaksis as $tr)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d F Y', strtotime($tr->tgl_transaksi)) }}</td>
                                <td>{{ $tr->no_transaksi }}</td>
                                <td>
                                    {{ 'Rp ' . number_format($tr->total, 0, ',', '.') }}
                                </td>
                                <td><a href="{{ route('invoice.transaksi', $tr->no_transaksi) }}"
                                        class="btn btn-primary btn-circle btn-sm">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <form action="{{ route('transaksi.delete', $tr->no_transaksi) }}" method="post"
                                        class="d-inline">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-sm btn-circle btn-danger"
                                            onclick="return confirm('Anda Yakin Akan Menghapus Data Ini ?')" type="submit">
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
                    <h5 class="modal-title" id="exampleModalLabel">Transaksi</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row ">
                        <div class="col-sm-6">
                            <form id="formOrder" action="#" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->

                                    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse"
                                        role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <h6 class="m-0 font-weight-bold text-primary">Nama Product</h6>
                                            </div>
                                            <div class="col-sm-2 text-center">
                                                <h6 class="m-0 font-weight-bold text-primary">Harga</h6>
                                            </div>
                                            <div class="col-sm-2 text-center">
                                                <h6 class="m-0 font-weight-bold text-primary">Qty</h6>
                                            </div>
                                            <div class="col-sm-1"></div>
                                            <div class="col-sm-3">
                                                <h6 class="m-0 font-weight-bold text-primary">Subtotal</h6>
                                            </div>
                                        </div>
                                    </a>
                                    <!-- Card Content - Collapse -->
                                    <div class="collapse show" id="collapseCardExample">
                                        <div class="card-body">
                                            <div id="selectedProductsContainer">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-sm-7">
                                        <label for="">Total :</label>
                                    </div>
                                    <div class="col-sm-5 text-center">
                                        <label class="ml-2" id="totalLabel"></label>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-sm-6">
                                        <button class="btn btn-warning w-100" type="button"
                                            data-dismiss="modal">Cancel</button>
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary w-100">Checkout</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3" id="product">
                                    <h6 class="m-0 font-weight-bold text-primary">List Product</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($produks as $produk)
                                            @php
                                                $qtyIn = $produk->qty_in;
                                                $qtyOut = $produk->qty_out;
                                                $stok = $qtyIn - $qtyOut;
                                                $sto = intval($stok);

                                                // Periksa jika dataMargin tidak null
                                                if ($dataMargin && $dataMargin->margin !== null) {
                                                    $marginPercentage = $dataMargin->margin / 100;
                                                    $hargaDenganMargin =
                                                        $marginPercentage * $produk->hpp + $produk->hpp;
                                                } else {
                                                    $hargaDenganMargin = $produk->hpp; // Tidak ada margin atau dataMargin
                                                }
                                            @endphp

                                            @if ($sto == 0)
                                                <div class=""></div>
                                            @elseif($sto <= 30)
                                                <div class="col-sm-3">
                                                    <a href="#" class="btn produk-btn"
                                                        data-nama-barang="{{ $produk->nama_product }}"
                                                        data-harga="{{ $hargaDenganMargin }}"
                                                        data-id-barang="{{ $produk->id }}"
                                                        data-stok="{{ $sto }}">
                                                        <div class="card shadow" style="width: 110px;height:160px">
                                                            <div class="container  d-flex align-items-center justify-content-center"
                                                                style="width: 110px;height:110px;background-color:rgb(171, 170, 170)">
                                                                <h5 class="m-0 text-bold text-white">
                                                                    <span class="badge badge-warning">Stok
                                                                        Menipis</span>
                                                                </h5>
                                                            </div>
                                                            <span for="" class="text-center mt-2"
                                                                style="font-size: 12px">{{ $produk->nama_product }}</span>
                                                            <span for="" class="text-center"
                                                                style="font-size: 12px"><strong>Stok:
                                                                    {{ $sto }}</strong></span>
                                                        </div>
                                                    </a>
                                                </div>
                                            @else
                                                <div class="col-sm-3">
                                                    <a href="#" class="btn produk-btn"
                                                        data-nama-barang="{{ $produk->nama_product }}"
                                                        data-harga="{{ $hargaDenganMargin }}"
                                                        data-id-barang="{{ $produk->id }}"
                                                        data-stok="{{ $sto }}">
                                                        <div class="card shadow" style="width: 110px;height:160px">
                                                            <div class="container  d-flex align-items-center justify-content-center"
                                                                style="width: 110px;height:110px;background-color:rgb(171, 170, 170)">
                                                                <h1 class="m-0 text-bold text-white">
                                                                    {{ strtoupper(substr($produk->nama_product, 0, 1)) }}{{ strtoupper(substr($produk->nama_product, strpos($produk->nama_product, ' ') + 1, 1)) }}
                                                                </h1>
                                                            </div>
                                                            <span for="" class="text-center mt-2"
                                                                style="font-size: 12px">{{ $produk->nama_product }}</span>
                                                            <span for="" class="text-center"
                                                                style="font-size: 12px"><strong>Stok:
                                                                    {{ $sto }}</strong></span>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
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

    <div class="modal fade" id="marginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Setting Margin</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row ">
                        <div class="col-sm-12">
                            <form id="formMargin" action="{{ route('transaksi.store_margin') }}" method="POST">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="_method" id="formMethod" value="POST">
                                <div class="d-flex ml-2" id="fieldText">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="number"
                                                class="form-control @error('margin') is-invalid @enderror" id="margin"
                                                placeholder="Margin" name="margin" value="{{ old('margin') }}">
                                            <label for="floatingInput">Besar Margin</label>
                                            <div class="invalid-feedback">Isi nilai margin</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-1" id="dataMargin">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Margin</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($margin as $dataMargin)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $dataMargin->margin }} %</td>
                                                            <td>
                                                                <a href="#"
                                                                    class="btn btn-primary btn-circle btn-sm btn-edit"
                                                                    data-id="{{ $dataMargin->id }}"
                                                                    data-margin="{{ $dataMargin->margin }}">
                                                                    <i class="fas fa-pen"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-sm-6">
                                        <button class="btn btn-warning w-100" type="button"
                                            data-dismiss="modal">Cancel</button>
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary w-100">OK</button>
                                    </div>
                                </div>
                            </form>
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
                    var productPrice = parseFloat(this.getAttribute('data-harga'));
                    var idBarang = this.getAttribute('data-id-barang');
                    var stokTersedia = parseInt(this.getAttribute('data-stok'));
                    var existingProductRow = document.querySelector(
                        `[data-product-name="${productName}"]`);

                    if (existingProductRow) {
                        // Jika produk sudah ada, tambahkan quantity
                        var qtyInput = existingProductRow.querySelector('.qty-input');
                        var newQty = parseInt(qtyInput.value) + 1;

                        if (newQty > stokTersedia) {
                            alert('Stok tidak mencukupi!');
                            return;
                        }

                        qtyInput.value = newQty;
                        updateProductTotal(existingProductRow, productPrice);
                    } else {
                        addProductRow(productName, productPrice, idBarang, stokTersedia);
                    }
                    updateTotal();
                });
            });

            function addProductRow(productName, productPrice, idBarang, stokTersedia) {
                // Jika produk belum ada, tambahkan row baru
                var productRow = document.createElement('div');
                productRow.className = 'row mb-2';
                productRow.setAttribute('data-product-name', productName);

                var productNameDiv = document.createElement('div');
                productNameDiv.className = 'col-sm-3';
                productNameDiv.textContent = productName;

                var hargaDiv = document.createElement('div');
                hargaDiv.className = 'col-sm-3 text-right';
                hargaDiv.innerHTML = '<label>Rp ' + productPrice.toFixed(0) + '</label>';

                var qtyDiv = document.createElement('div');
                qtyDiv.className = 'col-sm-2';
                qtyDiv.innerHTML =
                    '<input type="number" class="qty-input w-100" name="qty[]" value="1" min="1" max="' +
                    stokTersedia + '" data-price="' +
                    productPrice + '">';

                var priceDiv = document.createElement('div');
                priceDiv.className = 'col-sm-3 text-right';
                priceDiv.innerHTML = '<label class="total-price-label">Rp ' + productPrice.toFixed(0) + '</label>';

                var deleteButtonDiv = document.createElement('div');
                deleteButtonDiv.className = 'col-sm-1';
                deleteButtonDiv.innerHTML =
                    '<a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>';
                deleteButtonDiv.addEventListener('click', function(event) {
                    event.preventDefault();
                    selectedProductsContainer.removeChild(productRow);
                    updateTotal(); // Update total after removal
                });

                var hiddenProductNameInput = document.createElement('input');
                hiddenProductNameInput.type = 'hidden';
                hiddenProductNameInput.name = 'nama_barang[]';
                hiddenProductNameInput.value = idBarang;

                var hiddenHargaInput = document.createElement('input');
                hiddenHargaInput.type = 'hidden';
                hiddenHargaInput.name = 'harga[]';
                hiddenHargaInput.value = productPrice;

                var hiddenPrice = document.createElement('input');
                hiddenPrice.type = 'hidden';
                hiddenPrice.name = 'subtotal[]';
                hiddenPrice.className = 'hidden-price';
                hiddenPrice.value = productPrice.toFixed(0);

                // Tambahkan elemen-elemen tersebut ke dalam row
                productRow.appendChild(productNameDiv);
                productRow.appendChild(hargaDiv);
                productRow.appendChild(qtyDiv);
                productRow.appendChild(priceDiv);
                productRow.appendChild(deleteButtonDiv);
                productRow.appendChild(hiddenProductNameInput);
                productRow.appendChild(hiddenHargaInput);
                productRow.appendChild(hiddenPrice);

                // Tambahkan row ke dalam container produk yang dipilih
                selectedProductsContainer.appendChild(productRow);
            }

            selectedProductsContainer.addEventListener('input', function(event) {
                if (event.target.classList.contains('qty-input')) {
                    var qtyInput = event.target;
                    var productRow = qtyInput.closest('.row');
                    var productPrice = parseFloat(qtyInput.getAttribute('data-price'));
                    var stokTersedia = parseInt(qtyInput.getAttribute('max'));

                    if (parseInt(qtyInput.value) > stokTersedia) {
                        alert('Stok tidak mencukupi!');
                        qtyInput.value = stokTersedia;
                    }

                    updateProductTotal(productRow, productPrice);
                    console.log('Updating total after input change');
                    updateTotal(); // Ensure this is called to update total
                }
            });


            function updateProductTotal(productRow, productPrice) {
                var qtyInput = productRow.querySelector('.qty-input');
                var totalPriceLabel = productRow.querySelector('.total-price-label');
                totalPriceLabel.textContent = 'Rp ' + (qtyInput.value * productPrice).toFixed(0);

                // Update hidden input value
                var hiddenPrice = productRow.querySelector('.hidden-price');
                hiddenPrice.value = (qtyInput.value * productPrice).toFixed(0);
            }

            function updateTotal() {
                var qtyInputs = selectedProductsContainer.querySelectorAll('.qty-input');
                var total = 0;

                qtyInputs.forEach(function(input) {
                    total += parseInt(input.value) * parseFloat(input.getAttribute('data-price'));
                });

                document.getElementById('totalLabel').textContent = 'Rp ' + total.toFixed(0);
            }

            const marginField = document.getElementById('margin');
            const formMargin = document.getElementById('formMargin');
            const submitButton = formMargin.querySelector('button[type="submit"]');
            const cancelButton = formMargin.querySelector('button[data-dismiss="modal"]');
            const methodField = document.getElementById('formMethod');
            let isEdit = false;
            let editId = null;

            // Reset form when modal is closed
            $('#marginModal').on('hidden.bs.modal', function() {
                resetForm();
            });

            // Function to reset form
            function resetForm() {
                marginField.value = '';
                const submitButton = document.querySelector(
                    '#marginModal button[type="submit"]');
                submitButton.textContent = 'OK';
                isEdit = false;
                editId = null;
                formMargin.setAttribute('action', '{{ route('transaksi.store_margin') }}');
                methodField.value = 'POST';
                console.log('Reset Form: action set to', formMargin.getAttribute('action'));
                console.log('Reset Form: method set to', methodField.value);
            }

            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function() {
                    // ubah kondisi isEdit = true, dan buttonnya
                    isEdit = true;
                    const submitButton = document.querySelector(
                        '#marginModal button[type="submit"]');
                    submitButton.textContent = 'Update';

                    // ngirim nilai margin by id
                    const marginValue = this.getAttribute('data-margin');
                    editId = this.getAttribute('data-id');
                    marginField.value = marginValue;

                    // ubah route ke update-margin
                    const url = `{{ route('transaksi.update_margin', ':id') }}`.replace(':id',
                        editId);
                    formMargin.setAttribute('action', url);
                    methodField.value = 'PUT';
                });
            });

            // Cancel button
            cancelButton.addEventListener('click', function() {
                resetForm();
                console.log("Diklik");
                form
            });

            // Handle form submission
            formMargin.addEventListener('submit', function(e) {
                console.log('Form action on submit:', formMargin.getAttribute('action'));
                console.log('Form method on submit:', methodField.value);
                if (marginField.value === '') {
                    e.preventDefault();
                    marginField.classList.add('is-invalid');
                    formMargin.querySelector('.invalid-feedback').textContent = 'Isi nilai margin';
                }
            });

        });
    </script>
@endsection
