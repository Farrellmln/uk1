<?php
include '../../app.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userName = htmlspecialchars($_SESSION['nama'] ?? 'Pengguna');
$username = htmlspecialchars($_SESSION['username'] ?? 'masyarakat');
?>

<header class="app-header">
  <nav class="navbar navbar-expand-lg bg-white shadow-sm px-4 py-2"
       style="position: fixed; top: 0; left: 250px; right: 0; z-index: 1030; width: calc(100% - 250px); border-bottom: 3px solid #ffffffff;">
    <div class="d-flex justify-content-end align-items-center w-100">

      <!-- Profil dropdown -->
      <div class="dropdown">
        <a class="d-flex align-items-center text-decoration-none" href="#" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="me-2 fw-semibold text-dark">Hi, <?= $username ?></span>
          <div class="avatar-placeholder rounded-circle text-white d-flex align-items-center justify-content-center"
               style="background-color: #0a4da3; width: 40px; height: 40px; font-size: 1.4rem;">
            <i class="ti ti-user"></i>
          </div>
        </a>

        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-3 rounded-3"
            aria-labelledby="profileDropdown" style="min-width: 220px;">
          <li class="text-center mb-2">
            <div class="avatar-placeholder rounded-circle text-white d-flex align-items-center justify-content-center mx-auto mb-2"
                 style="background-color: #0a4da3; width: 55px; height: 55px; font-size: 1.8rem;">
              <i class="ti ti-user"></i>
            </div>
            <p class="mb-0 fw-bold text-dark"><?= $userName ?></p>
            <small class="text-muted"><?= $username ?></small>
          </li>
          <hr class="dropdown-divider">
          <li class="text-center">
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
