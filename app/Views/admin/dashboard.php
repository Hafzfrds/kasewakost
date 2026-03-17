<?= $this->extend('layout/sidebaradmin') ?>

<?= $this->section('content') ?>

<h1>Dashboard Admin</h1>

<p>Selamat datang <b><?= session()->get('username') ?></b></p>

<hr>

<h3>Menu Admin</h3>

<ul>

<li>Kelola User</li>

<li>Kelola Bundling</li>

<li>Kelola Kamar</li>

</ul>

<?= $this->endSection() ?>