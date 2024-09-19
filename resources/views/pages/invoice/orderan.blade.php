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
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="invoice-container">
                            <div class="invoice-header">
                                <!-- Row start -->
                                <!-- Row end -->
                                <!-- Row start -->
                                <div class="row gutters">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                        <address class="text-left">
                                            PT. Bla Bla Bla<br>
                                            Jalan Merdeka No. 12 Indonesia<br>
                                            00000 00000
                                        </address>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <address class="text-right">
                                            {{ $order->supplier->name }}<br>
                                            {{ $order->supplier->alamat }}<br>
                                            {{ $order->supplier->kontak }}
                                        </address>
                                    </div>
                                </div>
                                <!-- Row end -->
                                <!-- Row start -->
                                <div class="row gutters">
                                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                        <div class="invoice-details">
                                            {{-- <address>
                                                Administrator<br>
                                                Jalan Pegadaian No 00 Indonesia
                                            </address> --}}
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                        <div class="invoice-details">
                                            <div class="invoice-num">
                                                <div>No Invoice - #{{ $order->no_order }}</div>
                                                <div>{{ date('d F Y', strtotime($order->created_at)) }}</div>
                                            </div>
                                        </div>
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
                                                        <th>Kode Barang</th>
                                                        <th>Nama Barang</th>
                                                        <th>Satuan</th>
                                                        <th>Quantity</th>
                                                        <th class="text-right">@ Harga</th>
                                                        <th class="text-right">Sub Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orders as $order)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>

                                                            <td>
                                                                {{ $order->produk->kode_barang }}
                                                            </td>
                                                            <td>
                                                                {{ $order->produk->nama_barang }}
                                                            </td>
                                                            <td>
                                                                {{ $order->satuan }}
                                                            </td>
                                                            <td>
                                                                {{ $order->qty }}
                                                            </td>
                                                            <td class="text-right">
                                                                {{ 'Rp ' . number_format($order->harga_barang, 0, ',', '.') }}
                                                            </td>

                                                            <td class="text-right">
                                                                {{ 'Rp ' . number_format($order->sub_total, 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    <tr>
                                                        <td colspan="4"></td>
                                                        <td colspan="2">{{ $total->qty }}</td>

                                                        <td class="text-right">
                                                            {{ 'Rp ' . number_format($total->total_harga, 0, ',', '.') }}

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-right">
                                                            <h5 class="text-success"><strong>Total</strong></h5>
                                                        </td>
                                                        <td colspan="4" class="text-right">
                                                            <h5 class="text-success"><strong>
                                                                    {{ 'Rp ' . number_format($total->total_harga, 0, ',', '.') }}
                                                                </strong></h5>
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
