<?= $this->extend('layout/sidebarkasir') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('css/kasir/transaksi/bayarlangsung.css') ?>">

<h2 class="page-title">Booking Kamar</h2>

<form action="<?= base_url('kasir/transaksi/simpanBooking') ?>" method="post" class="form-card">

    <input type="hidden" name="id_kamar" value="<?= $kamar['id_kamar']; ?>">
    <input type="hidden" id="harga" name="harga" value="<?= $kamar['harga']; ?>">

   

    <div class="form-group">
        <label>Kamar Dipilih</label>
       <input type="text" value="<?= esc($kamar['nama_kamar']) . '-' . str_pad($kamar['nomor_kamar'] ?? 0, 2, '0', STR_PAD_LEFT) ?>" readonly>
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
                <input type="text" name="penghuni1" required>
            </div>

            <div class="form-group">
                <label>NIK Penghuni 1</label>
                <input type="text" name="nik1" required>
            </div>

            <div class="form-group">
                <label>No HP Penghuni 1</label>
                <input type="text" name="hp1" required>
            </div>

            <div class="form-group">
                <label>Alamat Penghuni 1</label>
                <textarea name="alamat1" required></textarea>
            </div>
        </div>

        <!-- Penghuni 2 -->
        <div class="form-col">
            <div class="form-section-title">
                Penghuni 2 (Opsional)
            </div>

            <div class="form-group">
                <label>Nama Penghuni 2</label>
                <input type="text" name="penghuni2">
            </div>

            <div class="form-group">
                <label>NIK Penghuni 2</label>
                <input type="text" name="nik2">
            </div>

            <div class="form-group">
                <label>No HP Penghuni 2</label>
                <input type="text" name="hp2">
            </div>

            <div class="form-group">
                <label>Alamat Penghuni 2</label>
                <textarea name="alamat2"></textarea>
            </div>
        </div>

    </div>

    <!--SEWA-->
    <div class="form-row">

        <div class="form-col">
            <div class="form-group">
                <label>Tanggal Masuk</label>
                <input type="date" id="tanggal_masuk" name="tanggal_masuk" required>
            </div>

            <div class="form-group">
                <label>Lama Sewa (bulan)</label>
                <input type="number" id="lama_sewa" name="lama_sewa" value="1">
            </div>
        </div>

        <div class="form-col">
            <div class="form-group">
                <label>Tanggal Jatuh Tempo</label>
                <input type="date" id="jatuh_tempo" name="jatuh_tempo" readonly>
            </div>

            <div class="form-group">
                <label>Total Harga</label>
                <input type="text" id="total" readonly>
            </div>
        </div>

    </div>

    <!--PEMBAYARAN-->
    <div class="form-group">
        <label>Uang Booking (DP)</label>
        <input type="number" id="dp" name="dp" required>
    </div>
<div class="form-row">
    <div class="form-col">
        <div class="form-group">
            <label>Tanggal Bayar Booking</label>
            <input type="date" id="tanggal_booking" name="tanggal_booking" required>
        </div>
    </div>

    <div class="form-col">
        <div class="form-group">
            <label>Jatuh Tempo Booking</label>
            <input type="date" id="jatuh_tempo_booking" name="jatuh_tempo_booking" readonly>
        </div>
    </div>
</div>
    <div class="form-footer">
        <button type="submit" class="btn-bayar">Simpan Booking</button>
        <span class="kembalian-label">
            Sisa Bayar: <span id="sisa">0</span>
        </span>
    </div>

</form>

<script>
document.getElementById('tanggal_masuk').addEventListener('change', hitung);
document.getElementById('lama_sewa').addEventListener('input', hitung);
document.getElementById('dp').addEventListener('input', hitungSisa);

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
}

function hitungSisa(){
    let total = document.getElementById('total').value;
    let dp = document.getElementById('dp').value;
    document.getElementById('sisa').textContent = total - dp;
}

window.onload = function() {
    let today = new Date().toISOString().split('T')[0];
    document.getElementById('tanggal_booking').value = today;
}

document.getElementById('tanggal_masuk').addEventListener('change', function() {
    let tglMasuk = this.value;

    if (tglMasuk) {
        document.getElementById('jatuh_tempo_booking').value = tglMasuk;
    }
});
</script>

<?= $this->endSection() ?>