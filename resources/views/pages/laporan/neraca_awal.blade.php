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
        <h1 class="h3 mb-0 text-gray-800">{{ $judul }}</h1>
    </div>

    <div action="{{ route('neraca_awal') }}" method="GET">
        <div class="wrapper-table bg-white rounded ">
            <div class="card shadow ">

                <div class="card-header">
                    <h6 class="mb-1 font-weight-bold"><a href="#" data-toggle="modal" data-target="#addDataModal"
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

                <div class="card-body">
                    <div class="card">
                        {{-- Header  --}}
                        <div class="card-header text-center">
                            <h6 class="text-uppercase "><b>{{ $setting->company_name }}</b></h6>
                            <h6 class="text-capitalize"><b>Laporan Posisi Saldo Awal</b></h6>
                        </div>

                        {{-- Main Content  --}}
                        <div class="card-body">
                            <div class="row ">
                                {{-- AKTIVA  --}}
                                <div class="col-sm-6 ">
                                    <center> <span class="text-uppercase"><b>Aktiva</b></span></center>
                                    <span class="text-capitalize"><b>Aktiva Lancar</b></span>
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <span>Kas</span>
                                        </div>
                                        <div class="col-sm-6">
                                            @if ($saldoKas)
                                                <span>{{ 'Rp ' . number_format($saldoKas, 0, ',', '.') }}</span>
                                            @else
                                                <span>{{ 'Rp ' . number_format(0, 0, ',', '.') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-sm-6">
                                            <span><a href="{{ route('detail_saldo') }}">Persediaan Bahan
                                                    Baku</a></span>
                                        </div>
                                        <div class="col-sm-6">
                                            @if ($saldoPBB)
                                                <span>{{ 'Rp ' . number_format($saldoPBB, 0, ',', '.') }}</span>
                                            @else
                                                <span>{{ 'Rp ' . number_format(0, 0, ',', '.') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-sm-6">
                                            <span><a href="{{ route('detail_saldo') }}">Persediaan Produk Jadi</a></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span><u class="mt-2">
                                                    @if ($saldoPPJ)
                                                        <span>{{ 'Rp ' . number_format($saldoPPJ, 0, ',', '.') }}</span>
                                                    @else
                                                        <span>{{ 'Rp ' . number_format(0, 0, ',', '.') }}</span>
                                                    @endif
                                                </u>
                                                <sub>+</sub>
                                            </span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span><b>Jumlah</b></span>
                                        </div>
                                        <div class="col-sm-6">
                                            @if ($totalSaldoKas)
                                                <span><b>{{ 'Rp ' . number_format($totalSaldoKas, 0, ',', '.') }}</b></span>
                                            @else
                                                <span><b>{{ 'Rp ' . number_format(0, 0, ',', '.') }}</b></span>
                                            @endif
                                        </div>
                                    </div>

                                    <span class="text-capitalize"><b>Aktiva Tetap</b></span>
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <span><a href="{{ route('aset') }}">Peralatan</a></span>
                                        </div>
                                        <div class="col-sm-6">
                                            @if ($saldoAset)
                                                <span>{{ 'Rp ' . number_format($saldoAset, 0, ',', '.') }}</span>
                                            @else
                                                <span>{{ 'Rp ' . number_format(0, 0, ',', '.') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-sm-6">
                                            <span><b>Jumlah</b></span>
                                        </div>
                                        <div class="col-sm-6 ">
                                            <span><u class="mt-2">
                                                    @if ($saldoAset)
                                                        <span><b>{{ 'Rp ' . number_format($saldoAset, 0, ',', '.') }}</b></span>
                                                    @else
                                                        <span><b>{{ 'Rp ' . number_format(0, 0, ',', '.') }}</b></span>
                                                    @endif
                                                </u>
                                                <sub>+</sub>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <span><b>Total Aktiva</b></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span>
                                                @if ($totalAktiva)
                                                    <span><b>{{ 'Rp ' . number_format($totalAktiva, 0, ',', '.') }}</b></span>
                                                @else
                                                    <span><b>{{ 'Rp ' . number_format(0, 0, ',', '.') }}</b></span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- LIABILITAS DAN EKUITAS --}}
                                <div class="col-sm-6">
                                    <center> <span class="text-uppercase"><b>kewajiban</b></span></center>
                                    <span class="text-capitalize"><b>liabilitas</b></span>
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <span>Utang Gaji</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span><u>
                                                    @if ($saldoHutangGaji)
                                                        <span>{{ 'Rp ' . number_format($saldoHutangGaji, 0, ',', '.') }}</span>
                                                    @else
                                                        <span>{{ 'Rp ' . number_format(0, 0, ',', '.') }}</span>
                                                    @endif
                                                    <sub>+</sub>
                                                </u></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span><b>Jumlah Liabilitas</b></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span>
                                                @if ($totalLiabilitas)
                                                    <span><b>{{ 'Rp ' . number_format($totalLiabilitas, 0, ',', '.') }}</b></span>
                                                @else
                                                    <span><b>{{ 'Rp ' . number_format(0, 0, ',', '.') }}</b></span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <span class="text-capitalize"><b>ekuitas</b></span>
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <span>Modal</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span>
                                                @if ($totalModal)
                                                    <span>{{ 'Rp ' . number_format($totalModal, 0, ',', '.') }}</span>
                                                @else
                                                    <span>{{ 'Rp ' . number_format(0, 0, ',', '.') }}</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span><b>Jumlah</b></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span>
                                                @if ($totalEkuitas)
                                                    <span><b>{{ 'Rp ' . number_format($totalEkuitas, 0, ',', '.') }}</b></span>
                                                @else
                                                    <span><b>{{ 'Rp ' . number_format(0, 0, ',', '.') }}</b></span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 invisible">
                                        <span>Laba / Rugi</span>
                                    </div>
                                    <div class="col-sm-6 invisible">
                                        <span></span>
                                    </div>
                                    <div class="col-sm-6 invisible">
                                        <span>Laba / Rugi</span>
                                    </div>
                                    <div class="col-sm-6 invisible">
                                        <span></span>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <span><b>Total Liabilitas dan Ekuitas</b></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span>
                                                @if ($totalLiabilitasDanEkuitas)
                                                    <span><b>{{ 'Rp ' . number_format($totalLiabilitasDanEkuitas, 0, ',', '.') }}</b></span>
                                                @else
                                                    <span><b>{{ 'Rp ' . number_format(0, 0, ',', '.') }}</b></span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                {{-- Modal Add  --}}
                <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Saldo Awal</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('add.neraca_awal') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div style="width: 100%">
                                                <div class="form-floating mb-3">
                                                    <select
                                                        class="form-select form-control @error('akun') is-invalid @enderror"
                                                        id="floatingSelect" aria-label="Floating label select example"
                                                        name="akun">
                                                        <option selected disabled>Pilih Akun</option>
                                                        <option value="Kas">Kas</option>
                                                        {{-- <option value="Persediaan Bahan Baku">Persediaan Bahan Baku</option>
                                                        <option value="Persediaan Produk Jadi">Persediaan Produk Jadi
                                                        </option>
                                                        <option value="Hutang Gaji">Hutang Gaji</option> --}}
                                                    </select>
                                                    <label for="floatingSelect">Akun</label>
                                                </div>
                                                @error('akun')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div style="width: 100%">
                                                <div class="form-floating mb-3">
                                                    <input type="number"
                                                        class="form-control @error('nominal') is-invalid @enderror"
                                                        id="floatingInput" placeholder="Nominal Saldo" name="nominal">
                                                    <label for="floatingInput">Nominal Saldo</label>
                                                </div>
                                                @error('nominal')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-warning" type="button"
                                                data-dismiss="modal">Cancel</button>
                                            <button class="btn btn-primary" type="submit">Simpan</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
