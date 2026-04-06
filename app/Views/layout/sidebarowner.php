<!DOCTYPE html>
<html>
<head>

<title>Owner Panel</title>
<link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: 'Poppins', Arial, sans-serif;
  background: #eaf1fb;
}

.sidebar {
  width: 220px;
  height: calc(100vh - 40px);
  background: #3674B5;
  position: fixed;
  top: 20px;
  left: 20px;
  display: flex;
  flex-direction: column;
  border-radius: 20px;
  box-shadow: 6px 6px 24px rgba(54, 116, 181, 0.35), 0 2px 8px rgba(0,0,0,0.10);
  overflow: hidden;
}

.sidebar-brand {
  background: #2d62a0;
  padding: 22px 16px 18px;
  text-align: center;
}

.sidebar-brand h2 {
  color: white;
  font-size: 18px;
  font-weight: 400;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  font-family: 'Krona One', sans-serif;
}

.sidebar ul {
  list-style: none;
  padding: 18px 0 0;
  flex: 1;
}

.sidebar ul li a {
  display: flex;
  align-items: center;
  gap: 12px;
  color: rgba(255,255,255,0.88);
  text-decoration: none;
  padding: 13px 20px;
  font-size: 15px;
  font-weight: 500;
  border-radius: 8px;
  margin: 2px 10px;
  transition: 0.25s;
}

.sidebar ul li a i {
  width: 20px;
  text-align: center;
}

.sidebar ul li a:hover:not(.active) {
  background: rgba(255,255,255,0.10);
  color: white;
}

.sidebar ul li a.active {
  background: rgba(255,255,255,0.25);
  color: white;
  font-weight: 600;
}

.sidebar-logout {
  padding: 16px 18px 24px;
}

.sidebar-logout a {
  display: block;
  text-align: center;
  background: #e74c3c;
  color: white;
  text-decoration: none;
  padding: 12px;
  border-radius: 8px;
  font-weight: 700;
}

.sidebar-logout a:hover {
  background: #c0392b;
}

.content {
  margin-left: 260px;
  padding: 30px;
  min-height: 100vh;
}

</style>

</head>

<body>

<div class="sidebar">

  <div class="sidebar-brand">
    <h2>KASEWAKOST</h2>
  </div>

  <ul>
  <li>
    <a href="/owner/dashboard" class="<?= strpos(current_url(), 'dashboard') !== false ? 'active' : '' ?>">
      <i class="fas fa-th-large"></i> Dashboard
    </a>
  </li>
<li>
    <a href="/owner/user">
        <i class="fa fa-users"></i> Lihat User
    </a>
</li>

  <li>
      <a href="/owner/kamar">
      <i class="fas fa-door-open"></i> Lihat Kamar
    </a>
  </li>

  <li>
 <a href="/owner/tipe">
      <i class="fas fa-layer-group"></i> Lihat Tipe
    </a>
  </li>

  <li>
    <a href="<?= base_url('owner/riwayat') ?>">
      <i class="fas fa-history"></i> Riwayat Transaksi
    </a>
  </li>

  <li>
    <a href="/owner/log" class="<?= strpos(current_url(), 'log') !== false ? 'active' : '' ?>">
      <i class="fas fa-clipboard-list"></i> Log Activity
    </a>
  </li>
</ul>

  <div class="sidebar-logout">
    <a href="/logout">Logout</a>
  </div>

</div>

<div class="content">
  <?= $this->renderSection('content') ?>
</div>

</body>
</html>