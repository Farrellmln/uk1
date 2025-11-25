<?php
// Pastikan session sudah aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pastikan folder aktif terbaca
$currentFolder = basename(dirname($_SERVER['PHP_SELF']));

// Normalisasi level biar gak masalah huruf besar/kecil
$userLevel = isset($_SESSION['level']) ? strtolower($_SESSION['level']) : null;

// Debug sementara (hapus setelah yakin jalan)
// echo '<pre>'; print_r($_SESSION); echo '</pre>';
?>

<style>
  /* ==== SIDEBAR: OVERRIDE BAWaan THEME (SPESIFIK + !important) ==== */
  body .wrapper .sidebar {
    background-color: #ffffff !important;
    width: 280px !important;
    min-height: 100vh !important;
    border-right: 1px solid #e0e0e0 !important;
    transition: all 0.3s ease !important;
  }

  /* header */
  body .wrapper .sidebar .sidebar-logo {
    text-align: center;
    padding: 30px 0 18px;
    border-bottom: 1px solid #eee;
  }

  body .wrapper .sidebar .user-photo-container {
    width: 85px;
    height: 85px;
    margin: 0 auto 10px;
    border-radius: 50%;
    background-color: #e3f2fd;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  body .wrapper .sidebar .user-photo-container i {
    font-size: 44px;
    color: #1565c0;
  }

  body .wrapper .sidebar .app-title {
    font-weight: 600;
    color: #1565c0;
    font-size: 14px;
  }

  /* nav list base */
  body .wrapper .sidebar .nav.nav-secondary {
    list-style: none !important;
    padding-left: 0 !important;
    margin: 20px 0 !important;
  }

  body .wrapper .sidebar .nav.nav-secondary .nav-item {
    margin: 6px 15px !important;
    position: relative !important;
  }

  /* Hapus pseudo-element garis kiri */
  body .wrapper .sidebar .nav.nav-secondary .nav-item::before,
  body .wrapper .sidebar .nav.nav-secondary .nav-item::after,
  body .wrapper .sidebar .nav.nav-secondary .nav-item .nav-link::before,
  body .wrapper .sidebar .nav.nav-secondary .nav-item .nav-link::after {
    content: none !important;
    display: none !important;
  }

  /* link style */
  body .wrapper .sidebar .nav.nav-secondary .nav-link {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    color: #333 !important;
    padding: 11px 18px !important;
    border-radius: 10px !important;
    font-weight: 500 !important;
    transition: all 0.25s ease !important;
    text-decoration: none !important;
  }

  /* ikon */
  body .wrapper .sidebar .nav.nav-secondary .nav-link i {
    width: 22px !important;
    text-align: center !important;
    font-size: 17px !important;
    color: #555 !important;
  }

  /* hover */
  body .wrapper .sidebar .nav.nav-secondary .nav-link:hover {
    background-color: #e3f2fd !important;
    color: #1565c0 !important;
  }

  body .wrapper .sidebar .nav.nav-secondary .nav-link:hover i {
    color: #1565c0 !important;
  }

  /* aktif */
  body .wrapper .sidebar .nav.nav-secondary .nav-item.active > .nav-link {
    background-color: #1565c0 !important;
    color: #fff !important;
    box-shadow: 0 3px 8px rgba(21, 101, 192, 0.25) !important;
  }

  body .wrapper .sidebar .nav.nav-secondary .nav-item.active > .nav-link i {
    color: #fff !important;
  }

  /* Logout */
  .logout-link {
    color: #e53935 !important;
  }

  .logout-link:hover {
    background-color: #fdecea !important;
    color: #c62828 !important;
  }
</style>

<body>
  <div class="wrapper">
    <div class="sidebar">
      <div class="sidebar-logo">
        <div class="user-photo-container">
          <i class="fas fa-clipboard-list"></i>
        </div>
        <div class="app-title">Admin Pelaporan Masyarakat</div>
      </div>

      <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
          <ul class="nav nav-secondary">

            <li class="nav-item <?php echo ($currentFolder == 'dashboard') ? 'active' : ''; ?>">
              <a class="nav-link" href="../dashboard/index.php">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
              </a>
            </li>
             <?php if ($userLevel === 'admin'): ?>
            <li class="nav-item <?php echo ($currentFolder == 'registrasi_petugas') ? 'active' : ''; ?>">
              <a class="nav-link" href="../registrasi_petugas/index.php">
                <i class="fas fa-user-plus"></i>
                <span>Registrasi Petugas</span>
              </a>
            </li>
            <?php endif; ?>

            <li class="nav-item <?php echo ($currentFolder == 'verifikasi_validasi') ? 'active' : ''; ?>">
              <a class="nav-link" href="../verifikasi_validasi/index.php">
                <i class="fas fa-check-circle"></i>
                <span>Validasi & Verifikasi</span>
              </a>
            </li>

            <li class="nav-item <?php echo ($currentFolder == 'beri_tanggapan') ? 'active' : ''; ?>">
              <a class="nav-link" href="../beri_tanggapan/index.php">
                <i class="fas fa-comment-dots"></i>
                <span>Beri Tanggapan</span>
              </a>
            </li>

            <!-- Hanya tampil jika admin -->
            <?php if ($userLevel === 'admin'): ?>
              <li class="nav-item <?php echo ($currentFolder == 'generate_laporan') ? 'active' : ''; ?>">
                <a class="nav-link" href="../generate_laporan/index.php">
                  <i class="fas fa-file-alt"></i>
                  <span>Generate Laporan</span>
                </a>
              </li>
            <?php endif; ?>

            <li class="nav-item">
              <a class="nav-link logout-link" href="../../../backend_masyarakat/pages/auth/logout.php">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
              </a>
            </li>

          </ul>
        </div>
      </div>
    </div>
              