@extends('layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $judul }}</h1>
    </div>

    <div class="wrapper-table bg-white rounded ">
        <div class="card shadow ">
            <div class="card-header">
                <h6 class="mb-2 font-weight-bold"><a href="#" data-toggle="modal" data-target="#stokModal"
                        class="btn btn-primary ">+ Barang Keluar</a></h6>
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
                            <th>Tanggal Keluar</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Qty</th>
                            <th>Nomor Dokumen</th>
                            <th>Keterangan</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    {{-- <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Tanggal Keluar</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Qty</th>
                            <th>Nomor Dokumen</th>
                            <th>Keterangan</th>
                            <th>Action</th>
                        </tr>
                    </tfoot> --}}
                    <tbody>
                        @foreach ($stok_keluar as $keluar)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d F Y', strtotime($keluar->created_at)) }}</td>
                                <td>{{ $keluar->baku->kode_barang }}</td>
                                <td>{{ $keluar->baku->name }}</td>
                                <td>{{ $keluar->baku->satuan }}</td>
                                <td>{{ $keluar->stok_keluar }}</td>
                                <td class="text-uppercase">{{ $keluar->no_dokumen }}</td>
                                <td>{{ $keluar->keterangan }}</td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#keluarModalEdit"
                                        class="btn btn-primary btn-circle btn-sm" data-id="{{ $keluar->id }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('delete.keluar', $keluar->id) }}" method="post"
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

        <div class="modal fade" id="stokModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Barang Keluar</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('add.keluar') }}" method="post">
                        <div class="modal-body">
                            @csrf
                            <div class="row">

                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating">
                                        <select class="form-select form-control @error('produk') is-invalid @enderror"
                                            id="floatingSelect" aria-label="Floating label select example" name="produk">
                                            <option selected disabled>Pilih Barang</option>
                                            @foreach ($produks as $pro)
                                                <option value="{{ $pro->baku_id }}" class="text-capitalize">
                                                    {{ $pro->name }} </option>
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
                                        <input type="text" class="form-control @error('jml_keluar') is-invalid @enderror"
                                            id="floatingInput" placeholder="name@example.com" name="jml_keluar">
                                        <label for="floatingInput">Qty</label>
                                    </div>
                                    @error('jml_keluar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('no_dokumen') is-invalid @enderror"
                                            id="floatingInput" placeholder="name@example.com" name="no_dokumen">
                                        <label for="floatingInput">Nomor Dokumen</label>
                                    </div>
                                    @error('no_dokumen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
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

        <div class="modal fade" id="keluarModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form id="editKeluarForm" action="{{ route('update.keluar') }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="editKeluarId">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Barang Keluar</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating">
                                        <select class="form-select form-control @error('produk') is-invalid @enderror"
                                            id="editKeluarProduk" aria-label="Floating label select example"
                                            name="produk">
                                            <option selected disabled>Pilih Barang</option>
                                            @foreach ($produks as $pro)
                                                <option value="{{ $pro->id }}" class="text-capitalize">
                                                    {{ $pro->nama_barang }}</option>
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
                                            class="form-control @error('jml_keluar') is-invalid @enderror"
                                            id="editKeluarJml_keluar" placeholder="name@example.com" name="jml_keluar">
                                        <label for="editKeluarJml_keluar">Qty</label>
                                    </div>
                                    @error('jml_keluar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text"
                                            class="form-control text-uppercase @error('no_dokumen') is-invalid @enderror"
                                            id="editKeluarNodok" placeholder="Invoice" name="no_dokumen">
                                        <label for="editKeluarNodok">Nomor Dokumen</label>
                                    </div>
                                    @error('no_dokumen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text"
                                            class="form-control @error('keterangan') is-invalid @enderror"
                                            id="editKeluarKeterangan" placeholder="Keterangan" name="keterangan">
                                        <label for="editKeluarKeterangan">Keterangan</label>
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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('#keluarModalEdit').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var keluarId = button.data('id'); // Extract info from data-* attributes

                    // AJAX request to get the user data
                    $.ajax({
                        url: '/keluar/' + keluarId + '/edit',
                        method: 'GET',
                        success: function(data) {
                            $('#editKeluarId').val(data.id);
                            $('#editKeluarProduk').val(data.produk_id);
                            $('#editKeluarNodok').val(data.no_dokumen);
                            $('#editKeluarJml_keluar').val(data.stok_keluar);
                            $('#editKeluarKeterangan').val(data.keterangan);
                        }
                    });
                });
            });
        </script>
    @endsection
