<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =====================
// AUTH
// =====================
$routes->get('/', 'Auth::login');
$routes->post('/login/process', 'Auth::process');
$routes->get('/logout', 'Auth::logout');


// =====================
// DASHBOARD
// =====================
$routes->get('/admin/dashboard', 'Admin\AdminController::dashboard');
$routes->get('/kasir/dashboard', 'Kasir\KasirController::dashboard');
$routes->get('/owner/dashboard', 'Owner\OwnerController::dashboard');


// =====================
// ADMIN
// =====================
$routes->group('admin', function($routes) {

    // USERS
    $routes->get('user', 'Admin\UserController::index');
    $routes->get('user/create', 'Admin\UserController::create');
    $routes->post('user/store', 'Admin\UserController::store');
    $routes->get('user/edit/(:num)', 'Admin\UserController::edit/$1');
    $routes->post('user/update/(:num)', 'Admin\UserController::update/$1');
    $routes->get('user/delete/(:num)', 'Admin\UserController::delete/$1');

    // KAMAR
    $routes->get('kamar', 'Admin\KamarController::index');
    $routes->get('kamar/create', 'Admin\KamarController::create');
    $routes->post('kamar/store', 'Admin\KamarController::store');
    $routes->get('kamar/edit/(:num)', 'Admin\KamarController::edit/$1');
    $routes->post('kamar/update/(:num)', 'Admin\KamarController::update/$1');
    $routes->get('kamar/delete/(:num)', 'Admin\KamarController::delete/$1');

    // TIPE
    $routes->get('tipe', 'Admin\TipeController::index');
    $routes->get('tipe/create', 'Admin\TipeController::create');
    $routes->post('tipe/store', 'Admin\TipeController::store');
    $routes->get('tipe/edit/(:num)', 'Admin\TipeController::edit/$1');
    $routes->post('tipe/update/(:num)', 'Admin\TipeController::update/$1');
    $routes->get('tipe/delete/(:num)', 'Admin\TipeController::delete/$1');

});


$routes->group('kasir', function($routes) {

    // =====================
    // TRANSAKSI INDEX
    // =====================
    $routes->get('transaksi', 'Kasir\Transaksi::index');

    // STRUK PDF
    $routes->get('transaksi/cetakStruk/(:num)', 'Kasir\Transaksi::cetakStruk/$1');
 $routes->get('transaksi/struk_pelunasan/(:num)', 'Kasir\Transaksi::struk_pelunasan/$1');
 $routes->get('transaksi/struk_perpanjang/(:num)', 'Kasir\Transaksi::struk_perpanjang/$1');
 $routes->get('kasir/transaksi/struk_pelunasan/(:num)', 'Kasir\Transaksi::struk_pelunasan/$1');

    // =====================
    // PRODUK
    // =====================
    $routes->get('produk', 'Kasir\Produk::index');
    $routes->get('produk/tambahKeranjang/(:num)', 'Kasir\Produk::tambahKeranjang/$1');

    // =====================
    // KERANJANG
    // =====================
    $routes->get('transaksi/tambahKeranjang/(:num)', 'Kasir\Transaksi::tambahKeranjang/$1');
    $routes->get('transaksi/keranjang', 'Kasir\Transaksi::keranjang');
    $routes->get('transaksi/hapusKeranjang/(:num)', 'Kasir\Transaksi::hapusKeranjang/$1');
    $routes->get('transaksi/resetKeranjang', 'Kasir\Transaksi::resetKeranjang');

    $routes->get('transaksi/formBayarKeranjang', 'Kasir\Transaksi::formBayarKeranjang');
    $routes->post('transaksi/simpanBayarKeranjang', 'Kasir\Transaksi::simpanBayarKeranjang');

    $routes->get('transaksi/formBookingKeranjang', 'Kasir\Transaksi::formBookingKeranjang');
    $routes->post('transaksi/simpanBookingKeranjang', 'Kasir\Transaksi::simpanBookingKeranjang');

    // =====================
    // TRANSAKSI BAYAR & BOOKING
    // =====================
    $routes->get('transaksi/bayar/(:num)', 'Kasir\Transaksi::bayar/$1');
    $routes->post('transaksi/simpanBayar', 'Kasir\Transaksi::simpanBayar');

    $routes->get('transaksi/booking/(:num)', 'Kasir\Transaksi::booking/$1');
    $routes->post('transaksi/simpanBooking', 'Kasir\Transaksi::simpanBooking');

    // =====================
    // PELUNASAN
    // =====================
    $routes->get('transaksi/pelunasan/(:num)', 'Kasir\Transaksi::pelunasan/$1');
    $routes->post('transaksi/pelunasan/simpan', 'Kasir\Transaksi::simpanPelunasan');

    // =====================
    // PERPANJANG
    // =====================
    $routes->get('transaksi/perpanjang/(:num)', 'Kasir\Transaksi::perpanjang/$1');
    $routes->post('transaksi/perpanjang/simpan', 'Kasir\Transaksi::simpanPerpanjang');

    // =====================
    // RIWAYAT
    // =====================
    $routes->get('riwayat', 'Kasir\Riwayat::index');
    $routes->get('riwayat/detail/(:num)', 'Kasir\Riwayat::detail/$1');

    // =====================
    // DATA PENGHUNI
    // =====================
    $routes->get('penghuni', 'Kasir\Penghuni::index');
    $routes->get('penghuni/berhentikan/(:num)', 'Kasir\Penghuni::berhentikan/$1');

});

//owner
$routes->get('owner/user', 'Owner\User::index');
$routes->get('owner/kamar', 'Owner\Kamar::index');
$routes->get('owner/tipe', 'Owner\Tipe::index');
$routes->get('owner/riwayat', 'Owner\Riwayat::index');
$routes->get('/owner/log', 'Owner\LogController::index');
$routes->get('owner/riwayat/exportPdf', 'Owner\Riwayat::exportPdf');