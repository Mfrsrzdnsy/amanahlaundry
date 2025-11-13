<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Struk Laundry - {{ $transaksi->kode_invoice }}</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            width: 260px;
            font-size: 12px;
            margin: 0 auto;
        }

        .center {
            text-align: center;
        }

        .line {
            border-bottom: 1px dashed #000;
            margin: 6px 0;
        }

        table {
            width: 100%;
        }

        td {
            vertical-align: top;
        }

        .right {
            text-align: right;
        }

        b {
            font-size: 13px;
        }
    </style>
</head>

<body onload="window.print()">

    <div class="center">
        <b>LAUNDRY BERSIH</b><br>
        Jl. Merdeka No. 10<br>
        Telp: 08123456789<br>
    </div>

    <div class="line"></div>

    <p>
        Invoice : <b>{{ $transaksi->kode_invoice }}</b><br>
        Pelanggan : {{ $transaksi->pelanggan->nama }}<br>
        Masuk : {{ $transaksi->tgl_masuk }}<br>
        Status Bayar : <b>{{ $transaksi->dibayar }}</b>
    </p>

    <div class="line"></div>

    <table>
        @foreach ($transaksi->detail as $d)
            <tr>
                <td>{{ $d->paket->nama_paket }} ({{ $d->qty }}kg)</td>
                <td class="right">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>

    <div class="line"></div>

    <table>
        <tr>
            <td><b>Total</b></td>
            <td class="right"><b>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</b></td>
        </tr>
        @if ($transaksi->dibayar == 'Sudah')
            <tr>
                <td>Bayar</td>
                <td class="right">Rp {{ number_format($transaksi->uang_bayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Kembalian</td>
                <td class="right">Rp {{ number_format($transaksi->uang_bayar - $transaksi->total, 0, ',', '.') }}</td>
            </tr>
        @endif
    </table>

    <div class="line"></div>

    <div class="center">
        <small>Terima kasih telah mencuci di Laundry Bersih</small><br>
        <small>Barang yang tidak diambil 30 hari bukan tanggung jawab kami</small>
    </div>

</body>

</html>
