@extends('layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $judul }}</h1>
    </div>

    <div class="wrapper-table bg-white rounded ">
        <div class="card shadow ">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold"><a href="#" data-toggle="modal" data-target="#stokModal"
                        class="btn btn-primary ">+ Users</a></h6>
            </div>
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
                            <th>Nama Users</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Profile</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    {{-- <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama Users</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Profile</th>
                            <th>Action</th>
                        </tr>
                    </tfoot> --}}
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->role == 1)
                                        <label for=""><span>Administrator</span></label>
                                    @elseif ($user->role == 2)
                                        <label for=""><span>Gudang</span></label>
                                    @else
                                        <label for=""><span>Produksi</span></label>
                                    @endif
                                </td>
                                <td>
                                    <center>
                                        @if ($user->profile == null)
                                            @if ($user->gender == 1)
                                                <img alt="image" src="{{ asset('assets/laki-laki.svg') }}"
                                                    style="width: 50px;height:50px;" class="rounded-circle mr-1">
                                            @else
                                                <img alt="image" src="{{ asset('assets/perempuan.svg') }}"
                                                    style="width: 50px;height:50px;" class="rounded-circle mr-1">
                                            @endif
                                        @else
                                            <img alt="image" src="{{ url('uploads/' . $user->profile) }}"
                                                style="width: 50px;height:50px;" class="rounded-circle mr-1">
                                        @endif

                                    </center>
                                </td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#stokModalEdit"
                                        class="btn btn-primary btn-circle btn-sm edit-user-btn"
                                        data-id="{{ $user->id }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('delete.users', $user->id) }}" method="post" class="d-inline">
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
                <form action="{{ route('add.users') }}" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Users</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="name" class="form-control @error('name') is-invalid @enderror"
                                            id="floatingInput" placeholder="Nama Users" name="name">
                                        <label for="floatingInput">Nama Lengkap</label>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating">
                                        <select class="form-select form-control @error('gender') is-invalid @enderror"
                                            id="floatingSelect" aria-label="Floating label select example" name="gender">
                                            <option selected disabled>Open this select menu</option>
                                            <option value="1">Laki-Laki</option>
                                            <option value="2">Perempuan</option>
                                        </select>
                                        <label for="floatingSelect">Jenis Kelamin</label>
                                    </div>
                                    @error('gender')
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
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            id="floatingInput" placeholder="Password" name="password">
                                        <label for="floatingInput">Password</label>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-floating">
                                        <select class="form-select form-control @error('role') is-invalid @enderror"
                                            id="floatingSelect" aria-label="Floating label select example"
                                            name="role">
                                            <option selected disabled>Open this select menu</option>
                                            @foreach ($role as $list)
                                                <option value="{{ $list->id }}" class="text-capitalize">
                                                    {{ $list->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="floatingSelect">Role Users</label>
                                    </div>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-warning" type="button" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal untuk Edit User -->
        <div class="modal fade" id="stokModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form id="editUserForm" action="{{ route('update.users') }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="editUserId">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Data Users</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form fields, same as Add User Modal -->
                            <div class="row">
                                <!-- Fields: Nama, Gender, Email, Password, Role -->
                                <!-- Use the same fields as the Add User Modal -->
                                <!-- Each field should have an id that matches the editUserForm -->
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="name" class="form-control @error('name') is-invalid @enderror"
                                            id="editUserName" placeholder="Nama Users" name="name">
                                        <label for="editUserName">Nama Lengkap</label>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating">
                                        <select class="form-select form-control @error('gender') is-invalid @enderror"
                                            id="editUserGender" aria-label="Floating label select example"
                                            name="gender">
                                            <option selected disabled>Open this select menu</option>
                                            <option value="1">Laki-Laki</option>
                                            <option value="2">Perempuan</option>
                                        </select>
                                        <label for="editUserGender">Jenis Kelamin</label>
                                    </div>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="editUserEmail" placeholder="name@example.com" name="email">
                                        <label for="editUserEmail">Email</label>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            id="editUserPassword" placeholder="Password" name="password">
                                        <label for="editUserPassword">Password</label>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-floating">
                                        <select class="form-select form-control @error('role') is-invalid @enderror"
                                            id="editUserRole" aria-label="Floating label select example" name="role">
                                            <option selected disabled>Open this select menu</option>
                                            @foreach ($role as $list)
                                                <option value="{{ $list->id }}" class="text-capitalize">
                                                    {{ $list->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="editUserRole">Role Users</label>
                                    </div>
                                    @error('role')
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
                        url: '/users/' + userId + '/edit',
                        method: 'GET',
                        success: function(data) {
                            $('#editUserId').val(data.id);
                            $('#editUserName').val(data.name);
                            $('#editUserGender').val(data.gender);
                            $('#editUserEmail').val(data.email);
                            $('#editUserRole').val(data.role);
                        }
                    });
                });
            });
        </script>
    @endsection
