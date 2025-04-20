<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .header p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }

        .details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .details div {
            background: #fff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .details p {
            margin: 5px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f4f4f4;
        }

        .signature {
            text-align: right;
            margin-top: 50px;
        }

        .signature p {
            margin: 0;
        }

        .signature .name {
            margin-top: 50px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Medistore</h1>
            <p>Jl. Kesehatan No. 123, Jakarta, Indonesia</p>
            <p>Email: support@medistore.com | Telp: +62 812-3456-7890</p>
        </div>

        <div class="details">
            <!-- Kolom Kiri -->
            <div>
                <p><strong>Nama:</strong> {{ $transaction->user->name }}</p>
                <p><strong>Email:</strong> {{ $transaction->user->email }}</p>
                <p><strong>Alamat:</strong> {{ $transaction->user->address ?? 'N/A' }}</p>
                <p><strong>No. HP:</strong> {{ $transaction->user->phone ?? 'N/A' }}</p>
            </div>

            <!-- Kolom Kanan -->
            <div>
                <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d-m-Y H:i:s') }}</p>
                <p><strong>ID PayPal:</strong> {{ $transaction->paypal_id ?? 'N/A' }}</p>
                <p><strong>Nama Bank:</strong> {{ $transaction->bank_name ?? 'N/A' }}</p>
                <p><strong>Cara Bayar:</strong> {{ ucfirst($transaction->payment_type) }}</p>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction->details as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->product->name }}</td>
                        <td>Rp{{ number_format($detail->price, 0, ',', '.') }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>Rp{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" style="text-align: right;">Total Pembayaran:</th>
                    <th>Rp{{ number_format($transaction->gross_amount, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>

        <div class="signature">
            <p>Hormat Kami,</p>
            <p class="name">Medistore</p>
        </div>
    </div>
</body>
</html>