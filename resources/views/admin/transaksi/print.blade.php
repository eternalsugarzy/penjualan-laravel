<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nota - {{ $transaksi->id_transaksi }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 58mm; /* Ukuran standar kertas thermal */
            margin: 0 auto;
            padding: 10px;
            font-size: 12px;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .item-name {
            font-weight: bold;
            display: block;
            margin-top: 5px;
        }
        .item-detail {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .footer {
            margin-top: 20px;
            font-size: 10px;
            line-height: 1.2;
        }
        /* Hilangkan header/footer browser saat print */
        @media print {
            @page { margin: 0; }
            body { margin: 1.6cm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print();">

    <div class="text-center">
        <h3 style="margin: 0; text-transform: uppercase;">{{ $toko->nama_toko ?? 'POS SYSTEM' }}</h3>
        <p style="margin: 5px 0 0 0; font-size: 10px;">{{ $toko->deskripsi ?? 'Alamat belum diatur' }}</p>
    </div>

    <div class="divider"></div>

    <table style="font-size: 11px;">
        <tr>
            <td>Nota: {{ $transaksi->id_transaksi }}</td>
        </tr>
        <tr>
            <td>Tgl : {{ date('d/m/y H:i', strtotime($transaksi->tgl_transaksi)) }}</td>
        </tr>
        <tr>
            <td>Kasir: {{ Auth::user()->nama }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    @foreach($details as $item)
    <span class="item-name">{{ $item->nama_produk }}</span>
    <div class="item-detail">
        <span>{{ $item->qty }} x {{ number_format($item->subtotal / $item->qty, 0, ',', '.') }}</span>
        <span>{{ number_format($item->subtotal, 0, ',', '.') }}</span>
    </div>
    @endforeach

    <div class="divider"></div>

    <table style="font-weight: bold;">
        <tr>
            <td>TOTAL</td>
            <td class="text-right">Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="text-center footer">
        <p>TERIMA KASIH</p>
        <p>Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.</p>
    </div>

    <div class="text-center no-print" style="margin-top: 20px;">
        <button onclick="window.print()" style="padding: 5px 10px; cursor: pointer;">Klik Cetak Manual</button>
        <br><br>
        <a href="{{ route('transaksi.history') }}" style="color: blue; text-decoration: none; font-size: 10px;"> Kembali ke Riwayat</a>
    </div>

</body>
</html>