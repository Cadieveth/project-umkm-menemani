@extends('layouts.main')

@section('content')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    <style>
        .btn.disabled {
            opacity: 0.5;
            pointer-events: none;
            cursor: default;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $judul }}</h1>
    </div>

    <div class="wrapper-table bg-white rounded ">
        <div class="card shadow ">
            <div class="card-header">
                <h6 class="mb-2 font-weight-bold"><a href="#" data-toggle="modal" data-target="#resepModal"
                        class="btn btn-primary ">+ Data Resep</a></h6>
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
                            <th>No Resep</th>
                            <th>Nama Resep</th>
                            <th>Deskripsi</th>
                            {{-- <th>Status</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    {{-- <tfoot>
                        <tr>
                            <th>#</th>
                            <th>No Resep</th>
                            <th>Nama Resep</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot> --}}
                    <tbody>
                        @foreach ($reseps as $resep)
                            @php
                                $no_resep = $resep->no_resep;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $no_resep }}</td>
                                <td>{{ $resep->nama_resep }}</td>
                                <td>{{ $resep->keterangan }}</td>
                                <td>
                                    {{-- <form action="{{ route('produksi', $resep->no_resep) }}" method="post"
                                        class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-circle btn-success" type="submit"><i
                                                class="fas fa-check"></i></button>
                                    </form> --}}
                                    <a href="#" class="btn btn-success btn-circle btn-sm" data-toggle="modal"
                                        data-target="#masukModalEdit" data-id="{{ $resep->no_resep }}">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="{{ route('resep.details', $resep->no_resep) }}"
                                        class="btn btn-primary btn-circle btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('resep.delete', $resep->no_resep) }}" method="post"
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

        <div class="modal fade" id="resepModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Data Resep</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row ">
                            <div class="col-sm-6">
                                <form id="formResep" action="{{ route('add.resep') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mt-2 mb-4">
                                        <div class="col-sm-6">
                                            <label for="inputState" class="form-label font-weight-bold text-primary">Nama
                                                Resep</label>
                                            <div class="form-floating">
                                                <input type="text"
                                                    class="form-control @error('nama_resep') is-invalid @enderror"
                                                    id="floatingInput" placeholder="name@example.com" name="nama_resep">
                                                <label for="floatingInput">Nama Resep</label>
                                            </div>
                                            @error('nama_resep')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="inputState"
                                                class="form-label font-weight-bold text-primary">Deskripsi Resep</label>
                                            <div class="form-floating">
                                                <input type="text"
                                                    class="form-control @error('keterangan') is-invalid @enderror"
                                                    id="floatingInput" placeholder="name@example.com" name="keterangan">
                                                <label for="floatingInput">Deskripsi Resep</label>
                                            </div>
                                            @error('keterangan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="card shadow mb-4">
                                        <div href="#" class="d-block card-header py-3">
                                            <div class="row ">
                                                <div class="col-sm-5">
                                                    <h6 class="m-0 font-weight-bold text-primary">Nama Bahan</h6>
                                                </div>
                                                <div class="col-sm-3">
                                                    <h6 class="m-0 font-weight-bold text-primary">Satuan</h6>
                                                </div>
                                                <div class="col-sm-3">
                                                    <h6 class="m-0 font-weight-bold text-primary">Qty</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse show" id="collapseCardExample">
                                            <div class="card-body">
                                                <div id="selectedProductsContainer">
                                                </div>
                                                <div id="error-message" class="text-danger"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="content" class="font-weight-bold text-primary">Instruksi</label>
                                        <textarea id="summernote" name="instruksi" class="form-control" rows="10" cols="50"></textarea>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-sm-6">
                                            <button class="btn btn-warning w-100" type="button"
                                                data-dismiss="modal">Cancel</button>
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-primary w-100"
                                                id="submitForm">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-6">
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
                                                        ->where('baku_id', $id_produk)
                                                        ->sum('stok_masuk');
                                                    $totalStokKeluar = $produk->stokKeluar
                                                        ->where('baku_id', $id_produk)
                                                        ->sum('stok_keluar');
                                                    $stok = $totalStokMasuk - $totalStokKeluar;
                                                @endphp
                                                @if ($stok == 0)
                                                    <div class="col-sm-3">
                                                        <div class="btn produk-btn disabled"
                                                            data-nama-barang="{{ $produk->name }}"
                                                            data-satuan="{{ $produk->satuan }}"
                                                            data-id-barang="{{ $produk->id }}">
                                                            <div class="card shadow" style="width: 110px; height: 160px;">
                                                                <div class="container d-flex align-items-center justify-content-center"
                                                                    style="width: 110px; height: 110px; background-color: rgb(171, 170, 170);">
                                                                    <h1 class="m-0 text-bold text-white">
                                                                        {{ strtoupper(substr($produk->name, 0, 1)) }}{{ strtoupper(substr($produk->nama_barang, strpos($produk->nama_barang, ' ') + 1, 1)) }}
                                                                    </h1>
                                                                </div>
                                                                <span class="text-center mt-2" style="font-size: 12px;">
                                                                    {{ $produk->name }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-sm-3">
                                                        <a href="#" class="btn produk-btn"
                                                            data-nama-barang="{{ $produk->name }}"
                                                            data-satuan="{{ $produk->satuan }}"
                                                            data-id-barang="{{ $produk->id }}">
                                                            <div class="card shadow" style="width: 110px;height:160px">
                                                                <div class="container d-flex align-items-center justify-content-center"
                                                                    style="width: 110px;height:110px;background-color:rgb(171, 170, 170)">
                                                                    <h1 class="m-0 text-bold text-white">
                                                                        {{ strtoupper(substr($produk->name, 0, 1)) }}{{ strtoupper(substr($produk->nama_barang, strpos($produk->nama_barang, ' ') + 1, 1)) }}
                                                                    </h1>
                                                                </div>
                                                                <span for="" class="text-center mt-2"
                                                                    style="font-size: 12px">{{ $produk->name }}</span>

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

        @if ($resep != null)
            <div class="modal fade" id="masukModalEdit" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <form id="editMasukForm" action="" method="post">
                        @csrf
                        <div class="modal-content">
                            <input type="hidden" name="no_resep" id="noResep" value="">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Produksi Resep</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-floating mb-3">
                                            <input type="text"
                                                class="form-control @error('nama_produk') is-invalid @enderror"
                                                id="editMasukInvoice" placeholder="Invoice" name="nama_produk">
                                            <label for="editMasukInvoice">Nama Produk</label>
                                        </div>
                                        @error('nama_produk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-floating mb-3">
                                            <input type="number"
                                                class="form-control @error('qty_in') is-invalid @enderror"
                                                id="editMasukJml_masuk" placeholder="name@example.com" name="qty_in">
                                            <label for="editMasukJml_masuk">Qty Produksi</label>
                                        </div>
                                        @error('qty_in')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                        <div class="form-floating mb-3">
                                            <input type="number"
                                                class="form-control @error('biaya_pekerja') is-invalid @enderror"
                                                id="editMasukJml_masuk" placeholder="name@example.com"
                                                name="biaya_pekerja">
                                            <label for="editMasukJml_masuk">Biaya Pekerja</label>
                                        </div>
                                        @error('biaya_pekerja')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-floating mb-3">
                                            <input type="number"
                                                class="form-control @error('biaya_overhead') is-invalid @enderror"
                                                id="editMasukJml_masuk" placeholder="name@example.com"
                                                name="biaya_overhead">
                                            <label for="editMasukJml_masuk">Biaya Overhead Mesin</label>
                                        </div>
                                        @error('biaya_overhead')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" type="button" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary" type="submit">Produksi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div></div>
        @endif

        <script>
            $('#masukModalEdit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Tombol yang diklik
                var noResep = button.data('id'); // Ambil data-id

                var modal = $(this);
                modal.find('.modal-body #noResep').val(noResep);
                modal.find('form').attr('action', '/produksi/' + noResep);
            });

            document.addEventListener('DOMContentLoaded', function() {
                var productButtons = document.querySelectorAll('.produk-btn');
                var selectedProductsContainer = document.getElementById('selectedProductsContainer');

                productButtons.forEach(function(button) {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();
                        var productName = this.getAttribute('data-nama-barang');
                        var satuan = this.getAttribute('data-satuan');
                        var stokTersedia = parseInt(this.getAttribute('data-stok'));
                        var idBarang = this.getAttribute('data-id-barang');
                        var existingProductRow = document.querySelector(
                            `[data-product-name="${productName}"]`);

                        if (existingProductRow) {
                            var qtyInput = existingProductRow.querySelector('.qty-input');
                            var newQty = parseInt(qtyInput.value) + 1;

                            if (newQty > stokTersedia) {
                                alert('Stok tidak mencukupi!');
                                return;
                            }

                            qtyInput.value = newQty;
                        } else {
                            addProductRow(productName, satuan, stokTersedia, idBarang);
                        }
                    });
                });

                function addProductRow(productName, satuan, stokTersedia, idBarang) {
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
                        `<input type="number" class="form-control qty-input" name="qty[]" value="1" min="1" max="${stokTersedia}" data-stok="${stokTersedia}">`;

                    var deleteButtonDiv = document.createElement('div');
                    deleteButtonDiv.className = 'col-sm-2';
                    deleteButtonDiv.innerHTML =
                        '<a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>';
                    deleteButtonDiv.addEventListener('click', function(event) {
                        event.preventDefault();
                        selectedProductsContainer.removeChild(productRow);
                    });

                    var hiddenProductNameInput = document.createElement('input');
                    hiddenProductNameInput.type = 'hidden';
                    hiddenProductNameInput.name = 'nama_barang[]';
                    hiddenProductNameInput.value = idBarang;

                    productRow.appendChild(productNameDiv);
                    productRow.appendChild(satuanDiv);
                    productRow.appendChild(qtyDiv);
                    productRow.appendChild(deleteButtonDiv);
                    productRow.appendChild(hiddenProductNameInput);

                    selectedProductsContainer.appendChild(productRow);

                    // Tambahkan event listener untuk validasi kuantitas
                    selectedProductsContainer.addEventListener('input', function(event) {
                        if (event.target.classList.contains('qty-input')) {
                            var qtyInput = event.target;
                            var productRow = qtyInput.closest('.row');
                            var stokTersedia = parseInt(qtyInput.getAttribute('data-stok'));

                            if (parseInt(qtyInput.value) > stokTersedia) {
                                alert('Stok tidak mencukupi!');
                                qtyInput.value = stokTersedia;
                            }
                        }
                    });



                }
            });
        </script>

        <script>
            $('#summernote').summernote({
                placeholder: 'Masukan Instruksi Dari Resep',
                tabsize: 2,
                height: 100
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var elements = document.querySelectorAll('.disable a');
                elements.forEach(function(element) {
                    element.addEventListener('click', function(event) {
                        event.preventDefault();
                        return false;
                    });
                });
            });
        </script>
    @endsection
