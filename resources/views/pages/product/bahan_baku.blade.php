@extends('layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $judul }}</h1>
    </div>
    <div class="wrapper-table bg-white rounded ">
        <div class="card shadow ">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold my-2"><a href="#" data-toggle="modal" data-target="#supplierModal"
                        class="btn btn-primary ">+ Bahan Baku</a></h6>
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
                            <th>Bahan Baku</th>
                            <th>Satuan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    {{-- <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Bahan Baku</th>
                            <th>Satuan</th>
                            <th>Action</th>
                        </tr>
                    </tfoot> --}}
                    <tbody>
                        @foreach ($bakus as $baku)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-capitalize">{{ $baku->name }}</td>
                                <td class="text-capitalize">{{ $baku->satuan }}</td>

                                <td><a href="#" data-toggle="modal" data-target="#supplierModalEdit"
                                        class="btn btn-primary btn-circle btn-sm" data-id="{{ $baku->id }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('delete.baku', $baku->id) }}" method="post" class="d-inline">
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
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Bahan Baku</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('add.baku') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="floatingInput" placeholder="Nama Users" name="name">
                                    <label for="floatingInput">Nama </label>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating">
                                    <select class="form-select form-control @error('satuan') is-invalid @enderror"
                                        id="floatingSelect" aria-label="Floating label select example" name="satuan">
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
        <div class="modal-dialog modal-sm" role="document">
            <form id="editSupplierForm" action="{{ route('update.baku') }}" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editBakuId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Bahan Baku</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="editBakuName" placeholder="Nama Users" name="name">
                                    <label for="editSupplierName">Nama </label>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating">
                                    <select class="form-select form-control @error('satuan') is-invalid @enderror"
                                        id="editSatuan" aria-label="Floating label select example" name="satuan">
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
                var bahanId = button.data('id'); // Extract info from data-* attributes

                // AJAX request to get the user data
                $.ajax({
                    url: '/baku/' + bahanId + '/edit',
                    method: 'GET',
                    success: function(data) {
                        $('#editBakuId').val(data.id);
                        $('#editBakuName').val(data.name);
                        $('#editSatuan').val(data.satuan);
                    }
                });
            });
        });
    </script>
@endsection
