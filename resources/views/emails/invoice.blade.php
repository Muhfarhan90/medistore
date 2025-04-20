<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pembayaran</title>
</head>
<body>
    <div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
        <h2 style="text-align: center; color: #4CAF50;">Medistore</h2>
        <p>Halo {{ $transaction->user->name }},</p>
        <p>Terima kasih telah melakukan pembayaran di Medistore. Berikut adalah detail transaksi Anda:</p>
        <ul>
            <li><strong>ID Transaksi:</strong> {{ $transaction->order_id }}</li>
            <li><strong>Tanggal:</strong> {{ $transaction->created_at->format('d-m-Y H:i:s') }}</li>
            <li><strong>Total Pembayaran:</strong> Rp{{ number_format($transaction->gross_amount, 0, ',', '.') }}</li>
        </ul>
        <p>Invoice pembayaran Anda telah dilampirkan dalam email ini. Silakan unduh dan simpan sebagai bukti pembayaran.</p>
        <p>Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi kami melalui email <a href="mailto:support@medistore.com">support@medistore.com</a>.</p>
        <p>Terima kasih telah berbelanja di Medistore!</p>
        <p>Salam hangat,</p>
        <p><strong>Tim Medistore</strong></p>
    </div>
</body>
</html>