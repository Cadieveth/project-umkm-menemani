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
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="invoice-container">
                            <div class="invoice-header">

                                <!-- Row end -->
                                <!-- Row start -->
                                <div class="row gutters">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 invoice-details">
                                        {{-- <div > --}}
                                        <address>
                                            {{ $transaksi->user->name }}<br>
                                            {{ $transaksi->user->email }}
                                        </address>
                                        {{-- </div> --}}
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 invoice-details">
                                        {{-- <div class="invoice-details"> --}}
                                        <div class="invoice-num">
                                            <div>Invoice - #{{ $transaksi->no_transaksi }}</div>
                                            <div>{{ date('d F Y', strtotime($transaksi->created_at)) }}</div>
                                        </div>
                                        {{-- </div> --}}
                                    </div>
                                </div>
                                <!-- Row end -->
                            </div>
                            <div class="invoice-body">
                                <!-- Row start -->
                                <div class="row gutters">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table custom-table m-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Kode Product</th>
                                                        <th>Nama Product</th>
                                                        <th>Quantity</th>
                                                        <th class="text-right">@ Harga</th>
                                                        <th class="text-right">Sub Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($transaksis as $transaksi)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                {{ $transaksi->produkSell->kode_product }}
                                                            </td>
                                                            <td>
                                                                {{ $transaksi->produkSell->nama_product }}
                                                            </td>
                                                            <td>
                                                                {{ $transaksi->qty }}

                                                            </td>
                                                            <td class="text-right">
                                                                {{ 'Rp ' . number_format($transaksi->produkSell->harga_jual, 0, ',', '.') }}

                                                            </td>
                                                            <td class="text-right">
                                                                {{ 'Rp ' . number_format($transaksi->sub_total, 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="3" class="text-right">
                                                            <label for=""><strong>Total :</strong></label>
                                                        </td>
                                                        <td class="text-right" colspan="2">
                                                            <strong>
                                                                <label>
                                                                    {{ 'Rp ' . number_format($total->total_harga, 0, ',', '.') }}
                                                                </label>
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
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
