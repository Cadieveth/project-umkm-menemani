@extends('layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $judul }}</h1>
    </div>
    <div class="wrapper-table bg-white rounded ">
        <div class="card shadow ">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold my-2"><a href="#" data-toggle="modal" data-target="#supplierModal"
                        class="btn btn-primary ">+ Kas Keluar</a></h6>
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

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Akun Kas</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    {{-- <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Akun Kas</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Action</th>
                        </tr>
                    </tfoot> --}}
                    <tbody>
                        @foreach ($allCashOut as $kas)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d/M/Y', strtotime($kas->created_at)) }}</td>
                                <td class="text-capitalize">{{ $kas->akun }}</td>
                                <td>
                                    {{ 'Rp ' . number_format($kas->nominal, 0, ',', '.') }}
                                </td>
                                <td class="text-capitalize">{{ $kas->keterangan }}</td>
                                <td><a href="#" data-toggle="modal" data-target="#supplierModalEdit"
                                        class="btn btn-primary btn-circle btn-sm" data-id="{{ $kas->id }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('delete.kas', $kas->id) }}" method="post" class="d-inline">
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

    <div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pengeluaran</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('add.kas') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating mb-3">
                                    <select class="form-select form-control @error('nama_barang') is-invalid @enderror"
                                        id="floatingSelect" aria-label="Floating label select example" name="akun">
                                        <option selected disabled>Pilih Akun </option>
                                        @foreach ($masters as $master)
                                            <option value="{{ $master->name }}" class="text-capitalize">
                                                {{ $master->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="floatingSelect">Pengeluaran</label>

                                </div>
                                @error('nama_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control @error('name') is-invalid @enderror"
                                        id="floatingInput" placeholder="Nama Users" name="nominal">
                                    <label for="floatingInput">Nominal Pengeluaran</label>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('kontak') is-invalid @enderror"
                                        id="floatingInput" placeholder="Kontak" name="ket">
                                    <label for="floatingInput">Keterangan</label>
                                </div>
                                @error('kontak')
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

    <div class="modal fade" id="supplierModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="editSupplierForm" action="{{ route('update.kas') }}" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editKasId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Pengeluaran</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                {{-- <div class="form-floating mb-3">
                                    <select class="form-select form-control @error('nama_barang') is-invalid @enderror"
                                        id="floatingSelect" aria-label="Floating label select example" name="akun">
                                        <option selected disabled>Pilih Akun </option>
                                        @foreach ($masters as $master)
                                            <option value="{{ $master->name }}" class="text-capitalize">
                                                {{ $master->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="floatingSelect">Pengeluaran</label>
                                </div>
                                @error('nama_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror --}}
                                <div class="form-floating mb-3">
                                    <select class="form-select form-control @error('nama_barang') is-invalid @enderror"
                                        id="editAkunDebet" aria-label="Floating label select example" name="akun">
                                        <option disabled>Pilih Akun </option>
                                        @foreach ($masters as $master)
                                            <option value="{{ $master->name }}" class="text-capitalize">
                                                {{ $master->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="editAkunDebet">Pengeluaran</label>
                                </div>
                                @error('nama_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control @error('name') is-invalid @enderror"
                                        id="editDebit" placeholder="Nama Users" name="nominal">
                                    <label for="floatingInput">Nominal Pengeluaran</label>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('kontak') is-invalid @enderror"
                                        id="editKet" placeholder="Kontak" name="ket">
                                    <label for="floatingInput">Keterangan</label>
                                </div>
                                @error('kontak')
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
            $('#supplierModalEdit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var kasId = button.data('id'); // Extract info from data-* attributes

                // AJAX request to get the user data
                $.ajax({
                    url: '/kas_keluar/' + kasId + '/edit',
                    method: 'GET',
                    success: function(data) {
                        $('#editKasId').val(data.id);
                        $('#editAkunDebet').val(data.akun_debet);
                        $('#editDebit').val(data.debit);
                        $('#editKet').val(data.ket);

                        $('#editAkunDebet option').each(function() {
                            if ($(this).val() === data.akun_debet) {
                                $(this).prop('selected', true);
                            } else {
                                $(this).prop('selected', false);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
