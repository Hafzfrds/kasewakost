<?= $this->extend('layout/sidebarkasir') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/kasir/transaksi/bayarlangsung.css') ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<h2 class="page-title">Perpanjang Sewa Kost</h2>


<form action="/kasir/transaksi/perpanjang/simpan" method="post" class="form-card">

    <input type="hidden" name="id_detail" value="<?= $detail['id_detail'] ?>">
    <input type="hidden" id="harga" value="<?= $detail['harga_sewa'] ?>">

    <div class="form-group">
        <label>Nama Penyewa</label>
        <input type="text" value="<?= $detail['nama_penghuni'] ?>" readonly>
    </div>

    <div class="form-group">
        <label>Kamar</label>
        <input type="text" value=<?= esc($detail['nama_kamar']) . '-' . str_pad($detail['nomor_kamar'], 2, '0', STR_PAD_LEFT) ?> readonly>
    </div>

    <div class="form-group">
        <label>Harga Sewa / Bulan</label>
        <input type="text" value="<?= number_format($detail['harga_sewa']) ?>" readonly>
    </div>

    <div class="form-group">
        <label>Perpanjang Berapa Bulan</label>
        <input type="number" name="lama_sewa" id="bulan" required>
    </div>

    <div class="form-group">
        <label>Diperpanjang Hingga</label>
        <input type="date" name="jatuh_tempo" id="tempo" readonly>
    </div>

    <div class="form-group">
        <label>Total Sewa</label>
        <input type="text" name="total" id="total" readonly>
    </div>

    <div class="form-group">
        <label>Uang Bayar</label>
        <input type="number" name="bayar" id="bayar" required>
    </div>

    <div class="form-footer">
        <button type="submit" class="btn-bayar">Bayar</button>
        <span class="kembalian-label">
            Kembalian: <span id="kembalian">0</span>
        </span>
    </div>

</form>
<?php if(session()->getFlashdata('error')): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Perpanjangan Gagal',
    text: '<?= session()->getFlashdata('error'); ?>',
    confirmButtonColor: '#d33',
    timer: 3000,
    timerProgressBar: true
});
</script>
<?php endif; ?>
<script>
document.getElementById('bulan').addEventListener('input', function(){
    let bulan = this.value;
    let harga = document.getElementById('harga').value;

    let total = bulan * harga;
    document.getElementById('total').value = total;

    let oldDate = new Date("<?= $detail['jatuh_tempo'] ?>");
    oldDate.setMonth(oldDate.getMonth() + parseInt(bulan));
    document.getElementById('tempo').value = oldDate.toISOString().split('T')[0];
});

document.getElementById('bayar').addEventListener('input', function(){
    let bayar = parseFloat(this.value);
    let total = parseFloat(document.getElementById('total').value);

    let kembali = bayar - total;
    document.getElementById('kembalian').textContent = kembali;
});
</script>

<?= $this->endSection() ?>