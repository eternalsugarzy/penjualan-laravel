<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $transaksi->id_transaksi }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            max-width: 300px; /* Lebar kertas thermal */
            margin: 0 auto;
            padding: 10px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 10px;
        }
        .header h2 { margin: 0; font-size: 16px; }
        .header p { margin: 2px 0; font-size: 10px; }
        hr { border: 1px dashed #000; }
        table { width: 100%; border-collapse: collapse; }
        td { vertical-align: top; }
        .text-right { text-align: right; }
        .total-row { font-weight: bold; border-top: 1px dashed #000; }
        
        @media print {
            body { margin: 0; padding: 0; }
            button { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>PEMASARAN PRODUK DAUR ULANG</h2>
        <p>Jl. Perdagangan</p>
        <p>Telp: 0123456789</p>
    </div>

    <hr>

    <table>
        <tr>
            <td>No. Nota</td>
            <td class="text-right">{{ $transaksi->id_transaksi }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td class="text-right">{{ date('d/m/Y H:i', strtotime($transaksi->tgl_transaksi)) }}</td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td class="text-right">{{ $transaksi->user->name ?? 'Admin' }}</td>
        </tr>
    </table>

    <hr>

    <table>
        @foreach($transaksi->details as $detail)
        <tr>
            <td colspan="2">{{ $detail->nama_produk }}</td>
        </tr>
        <tr>
            <td>{{ $detail->qty }} x {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <hr>

    <table>
        <tr class="total-row">
            <td style="padding-top: 5px;">TOTAL</td>
            <td class="text-right" style="padding-top: 5px; font-size: 14px;">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Bayar</td>
            <td class="text-right">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td class="text-right">Rp 0</td>
        </tr>
    </table>

    <hr>

    <div class="footer">
        <p>Terima Kasih atas Kunjungan Anda</p>
        <p>Barang yang dibeli tidak dapat ditukar</p>
    </div>

</body>
</html>