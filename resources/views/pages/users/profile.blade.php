@extends('layouts.main')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Profile <label class="text-uppercase"
                    for="">{{ $user->name }}</label></h6>
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
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3 align-content-center ml-5">
                    @if ($user->profile == null)
                        @if ($user->gender == 1)
                            <img style="width: 150px;height:150px" alt="image" src="{{ asset('assets/laki-laki.svg') }}"
                                class="img-profile rounded-circle">
                        @else
                            <img style="width: 150px;height:150px" alt="image" src="{{ asset('assets/perempuan.svg') }}"
                                class="img-profile rounded-circle">
                        @endif
                    @else
                        <img alt="image" src="{{ url('uploads/' . $user->profile) }}" style="width: 150px;height:150px"
                            class="rounded-circle mr-1">
                    @endif

                    <h6 class="mt-2">Upload a different photo...</h6>
                    <form action="{{ route('update.photo', $user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="file" class="text-center center-block file-upload" name="profile">
                        <button type="submit" class="my-2 btn btn-sm btn-info">Upload Foto</button>
                    </form>
                </div>
                <div class="col-sm-8">
                    <form action="{{ route('update.profile', $user->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating mb-3">
                                    <input type="name" class="form-control @error('name') is-invalid @enderror"
                                        id="floatingInput" placeholder="Nama Users" name="name"
                                        value="{{ $user->name }}">
                                    <label for="floatingInput">Nama Lengkap</label>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating mb-3">
                                    <select class="form-select form-control @error('gender') is-invalid @enderror"
                                        id="floatingSelect" aria-label="Floating label select example" name="gender">
                                        <option selected disabled>Open this select menu</option>
                                        {{-- @foreach ($users as $jk)
                                            <option value="{{ $jk->id }}"
                                                >
                                                {{ $jk->gende }}</option>
                                        @endforeach --}}
                                        <option value="1" {{ $user->gender == 1 ? 'selected="selected"' : '' }}>
                                            Laki-Laki</option>
                                        <option value="2" {{ $user->gender == 2 ? 'selected="selected"' : '' }}>
                                            Perempuan</option>
                                    </select>
                                    <label for="floatingSelect">Jenis Kelamin</label>
                                </div>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="floatingInput" placeholder="name@example.com" name="email"
                                        value="{{ $user->email }}">
                                    <label for="floatingInput">Email</label>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="floatingInput" placeholder="Password" name="password">
                                    <label for="floatingInput">Password</label>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <button type="submit" class="btn btn-primary w-25">Update</button>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
