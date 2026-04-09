<!DOCTYPE html>
<html>
<head>

<title>Kasir Panel</title>
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
  padding: 0;
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
  transition: background 0.25s ease, color 0.25s ease;
}

.sidebar ul li a i {
  width: 20px;
  text-align: center;
  font-size: 16px;
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
  font-size: 15px;
  letter-spacing: 0.5px;
  transition: background 0.18s;
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
      <a href="/kasir/dashboard" class="<?= strpos(current_url(), 'dashboard') !== false ? 'active' : '' ?>">
        <i class="fas fa-th-large"></i> Dashboard
      </a>
    </li>

    <li>
      <a href="/kasir/produk" class="<?= strpos(current_url(), 'produk') !== false ? 'active' : '' ?>">
        <i class="fas fa-box"></i> Kamar
      </a>
    </li>

    <li>
      <a href="/kasir/transaksi" class="<?= strpos(current_url(), 'transaksi') !== false ? 'active' : '' ?>">
        <i class="fas fa-cash-register"></i> Transaksi
      </a>
    </li>

    <li>
      <a href="/kasir/riwayat" class="<?= strpos(current_url(), 'riwayat') !== false ? 'active' : '' ?>">
        <i class="fas fa-history"></i> Riwayat Transaksi
      </a>
    </li>

    <li>
      <a href="/kasir/penghuni" class="<?= strpos(current_url(), 'penghuni') !== false ? 'active' : '' ?>">
        <i class="fas fa-users"></i> Data Penghuni
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

<script>
  const links = document.querySelectorAll('.sidebar ul li a');

  links.forEach(link => {
    link.addEventListener('click', function () {
      links.forEach(l => l.classList.remove('active'));
      this.classList.add('active');
    });
  });
</script>

</body>
</html>