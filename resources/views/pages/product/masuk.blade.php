@extends('layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $judul }}</h1>
    </div>

    <div class="wrapper-table bg-white rounded ">
        <div class="card shadow ">
            <div class="card-header">
                <h6 class="mb-2 font-weight-bold"><a href="#" data-toggle="modal" data-target="#masukModal"
                        class="btn btn-primary ">+ Barang Masuk</a></h6>

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
                            <th>Tanggal Masuk</th>
                            <th>Invoice</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Qty</th>
                            <th>Supplier</th>
                            <th>Keterangan</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    {{-- <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Tanggal Masuk</th>
                            <th>Invoice</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Qty</th>
                            <th>Supplier</th>
                            <th>Keterangan</th>
                            <th>Action</th>
                        </tr>
                    </tfoot> --}}
                    <tbody>
                        @foreach ($stok_masuk as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d F Y', strtotime($p->created_at)) }}</td>
                                <td class="text-uppercase">{{ $p->invoice }}</td>
                                <td>{{ $p->baku->kode_barang }}</td>
                                <td>{{ $p->baku->name }}</td>
                                <td>{{ $p->baku->satuan }}</td>
                                <td>{{ $p->stok_masuk }}</td>
                                <td>
                                    {{ $p->supplier->name }}
                                </td>
                                <td>{{ $p->keterangan }}</td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#masukModalEdit"
                                        class="btn btn-primary btn-circle btn-sm" data-id="{{ $p->id }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('delete.masuk', $p->id) }}" method="post" class="d-inline">
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

        <div class="modal fade" id="masukModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Input Barang Masuk</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('add.masuk') }}" method="post">
                        <div class="modal-body">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('invoice') is-invalid @enderror"
                                            id="floatingInput" placeholder="Invoice" name="invoice">
                                        <label for="floatingInput">No Invoice</label>
                                    </div>
                                    @error('invoice')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating">
                                        <select class="form-select form-control @error('supplier') is-invalid @enderror"
                                            id="floatingSelect" aria-label="Floating label select example" name="supplier">
                                            <option selected disabled>Pilih Supplier </option>
                                            @foreach ($suppliers as $sup)
                                                <option value="{{ $sup->id }}" class="text-capitalize">
                                                    {{ $sup->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="floatingSelect">Supplier</label>
                                    </div>
                                    @error('supplier')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select form-control @error('nama_barang') is-invalid @enderror"
                                            id="floatingSelect" aria-label="Floating label select example"
                                            name="nama_barang">
                                            <option selected disabled>Pilih Bahan Baku </option>
                                            @foreach ($bakus as $bahan)
                                                <option value="{{ $bahan->id }}" class="text-capitalize">
                                                    {{ $bahan->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="floatingSelect">Bahan Baku</label>

                                    </div>
                                    @error('nama_barang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('jml_masuk') is-invalid @enderror"
                                            id="floatingInput" placeholder="name@example.com" name="jml_masuk">
                                        <label for="floatingInput">Qty</label>
                                        <div class="d-flex justify-content-end" style="font-size: 10px">Kuantitas per KG,
                                            jika satuan Gram</div>
                                    </div>
                                    @error('jml_masuk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('harga') is-invalid @enderror"
                                            id="floatingInput" placeholder="Harga" name="harga">
                                        <label for="floatingInput">Harga</label>
                                        <div class="d-flex justify-content-end" style="font-size: 10px">Harga per KG, jika
                                            satuan Gram</div>
                                    </div>
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-floating mb-3">
                                        <input type="text"
                                            class="form-control @error('keterangan') is-invalid @enderror"
                                            id="floatingInput" placeholder="Keterangan" name="keterangan">
                                        <label for="floatingInput">Keterangan</label>
                                    </div>
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-warning" type="button" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <div class="modal fade" id="masukModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form id="editMasukForm" action="{{ route('update.masuk') }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="editMasukId">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Barang Masuk</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating">
                                        <select class="form-select form-control @error('supplier') is-invalid @enderror"
                                            id="editMasukSupplier" aria-label="Floating label select example"
                                            name="supplier">
                                            <option selected disabled>Pilih Supplier</option>
                                            @foreach ($suppliers as $list)
                                                <option value="{{ $list->id }}" class="text-capitalize">
                                                    {{ $list->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="editMasukSupplier">Supplier</label>
                                    </div>
                                    @error('supplier')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text"
                                            class="form-control text-uppercase @error('invoice') is-invalid @enderror"
                                            id="editMasukInvoice" placeholder="Invoice" name="invoice">
                                        <label for="editMasukInvoice">No Invoice</label>
                                    </div>
                                    @error('invoice')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating">
                                        <select class="form-select form-control @error('produk') is-invalid @enderror"
                                            id="editMasukProduk" aria-label="Floating label select example"
                                            name="produk">
                                            <option selected disabled>Pilih Barang</option>
                                            @foreach ($produks as $pro)
                                                <option value="{{ $pro->id }}" class="text-capitalize">
                                                    {{ $pro->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="floatingSelect">Nama Barang</label>
                                    </div>
                                    @error('produk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text"
                                            class="form-control @error('jml_masuk') is-invalid @enderror"
                                            id="editMasukJml_masuk" placeholder="name@example.com" name="jml_masuk">
                                        <label for="editMasukJml_masuk">Qty</label>
                                    </div>
                                    @error('jml_masuk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-floating mb-3">
                                        <input type="text"
                                            class="form-control @error('keterangan') is-invalid @enderror"
                                            id="editMasukKeterangan" placeholder="Keterangan" name="keterangan">
                                        <label for="editMasukKeterangan">Keterangan</label>
                                    </div>
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-warning" type="button" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#masukModalEdit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var masukId = button.data('id'); // Extract info from data-* attributes

                // AJAX request to get the user data
                $.ajax({
                    url: '/masuk/' + masukId + '/edit',
                    method: 'GET',
                    success: function(data) {
                        $('#editMasukId').val(data.id);
                        $('#editMasukProduk').val(data
                        .baku_id); // Set value for select Nama Barang
                        $('#editMasukSupplier').val(data.supplier_id);
                        $('#editMasukInvoice').val(data.invoice);
                        $('#editMasukJml_masuk').val(data.stok_masuk);
                        $('#editMasukKeterangan').val(data.keterangan);

                        // Memilih opsi yang sesuai berdasarkan data.baku_id
                        $('#editMasukProduk option').removeAttr(
                        'selected'); // Menghapus 'selected' dari semua option
                        $('#editMasukProduk option[value="' + data.baku_id + '"]').attr(
                            'selected', 'selected');

                        // Jika menggunakan Select2, perlu memanggil trigger 'change'
                        $('#editMasukProduk').trigger('change');
                    }
                });
            });
        });
    </script>
@endsection
