<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ url('css/style.css') }}" rel="stylesheet">
    <link href="{{ url('css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ url('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">


</head>

<body>
    <div class="container">
        <div class="row gutters">
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="invoice-container">
                            <div class="invoice-header">
                                <div class="row gutters">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 invoice-details text-center">
                                        <h5>{{ $resep->nama_resep }}</h5>
                                        <label for=""></label>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 invoice-details">
                                        <div class="invoice-num">
                                            <div>No Resep - #{{ $resep->no_resep }}</div>
                                            <div>{{ date('d F Y', strtotime($resep->created_at)) }}</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Row end -->
                            </div>
                            <div class="invoice-body">
                                <!-- Row start -->
                                <div class="row gutters">
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="table-responsive">
                                            <table class="table ">
                                                {{-- <thead> --}}
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Bahan</th>
                                                    <th>Satuan</th>
                                                    <th>Qty</th>
                                                </tr>
                                                <tbody>
                                                    @foreach ($reseps as $resep)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                {{ $resep->baku->name }}
                                                            </td>
                                                            <td>
                                                                {{ $resep->baku->satuan }}
                                                            </td>
                                                            <td>
                                                                {{ $resep->qty }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="gutters">
                                    <h5>Instruksi Resep:</h5>
                                    <div class="text-capitalize">
                                        {!! $resep->instruksi !!}
                                    </div>
                                </div>
                                <!-- Row end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<script>
    window.print();
</script>

</html>
