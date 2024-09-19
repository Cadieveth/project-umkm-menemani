@extends('layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $judul }}</h1>
    </div>
    <div class="wrapper-table bg-white rounded ">
        <div class="card shadow ">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold my-2"><a href="#" data-toggle="modal" data-target="#supplierModal"
                        class="btn btn-primary ">+ Supplier</a></h6>
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
                            <th>Nama Supplier</th>
                            <th>Alamat</th>
                            <th>Email</th>
                            <th>Kontak</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama Supplier</th>
                            <th>Alamat</th>
                            <th>Email</th>
                            <th>Kontak</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($suppliers as $sup)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-capitalize">{{ $sup->name }}</td>
                                <td class="text-capitalize">{{ $sup->alamat }}</td>
                                <td> <a href="mailto:{{ $sup->email }}" target="_top">{{ $sup->email }}</a></td>
                                <td><a href="https://api.whatsapp.com/send/?phone=%2B62{{ $sup->kontak }}&text&type=phone_number&app_absent=0"
                                        target="_top">{{ $sup->kontak }}</a>
                                </td>
                                <td><a href="#" data-toggle="modal" data-target="#supplierModalEdit"
                                        class="btn btn-primary btn-circle btn-sm" data-id="{{ $sup->id }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('delete.supplier', $sup->id) }}" method="post"
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

    <div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Supplier</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('add.supplier') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="floatingInput" placeholder="Nama Users" name="name">
                                    <label for="floatingInput">Nama Supplier</label>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-floating mb-3">
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat" name="alamat"
                                        id="floatingTextarea"></textarea>
                                    <label for="floatingTextarea">Alamat</label>
                                </div>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="floatingInput" placeholder="name@example.com" name="email">
                                    <label for="floatingInput">Email</label>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('kontak') is-invalid @enderror"
                                        id="floatingInput" placeholder="Kontak" name="kontak">
                                    <label for="floatingInput">Kontak</label>
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
        <div class="modal-dialog modal-lg" role="document">
            <form id="editSupplierForm" action="{{ route('update.supplier') }}" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editSupplierId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Supplier</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="editSupplierName" placeholder="Nama Users" name="name">
                                    <label for="editSupplierName">Nama Supplier</label>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('alamat') is-invalid @enderror"
                                        id="editSupplierAlamat" placeholder="Alamat" name="alamat">
                                    <label for="editSupplierName">Alamat</label>
                                </div>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="editSupplierEmail" placeholder="name@example.com" name="email">
                                    <label for="editSupplierEmail">Email</label>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('kontak') is-invalid @enderror"
                                        id="editSupplierKontak" placeholder="Kontak" name="kontak">
                                    <label for="editSupplierKontak">Kontak</label>
                                </div>
                                @error('name')
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
                var supplierId = button.data('id'); // Extract info from data-* attributes

                // AJAX request to get the user data
                $.ajax({
                    url: '/supplier/' + supplierId + '/edit',
                    method: 'GET',
                    success: function(data) {
                        $('#editSupplierId').val(data.id);
                        $('#editSupplierName').val(data.name);
                        $('#editSupplierAlamat').val(data.alamat);
                        $('#editSupplierEmail').val(data.email);
                        $('#editSupplierKontak').val(data.kontak);
                    }
                });
            });
        });
    </script>
@endsection
