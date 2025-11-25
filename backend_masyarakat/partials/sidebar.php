<?php
$currentFolder = basename(dirname($_SERVER['PHP_SELF']));
$role = $_SESSION['role'] ?? 'guest';
?>

<aside class="left-sidebar shadow-sm" id="sidebar"
  style="
    background: #fff;
    width: 260px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    border-right: 1px solid #e0e0e0;
    z-index: 1040;
    transition: all 0.3s ease;
  ">

  <div class="d-flex flex-column justify-content-between h-100">

    <!-- LOGO -->
    <div>
      <div class="brand-logo text-center py-4 border-bottom">
        <a href="../dashboard/index.php" class="text-decoration-none d-flex flex-column align-items-center">
          <div class="rounded-circle d-flex align-items-center justify-content-center mb-2"
               style="width: 80px; height: 80px; background-color: #004aad1a; color: #004aad; font-size: 40px;">
            <i class="bi bi-megaphone-fill"></i>
          </div>
          <span class="fw-bold text-primary" style="font-size: 17px;">Pelaporan Masyarakat</span>
        </a>
      </div>

      <!-- MENU -->
      <nav class="mt-4">
        <ul class="list-unstyled px-3" style="font-size: 15px; font-weight: 500;">

          <!-- DASHBOARD -->
          <li class="mb-1">
            <a href="../dashboard/index.php"
               class="d-flex align-items-center gap-3 py-2 px-3 rounded <?= ($currentFolder == 'dashboard') ? 'active-menu' : 'text-dark'; ?>">
              <i class="bi bi-speedometer2 fs-5"></i>
              Dashboard
            </a>
          </li>

          <!-- LAPORAN PENGADUAN -->
          <?php if ($role != 'staf') : ?>
          <li class="mb-1">
            <a href="../laporan_pengaduan/index.php"
               class="d-flex align-items-center gap-3 py-2 px-3 rounded <?= ($currentFolder == 'laporan_pengaduan') ? 'active-menu' : 'text-dark'; ?>">
              <i class="bi bi-file-earmark-text fs-5"></i>
              Laporan Pengaduan
            </a>
          </li>
          <?php endif; ?>

          <!-- LOGOUT -->
          <li class="mt-4">
            <a href="../../pages/auth/logout.php"
               class="d-flex align-items-center gap-3 py-2 px-3 rounded text-danger fw-semibold logout-link">
              <i class="bi bi-box-arrow-right fs-5"></i>
              Logout
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</aside>

<!-- Overlay untuk mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- CSS TAMBAHAN -->
<style>
  /* ====== Sidebar Link ====== */
  .left-sidebar a {
    color: #333;
    transition: all 0.2s ease;
  }

  .left-sidebar a:hover {
    background-color: #f1f1f1;
    text-decoration: none;
  }

  /* ====== Active Menu ====== */
  .active-menu {
    background-color: #004aad !important;
    color: white !important;
    font-weight: 600;
  }

  .active-menu i {
    color: white !important;
  }

  /* ====== Logout ====== */
  .logout-link:hover {
    background-color: #ffe5e7 !important;
    color: #c82333 !important;
  }

  /* ====== Overlay Mobile ====== */
  .sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 100vw;
    background: rgba(0, 0, 0, 0.4);
    z-index: 1030;
    display: none;
  }

  /* ====== Responsif ====== */
  @media (max-width: 992px) {
    .left-sidebar {
      left: -260px;
      box-shadow: 2px 0 12px rgba(0, 0, 0, 0.1);
    }

    .left-sidebar.active {
      left: 0;
    }

    .sidebar-overlay.active {
      display: block;
    }
  }
</style>

<!-- JS TOGGLE SIDEBAR -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("sidebarOverlay");
  const toggleBtn = document.getElementById("sidebarToggle"); // pastikan ini ada di header/nav

  if (toggleBtn) {
    toggleBtn.addEventListener("click", function() {
      sidebar.classList.toggle("active");
      overlay.classList.toggle("active");
    });
  }

  // Klik overlay untuk menutup sidebar di mobile
  if (overlay) {
    overlay.addEventListener("click", function() {
      sidebar.classList.remove("active");
      overlay.classList.remove("active");
    });
  }
});
</script>
