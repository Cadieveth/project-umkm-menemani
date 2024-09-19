@extends('layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $judul }}</h1>
    </div>

    <div class="wrapper-table bg-white rounded ">
        <div class="card shadow ">
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
        <div class="card-body" id="tableStok">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Nama Perusahaan</th>
                            <th>Pimpinan</th>
                            <th>Alamat</th>
                            <th>Logo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Nama Perusahaan</th>
                            <th>Pimpinan</th>
                            <th>Alamat</th>
                            <th>Logo</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($settings as $set)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $set->name }}</td>
                                <td>{{ $set->company_name }}</td>
                                <td>{{ $set->pimpinan }}</td>
                                <td>{{ $set->alamat }}</td>
                                <td>
                                    <center>
                                        @if ($set->image == null)
                                            <i class="fas fa-laugh-wink text-black"></i>
                                        @else
                                            <img alt="image" src="{{ url('uploads/' . $set->image) }}"
                                                style="width: 50px;height:50px;" class="rounded-circle mr-1">
                                        @endif
                                    </center>
                                </td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#stokModalEdit"
                                        class="btn btn-primary btn-circle btn-sm edit-user-btn"
                                        data-id="{{ $set->id }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Modal untuk Edit User -->
        <div class="modal fade" id="stokModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form id="editUserForm" action="{{ route('update.setting') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="editUserId">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Setting</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="editName" placeholder="Nama Users" name="name">
                                        <label for="editUserName">Nama</label>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text"
                                            class="form-control @error('company_name') is-invalid @enderror"
                                            id="editCompany" placeholder="Nama Users" name="company_name">
                                        <label for="editUserName">Nama Perusahaan</label>
                                    </div>
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('pimpinan') is-invalid @enderror"
                                            id="editPimpinan" placeholder="Nama Users" name="pimpinan">
                                        <label for="editUserName">Pimpinan Perusahaan</label>
                                    </div>
                                    @error('pimpinan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('alamat') is-invalid @enderror"
                                            id="editAlamat" placeholder="Nama Users" name="alamat">
                                        <label for="editUserName">Alamat Perusahaan</label>
                                    </div>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                            id="editUserName" placeholder="Nama Users" name="image">
                                        <label for="editUserName">Logo Perusahaan</label>
                                    </div>
                                    @error('image')
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
                $('#stokModalEdit').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var userId = button.data('id'); // Extract info from data-* attributes

                    // AJAX request to get the user data
                    $.ajax({
                        url: '/setting/' + userId + '/edit',
                        method: 'GET',
                        success: function(data) {
                            $('#editUserId').val(data.id);
                            $('#editName').val(data.name);
                            $('#editCompany').val(data.company_name);
                            $('#editPimpinan').val(data.pimpinan);
                            $('#editAlamat').val(data.alamat);
                        }
                    });
                });
            });
        </script>
    @endsection
