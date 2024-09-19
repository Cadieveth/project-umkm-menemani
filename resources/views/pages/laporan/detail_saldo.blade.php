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
                <h6 class="mb-2 font-weight-bold"><a href="#" data-toggle="modal" data-target="#addDataDetail"
                        class="btn btn-primary ">+ Data</a></h6>
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
                <div>Saldo Persediaan Bahan Baku : {{ 'Rp ' . number_format($saldoPBB, 0, ',', '.') }}</div>
                <div>Saldo Persediaan Produk Jadi: {{ 'Rp ' . number_format($saldoPPJ, 0, ',', '.') }}</div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Jumlah Stok</th>
                            <th>Satuan</th>
                            <th>Keterangan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($details as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->kode }}</td>
                                <td>
                                    @if ($data->satuan === 'Gram')
                                        {{ 'Rp ' . number_format($data->harga / 1000, 0, ',', '.') }}
                                    @else
                                        {{ 'Rp ' . number_format($data->harga, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td>
                                    @if ($data->satuan === 'Gram')
                                        {{ $data->jumlah_stok * 1000 }}
                                    @else
                                        {{ $data->jumlah_stok }}
                                    @endif
                                </td>
                                <td>{{ $data->satuan }}</td>
                                <td>{{ $data->ket }}</td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#modalEditData"
                                        class="btn btn-primary btn-circle btn-sm" data-id="{{ $data->id }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('delete.detail_saldo', $data->id) }}" method="post"
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

        {{-- MODAL ADD DATA  --}}
        <div class="modal fade" id="addDataDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Data Persediaan Awal</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row ">
                            <div class="col-sm-12">
                                <form id="formResep" action="{{ route('add.detail_saldo') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mt-2 mb-4">
                                        <div class="col-sm-6 mb-3">
                                            <label for="inputState"
                                                class="form-label font-weight-bold text-primary">Nama</label>
                                            <div class="form-floating">
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    id="floatingInput" placeholder="x" name="name">
                                                <label for="floatingInput">Nama</label>
                                            </div>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label for="inputState"
                                                class="form-label font-weight-bold text-primary">Satuan</label>
                                            <div class="form-floating">
                                                <select
                                                    class="form-select form-control @error('satuan') is-invalid @enderror"
                                                    id="floatingSelect" aria-label="Floating label select example"
                                                    name="satuan">
                                                    <option selected disabled>Pilih Satuan</option>
                                                    <option value="Liter">Liter</option>
                                                    {{-- <option value="KG">KG</option> --}}
                                                    <option value="Gram">Gram</option>
                                                    <option value="PCS">PCS</option>
                                                    <option value="Unit">Unit</option>
                                                </select>
                                                <label for="floatingSelect">Satuan</label>
                                            </div>
                                            @error('satuan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mb-1">
                                            <label for="inputState" class="form-label font-weight-bold text-primary">Jumlah
                                                Stok</label>
                                            <div class="form-floating">
                                                <input type="number"
                                                    class="form-control @error('jumlah_stok') is-invalid @enderror"
                                                    id="floatingInput" placeholder="x" name="jumlah_stok">
                                                <label for="floatingInput">Jumlah</label>
                                                <div class="d-flex justify-content-end" style="font-size: 10px">Jumlah per
                                                    KG, jika satuan
                                                    Gram</div>
                                            </div>
                                            @error('jumlah_stok')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-sm-6 mb-1">
                                            <label for="inputState"
                                                class="form-label font-weight-bold text-primary">harga</label>
                                            <div class="form-floating">
                                                <input type="number"
                                                    class="form-control @error('harga') is-invalid @enderror"
                                                    id="floatingInput" placeholder="x" name="harga">
                                                <label for="floatingInput">Harga</label>
                                                <div class="d-flex justify-content-end" style="font-size: 10px">Harga per
                                                    KG, jika satuan Gram</div>
                                            </div>
                                            @error('harga')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="inputState"
                                                class="form-label font-weight-bold text-primary">Kelompok
                                                Persediaan</label>
                                            <div class="form-floating">
                                                <select class="form-select form-control @error('ket') is-invalid @enderror"
                                                    id="floatingSelect" aria-label="Floating label select example"
                                                    name="ket">
                                                    <option selected disabled>Pilih Keterangan</option>
                                                    <option value="Persediaan Bahan Baku">Bahan Baku</option>
                                                    <option value="Persediaan Produk Jadi">Produk Jadi</option>
                                                </select>
                                                <label for="floatingSelect">Persediaan</label>
                                            </div>
                                            @error('ket')
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
        <div class="modal fade" id="modalEditData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <form id="editSupplierForm" action="{{ route('update.detail_saldo') }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="editKasId">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Data Persediaan Awal</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row ">
                                <div class="col-sm-12">
                                    <div class="row mt-2 mb-4">
                                        <div class="col-sm-6 mb-3">
                                            <label for="inputState"
                                                class="form-label font-weight-bold text-primary">Nama</label>
                                            <div class="form-floating">
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    id="floatingInput" placeholder="x" name="name">
                                                <label for="floatingInput">Nama</label>
                                            </div>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label for="inputState"
                                                class="form-label font-weight-bold text-primary">Satuan</label>
                                            <div class="form-floating">
                                                <select
                                                    class="form-select form-control @error('satuan') is-invalid @enderror"
                                                    id="floatingSelect" aria-label="Floating label select example"
                                                    name="satuan">
                                                    <option selected disabled>Pilih Satuan</option>
                                                    <option value="Liter">Liter</option>
                                                    {{-- <option value="KG">KG</option> --}}
                                                    <option value="Gram">Gram</option>
                                                    <option value="PCS">PCS</option>
                                                    <option value="Unit">Unit</option>
                                                </select>
                                                <label for="floatingSelect">Satuan</label>
                                            </div>
                                            @error('satuan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mb-1">
                                            <label for="inputState"
                                                class="form-label font-weight-bold text-primary">harga</label>
                                            <div class="form-floating">
                                                <input type="number"
                                                    class="form-control @error('harga') is-invalid @enderror"
                                                    id="floatingInput" placeholder="x" name="harga">
                                                <label for="floatingInput">Harga</label>
                                                <div class="d-flex justify-content-end" style="font-size: 10px">Harga per
                                                    KG, jika satuan
                                                    Gram</div>
                                            </div>
                                            @error('harga')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 mb-1">
                                            <label for="inputState"
                                                class="form-label font-weight-bold text-primary">Jumlah
                                                Stok</label>
                                            <div class="form-floating">
                                                <input type="number"
                                                    class="form-control @error('jumlah_stok') is-invalid @enderror"
                                                    id="floatingInput" placeholder="x" name="jumlah_stok">
                                                <label for="floatingInput">Jumlah</label>
                                                <div class="d-flex justify-content-end" style="font-size: 10px">Jumlah per
                                                    KG, jika satuan
                                                    Gram</div>
                                            </div>
                                            @error('jumlah_stok')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="inputState"
                                                class="form-label font-weight-bold text-primary">Kelompok
                                                Persediaan</label>
                                            <div class="form-floating">
                                                <select class="form-select form-control @error('ket') is-invalid @enderror"
                                                    id="floatingSelect" aria-label="Floating label select example"
                                                    name="ket">
                                                    <option selected disabled>Pilih Keterangan</option>
                                                    <option value="Persediaan Bahan Baku">Bahan Baku</option>
                                                    <option value="Persediaan Produk Jadi">Produk Jadi</option>
                                                </select>
                                                <label for="floatingSelect">Persediaan</label>
                                            </div>
                                            @error('ket')
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
            $(document).on('click', '[data-target="#modalEditData"]', function(e) {
                e.preventDefault();
                var detailId = $(this).data('id');

                // Lakukan AJAX request untuk mendapatkan data detail
                $.ajax({
                    url: `/detail_saldo/${detailId}/edit`,
                    type: 'GET',
                    success: function(data) {
                        // Set nilai data ke dalam input form di modal
                        $('#editSupplierForm input[name="id"]').val(data.id);
                        $('#editSupplierForm input[name="name"]').val(data.name);
                        $('#editSupplierForm input[name="harga"]').val(data.harga);
                        $('#editSupplierForm input[name="jumlah_stok"]').val(data.jumlah_stok);
                        $('#editSupplierForm select[name="satuan"]').val(data.satuan);
                        $('#editSupplierForm select[name="ket"]').val(data.ket);

                        // Buka modal edit
                        $('#modalEditData').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            });
        </script>
    @endsection
