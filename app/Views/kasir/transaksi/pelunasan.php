<?= $this->extend('layout/sidebarkasir') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('css/kasir/transaksi/bayarlangsung.css') ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<h2 class="page-title">Pelunasan</h2>


<form action="/kasir/transaksi/pelunasan/simpan" method="post" class="form-card">

    <input type="hidden" name="id_detail" value="<?= $detail['id_detail'] ?>">
    <input type="hidden" id="sisa" value="<?= $detail['sisa_bayar'] ?>">

    <div class="form-group">
        <label>Nama Penghuni</label>
        <input type="text" value="<?= $detail['nama_penghuni'] ?>" readonly>
    </div>

    <div class="form-group">
        <label>No HP</label>
        <input type="text" value="<?= $detail['no_hp'] ?>" readonly>
    </div>

    <div class="form-group">
        <label>Kamar</label>
        <input type="text" value="<?= esc($detail['nama_kamar']) . '-' . str_pad($detail['nomor_kamar'], 2, '0', STR_PAD_LEFT) ?>" readonly>
    </div>

    <div class="form-group">
        <label>Total</label>
        <input type="text" value="<?= number_format($detail['total']) ?>" readonly>
    </div>

    <div class="form-group">
        <label>DP / Sudah Dibayar</label>
        <input type="text" value="<?= number_format($detail['bayar']) ?>" readonly>
    </div>

    <div class="form-group">
        <label>Sisa Bayar</label>
        <input type="text" value="<?= number_format($detail['sisa_bayar']) ?>" readonly>
    </div>

    <div class="form-group">
        <label>Uang Bayar</label>
        <input type="number" id="bayar" name="bayar" required>
    </div>

    <div class="form-footer">
        <button type="submit" class="btn-bayar">Simpan Pelunasan</button>
        <span class="kembalian-label">
            Kembalian: <span id="kembalian">0</span>
        </span>
    </div>

</form>

<?php if (session()->getFlashdata('error')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Pelunasan Gagal',
            text: '<?= session()->getFlashdata('error'); ?>',
            confirmButtonColor: '#d33',
            timer: 3000,
            timerProgressBar: true
        });
    </script>
<?php endif; ?>
<script>
    document.getElementById('bayar').addEventListener('input', function() {
        let sisa = document.getElementById('sisa').value;
        let bayar = this.value;

        let kembali = bayar - sisa;

        if (kembali < 0) {
            document.getElementById('kembalian').textContent = 0;
        } else {
            document.getElementById('kembalian').textContent = kembali;
        }
    });
</script>

<?= $this->endSection() ?>