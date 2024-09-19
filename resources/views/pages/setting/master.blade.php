@extends('layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $judul }}</h1>
    </div>
    <div class="wrapper-table bg-white rounded ">
        <div class="card shadow ">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold my-2"><a href="#" data-toggle="modal" data-target="#supplierModal"
                        class="btn btn-primary ">+ Akun</a></h6>
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
                            <th>Nama Akun</th>
                            <th>Kategori</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama Akun</th>
                            <th>Kategori</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($masters as $sup)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sup->name }}</td>
                                <td>{{ $sup->kategori }}</td>
                                <td><a href="#" data-toggle="modal" data-target="#supplierModalEdit"
                                        class="btn btn-primary btn-circle btn-sm" data-id="{{ $sup->id }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('delete.master', $sup->id) }}" method="post" class="d-inline">
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Akun</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('add.master') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="floatingInput" placeholder="Nama Users" name="name">
                                    <label for="floatingInput">Nama Akun</label>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating">
                                    <select class="form-select form-control @error('satuan') is-invalid @enderror"
                                        id="editProdukSatuan" aria-label="Floating label select example" name="kategori">
                                        <option selected disabled>Pilih Kategori</option>
                                        <option value="Aktiva Lancar">Aktiva Lancar</option>
                                        <option value="Aktiva Tetap">Aktiva Tetap</option>
                                        <option value="Kewajiban">Kewajiban</option>
                                        <option value="Ekuitas">Ekuitas</option>
                                        <option value="Pendapatan">Pendapatan</option>
                                        <option value="Beban">Beban</option>
                                    </select>
                                    <label for="editProdukSatuan">Kategori</label>
                                </div>
                                @error('satuan')
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
            <form id="editSupplierForm" action="{{ route('update.master') }}" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editMasterId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Master Akun</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="editMasterName" placeholder="Nama Users" name="name">
                                    <label for="editMasterName">Nama Akun</label>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating">
                                    <select class="form-select form-control @error('satuan') is-invalid @enderror"
                                        id="editKategori" aria-label="Floating label select example" name="kategori">
                                        <option selected disabled>Pilih Kategori</option>
                                        <option value="Aktiva Lancar">Aktiva Lancar</option>
                                        <option value="Aktiva Tetap">Aktiva Tetap</option>
                                        <option value="Kewajiban">Kewajiban</option>
                                        <option value="Ekuitas">Ekuitas</option>
                                        <option value="Pendapatan">Pendapatan</option>
                                        <option value="Beban">Beban</option>
                                    </select>
                                    <label for="editProdukSatuan">Kategori</label>
                                </div>
                                @error('satuan')
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
                var masterId = button.data('id'); // Extract info from data-* attributes

                // AJAX request to get the user data
                $.ajax({
                    url: '/master/' + masterId + '/edit',
                    method: 'GET',
                    success: function(data) {
                        $('#editMasterId').val(data.id);
                        $('#editMasterName').val(data.name);
                        $('#editKategori').val(data.kategori);
                    }
                });
            });
        });
    </script>
@endsection
