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

        <div class="title">KWITANSI PELUNASAN</div>

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
                <td>: <?= $transaksi['nama_penghuni']; ?></td>
            </tr>
            <tr>
                <td>Kamar</td>
                <td>: <?= $transaksi['nama_kamar']; ?></td>
            </tr>
        </table>

        <br>

        <table class="detail">
            <tr>
                <th>Keterangan</th>
                <th>Jumlah</th>
            </tr>

            <tr>
                <td>Sisa Bayar</td>
                <td class="right">
                    Rp <?= number_format($transaksi['sisa_bayar'], 0, ',', '.'); ?>
                </td>
            </tr>

            <tr>
                <td>Uang Bayar</td>
                <td class="right">
                    Rp <?= number_format($transaksi['uang_bayar'], 0, ',', '.'); ?>
                </td>
            </tr>

            <tr class="line">
                <td class="right bold">Kembalian</td>
                <td class="bold">
                    Rp <?= number_format($transaksi['kembalian'], 0, ',', '.'); ?>
                </td>
            </tr>
        </table>

        <div class="ttd">
            <?= $transaksi['tanggal_transaksi']; ?><br><br><br>

        </div>

        <div class="thanks">
            TERIMA KASIH
        </div>

    </div>

</body>

</html>