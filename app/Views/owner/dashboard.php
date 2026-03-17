<h1>Dashboard Owner</h1>

<p>Selamat datang <?= session()->get('username') ?></p>

<ul>
<li>Laporan Transaksi</li>
<li>Laporan Pendapatan</li>
</ul>

<a href="/logout">Logout</a>