<!DOCTYPE html>
<html>

<head>
<style>
    /* Menghilangkan margin browser dan mengatur ukuran kertas */
    @page {
        size: A5 landscape;
        margin: 0; /* Penting: Menghilangkan header/footer otomatis browser */
    }

    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 11px;
        display: flex;
        justify-content: center; /* Mengetengahkan kwitansi di layar */
    }

    .kwitansi {
        width: 190mm; 
        height: 100mm; 
        padding: 10mm;
        box-sizing: border-box;
        position: relative;
        background: #fff;
        overflow: hidden; /* Mencegah konten memaksa halaman baru */
    }

    .title {
        text-align: center;
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 10px;
        border-bottom: 2px solid #000;
        padding-bottom: 5px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    td {
        padding: 3px 0;
    }

    .detail th {
        border-bottom: 1px solid #000;
        text-align: left;
        padding: 8px 0;
    }

    .detail td {
        padding: 8px 0;
    }

    .line {
        border-top: 1px dashed #000;
    }

    .right {
        text-align: right;
        padding-right: 10px;
    }

    .bold {
        font-weight: bold;
    }

    .terbilang {
        border: 1px solid #000;
        padding: 8px;
        margin-top: 15px;
        font-style: italic;
        text-transform: uppercase;
        min-height: 20px;
    }

    /* Memposisikan TTD dan Terima Kasih agar tidak terdorong ke bawah */
    .footer-area {
        margin-top: 20px;
    }

    .ttd {
        text-align: right;
        margin-top: 10px;
    }

    .thanks {
        text-align: center;
        margin-top: 10px;
        font-weight: bold;
        border-top: 1px solid #eee;
        padding-top: 5px;
    }

    /* Optimasi saat tombol Print ditekan */
    @media print {
        body {
            background: none;
        }
        .kwitansi {
            border: 1px solid #000;
            margin: 0;
        }
    }
</style>
</head>

<body>

    <div class="kwitansi">

        <div class="title">KWITANSI PEMBAYARAN</div>

        <table>
            <tr>
                <td width="120">Kode</td>
                <td>: <?= $transaksi['kode_transaksi']; ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: <?= $transaksi['tanggal_transaksi']; ?></td>
            </tr>
            <tr>
                <td>Penghuni</td>
                <td>: <?= $transaksi['nama_penghuni'] ?? '-' ?></td>
            </tr>
            <tr>
                <td>Jenis</td>
                <td>: <?= strtoupper($transaksi['jenis_transaksi']); ?></td>
            </tr>
        </table>

        <br>

        <table class="detail">
            <tr>
                <th>Kamar</th>
                <th>Lama</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>

            <?php foreach ($detail as $d): ?>
                <tr>
                    <td>
                        <?= $d['nama_kamar']; ?>
                        <?php if (!empty($d['nomor_kamar'])): ?>
                            (<?= $d['nomor_kamar']; ?>)
                        <?php endif; ?>
                    </td>
                    <td><?= $d['lama_sewa']; ?> bln</td>
                    <td>Rp <?= number_format($d['harga'], 0, ',', '.'); ?></td>
                    <td>Rp <?= number_format($d['subtotal'], 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>

            <tr class="line">
                <td colspan="3" class="right bold">Total</td>
                <td class="bold">Rp <?= number_format($transaksi['total'], 0, ',', '.'); ?></td>
            </tr>

            <tr>
                <td colspan="3" class="right">Bayar</td>
                <td>Rp <?= number_format($transaksi['bayar'], 0, ',', '.'); ?></td>
            </tr>

            <?php if ($transaksi['jenis_transaksi'] == 'booking'): ?>
                <tr>
                    <td colspan="3" class="right">Sisa</td>
                    <td>Rp <?= number_format($transaksi['total'] - $transaksi['bayar'], 0, ',', '.'); ?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="right">Kembalian</td>
                    <td>Rp <?= number_format($transaksi['kembalian'], 0, ',', '.'); ?></td>
                </tr>
            <?php endif; ?>
        </table>

        <div class="terbilang">
            <?= strtoupper(terbilang($transaksi['total'])); ?> RUPIAH
        </div>

        <div class="ttd">
            <?= $transaksi['tanggal_transaksi']; ?><br><br><br>

        </div>

        <div class="thanks">
            TERIMA KASIH
        </div>

    </div>

</body>

</html>