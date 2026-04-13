<?= $this->extend('layout/sidebarkasir') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('css/kasir/transaksi/bayarlangsung.css') ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<h2 class="page-title">Bayar Langsung</h2>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert-error">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('kasir/transaksi/simpanBayar') ?>" method="post" class="form-card">

    <input type="hidden" name="id_kamar" value="<?= $kamar['id_kamar']; ?>">
    <input type="hidden" id="harga" name="harga" value="<?= $kamar['harga']; ?>">

   

    <!-- DATA KAMAR -->
    <div class="form-group">
        <label>Kamar Dipilih</label>
        <input type="text" value="<?= esc($kamar['nama_kamar']) . '-' . str_pad($kamar['nomor_kamar'] ?? 0, 2, '0', STR_PAD_LEFT) ?>" readonly>
    </div>

    <div class="form-group">
        <label>Harga per Bulan</label>
        <input type="text" value="<?= $kamar['harga']; ?>" readonly>
    </div>

    <!--PENGHUNI-->
    <div class="form-row">

        <!-- Penghuni 1 -->
        <div class="form-col">
            <div class="form-section-title">
                Penghuni 1
                <span class="check-icon checked">✓</span>
            </div>

            <div class="form-group">
                <label>Nama Penghuni 1</label>
                <input type="text" name="penghuni1" value="<?= old('penghuni1') ?>" required>
            </div>

            <div class="form-group">
                <label>NIK Penghuni 1</label>
                <input type="text" name="nik1" value="<?= old('nik1') ?>" required>
            </div>

            <div class="form-group">
                <label>No HP Penghuni 1</label>
                <input type="text" name="hp1" value="<?= old('hp1') ?>" required>
            </div>

            <div class="form-group">
                <label>Alamat Penghuni 1</label>
                <textarea name="alamat1" required><?= old('alamat1') ?></textarea>
            </div>
        </div>

        <!-- Penghuni 2 -->
        <div class="form-col">
            <div class="form-section-title">
                Penghuni 2 (Opsional)
            </div>

            <div class="form-group">
                <label>Nama Penghuni 2</label>
                <input type="text" name="penghuni2" value="<?= old('penghuni2') ?>">
            </div>

            <div class="form-group">
                <label>NIK Penghuni 2</label>
                <input type="text" name="nik2" value="<?= old('nik2') ?>">
            </div>

            <div class="form-group">
                <label>No HP Penghuni 2</label>
                <input type="text" name="hp2" value="<?= old('hp2') ?>">
            </div>

            <div class="form-group">
                <label>Alamat Penghuni 2</label>
                <textarea name="alamat2"><?= old('alamat2') ?></textarea>
            </div>
        </div>

    </div>

    <!--SEWA-->
    <div class="form-row">

        <div class="form-col">
            <div class="form-group">
                <label>Tanggal Masuk</label>
                <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="<?= old('tanggal_masuk') ?>" required>
            </div>

            <div class="form-group">
                <label>Lama Sewa (bulan)</label>
                <input type="number" id="lama_sewa" name="lama_sewa" value="<?= old('lama_sewa') ?: 1 ?>" min="1">
            </div>
        </div>

        <div class="form-col">
            <div class="form-group">
                <label>Tanggal Jatuh Tempo</label>
                <input type="date" id="jatuh_tempo" name="jatuh_tempo" value="<?= old('jatuh_tempo') ?>" readonly>
            </div>

            <div class="form-group">
                <label>Total Harga</label>
                <input type="text" id="total" value="<?= old('total') ?>" readonly>
            </div>
        </div>

    </div>

    <!-- PEMBAYARAN -->
    <div class="form-group">
        <label>Uang Bayar</label>
        <input type="number" id="bayar" name="bayar" value="<?= old('bayar') ?>" required>
    </div>

    <div class="form-footer">
        <button type="submit" class="btn-bayar">Simpan</button>
        <span class="kembalian-label">
            Kembalian: <span id="kembalian">0</span>
        </span>
    </div>

</form>
<?php if(session()->getFlashdata('error')): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Pembayaran Gagal',
    text: '<?= session()->getFlashdata('error'); ?>',
    confirmButtonColor: '#d33',
    timer: 3000,
    timerProgressBar: true
});
</script>
<?php endif; ?>
<script>
document.getElementById('tanggal_masuk').addEventListener('change', hitung);
document.getElementById('lama_sewa').addEventListener('input', hitung);
document.getElementById('bayar').addEventListener('input', hitungKembalian);

window.onload = function(){
    hitung();
}

function hitung() {
    let harga = document.getElementById('harga').value;
    let lama = document.getElementById('lama_sewa').value;
    let tglMasuk = document.getElementById('tanggal_masuk').value;

    if(tglMasuk){
        let date = new Date(tglMasuk);
        date.setMonth(date.getMonth() + parseInt(lama));
        document.getElementById('jatuh_tempo').value = date.toISOString().split('T')[0];
    }

    let total = harga * lama;
    document.getElementById('total').value = total;
    hitungKembalian();
}

function hitungKembalian(){
    let total = document.getElementById('total').value;
    let bayar = document.getElementById('bayar').value;

    let kembali = bayar - total;
    document.getElementById('kembalian').textContent = kembali;
}
</script>

<?= $this->endSection() ?>