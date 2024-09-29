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
        <h1 class="h3 mb-0 text-gray-800 d-flex align-items-center">
            <a class="nav-link me-2" href="{{ route('neraca_awal') }}">
                <i class="fas fa-solid fa-chevron-left"></i>
            </a>
            {{ $judul }}
        </h1>

    </div>

    <div class="wrapper-table bg-white rounded ">
        <div class="card shadow ">
            <div class="card-header">
                <h6 class="mb-2 font-weight-bold"><a href="#" data-toggle="modal" data-target="#addDataAset"
                        class="btn btn-primary ">+ Aset</a></h6>
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
            <div class="mb-2">
                <div>Saldo Peralatan : {{ 'Rp ' . number_format($saldoAset, 0, ',', '.') }}</div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($asets as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->kode_aset }}</td>
                                <td>{{ $data->nama_aset }}</td>
                                <td>{{ $data->jumlah_aset }}</td>
                                <td>{{ 'Rp ' . number_format($data->harga_aset, 0, ',', '.') }}</td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#editDataAset"
                                        class="btn btn-primary btn-circle btn-sm" data-id="{{ $data->id }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('delete.aset', $data->id) }}" method="post" class="d-inline">
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

        {{-- MODAL ADD DATA  --}}
        <div class="modal fade" id="addDataAset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-l" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Form Data Peralatan</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row ">
                            <div class="col-sm-12">
                                <form id="formResep" action="{{ route('add.aset') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mt-2 mb-4">
                                        <div class="col-sm-12 mb-3">
                                            <div class="form-floating">
                                                <input type="text"
                                                    class="form-control @error('nama_aset') is-invalid @enderror"
                                                    id="floatingInput" placeholder="x" name="nama_aset">
                                                <label for="floatingInput">Nama</label>
                                            </div>
                                            @error('nama_aset')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <div class="form-floating">
                                                <input type="number"
                                                    class="form-control @error('jumlah_aset') is-invalid @enderror"
                                                    id="floatingInput" placeholder="x" name="jumlah_aset">
                                                <label for="floatingInput">Jumlah</label>
                                            </div>
                                            @error('jumlah_aset')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-floating">
                                                <input type="number"
                                                    class="form-control @error('harga_aset') is-invalid @enderror"
                                                    id="floatingInput" placeholder="x" name="harga_aset">
                                                <label for="floatingInput">Harga</label>
                                            </div>
                                            @error('harga_aset')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL EDIT DATA  --}}
        <div class="modal fade" id="editDataAset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-l" role="document">
                <form id="editSupplierForm" action="{{ route('update.aset') }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="editKasId">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Form Edit Data Peralatan</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row ">
                                <div class="col-sm-12">
                                    <div class="row mt-2 mb-4">
                                        {{-- <div class="col-sm-12 mb-3">
                                            <div class="form-floating">
                                                <input type="text"
                                                    class="form-control @error('kode_aset') is-invalid @enderror"
                                                    id="floatingInput" placeholder="x" name="kode_aset">
                                                <label for="floatingInput">Kode Barang</label>
                                            </div>
                                            @error('kode_aset')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div> --}}

                                        <div class="col-sm-12 mb-3">
                                            <div class="form-floating">
                                                <input type="text"
                                                    class="form-control @error('nama_aset') is-invalid @enderror"
                                                    id="floatingInput" placeholder="x" name="nama_aset">
                                                <label for="floatingInput">Nama Barang</label>
                                            </div>
                                            @error('nama_aset')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-sm-12 mb-3">
                                            <div class="form-floating">
                                                <input type="number"
                                                    class="form-control @error('jumlah_aset') is-invalid @enderror"
                                                    id="floatingInput" placeholder="x" name="jumlah_aset">
                                                <label for="floatingInput">Jumlah</label>
                                            </div>
                                            @error('jumlah_aset')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-floating">
                                                <input type="number"
                                                    class="form-control @error('harga_aset') is-invalid @enderror"
                                                    id="floatingInput" placeholder="x" name="harga_aset">
                                                <label for="floatingInput">Harga Satuan</label>
                                            </div>
                                            @error('harga_aset')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-warning" type="button"
                                            data-dismiss="modal">Cancel</button>
                                        <button class="btn btn-primary" type="submit">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script>
            $(document).on('click', '[data-target="#editDataAset"]', function(e) {
                e.preventDefault();
                var dataId = $(this).data('id');

                // Lakukan AJAX request untuk mendapatkan data detail
                $.ajax({
                    url: `/aset/${dataId}/edit`,
                    type: 'GET',
                    success: function(data) {
                        // Set nilai data ke dalam input form di modal
                        $('#editSupplierForm input[name="id"]').val(data.id);
                        $('#editSupplierForm input[name="nama_aset"]').val(data.nama_aset);
                        $('#editSupplierForm input[name="jumlah_aset"]').val(data.jumlah_aset);
                        $('#editSupplierForm input[name="harga_aset"]').val(data.harga_aset);
                        $('#editSupplierForm select[name="kode_aset"]').val(data.kode_aset);

                        // Buka modal edit
                        $('#editDataAset').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            });
        </script>
    @endsection
