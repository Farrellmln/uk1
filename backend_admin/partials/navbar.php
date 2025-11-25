<div class="main-panel">
    <div class="main-header">
        <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
                <a href="index.html" class="logo">
                    <img src="../../template-admin/assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" />
                </a>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="gg-menu-right"></i>
                    </button>
                    <button class="btn btn-toggle sidenav-toggler">
                        <i class="gg-menu-left"></i>
                    </button>
                </div>
                <button class="topbar-toggler more">
                    <i class="gg-more-vertical-alt"></i>
                </button>
            </div>
            <!-- End Logo Header -->
        </div>

        <!-- Navbar Header -->
        <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
            <div class="container-fluid">
                <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                </nav>

                <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

                    <!-- 🔹 Dropdown Notifikasi Pesan / Laporan Baru -->
<?php
include '../../app.php';
$notif_query = mysqli_query($connect, "
  SELECT id_pengaduan, isi_laporan, tgl_pengaduan, tingkat 
  FROM pengaduan 
  WHERE status='0' 
  ORDER BY 
    CASE 
      WHEN tingkat='urgent' THEN 1
      WHEN tingkat='warning' THEN 2
      WHEN tingkat='info' THEN 3
      ELSE 4
    END,
    tgl_pengaduan DESC 
  LIMIT 5
");
$jumlah_notif = mysqli_num_rows($notif_query);
?>
<li class="nav-item dropdown hidden-caret">
  <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="fas fa-envelope text-primary fa-lg position-relative"></i>
    <?php if ($jumlah_notif > 0): ?>
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
        <?= $jumlah_notif ?>
      </span>
    <?php endif; ?>
  </a>

  <ul class="dropdown-menu dropdown-menu-end animated fadeIn border-0 shadow"
      aria-labelledby="notifDropdown"
      style="width: 280px; border-radius: 10px;">
    <li class="dropdown-header fw-bold text-primary px-3 pt-2 pb-1">
      Notifikasi Laporan Baru
    </li>
    <li><hr class="dropdown-divider"></li>

    <?php if ($jumlah_notif > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($notif_query)): ?>
        <li>
          <a href="../../pages/laporan/detail.php?id=<?= $row['id_pengaduan']; ?>" 
             class="dropdown-item d-flex align-items-start py-2">

            <div class="icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                 style="width: 35px; height: 35px;">
              <i class="fas fa-file-alt"></i>
            </div>

            <div>
              <div class="fw-bold text-dark small d-flex align-items-center">
                <span class="text-primary me-2">Baru</span>
                <?php
                // 🌸 Warna pastel & ikon di badge
                if ($row['tingkat'] == 'urgent') {
                  echo '<span class="badge rounded-pill fw-semibold" style="
                          background-color:#ffe5e5;
                          color:#dc3545;
                          font-size:11px;
                          padding:4px 8px;
                        ">
                        <i class=\'fas fa-exclamation-circle me-1\'></i>Urgent
                        </span>';
                } elseif ($row['tingkat'] == 'warning') {
                  echo '<span class="badge rounded-pill fw-semibold" style="
                          background-color:#fff3cd;
                          color:#fd7e14;
                          font-size:11px;
                          padding:4px 8px;
                        ">
                        <i class=\'fas fa-exclamation-triangle me-1\'></i>Warning
                        </span>';
                } elseif ($row['tingkat'] == 'info') {
                  echo '<span class="badge rounded-pill fw-semibold" style="
                          background-color:#d1f7ef;
                          color:#0d9488;
                          font-size:11px;
                          padding:4px 8px;
                        ">
                        <i class=\'fas fa-info-circle me-1\'></i>Info
                        </span>';
                } else {
                  echo '<span class="badge rounded-pill bg-light text-muted" style="font-size:11px;">-</span>';
                }
                ?>
              </div>
              <div class="text-muted" style="font-size: 11px;">
                <?= date('d M Y', strtotime($row['tgl_pengaduan'])); ?>
              </div>
            </div>
          </a>
        </li>
      <?php endwhile; ?>
    <?php else: ?>
      <li class="text-center text-muted py-2" style="font-size: 13px;">
        Tidak ada laporan baru
      </li>
    <?php endif; ?>
  </ul>
</li>
<!-- 🔹 Akhir Dropdown Notifikasi -->


                    <!-- 🔹 Profil User -->
                    <li class="nav-item topbar-user dropdown hidden-caret ms-3">
                        <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                            <div class="avatar-sm d-flex align-items-center justify-content-center bg-primary text-white rounded-circle">
                                <i class="fas fa-user"></i>
                            </div>
                            <span class="profile-username ms-2">
                                <span class="op-7">Hi,</span>
                                <span class="fw-bold"><?= $_SESSION['username'] ?></span>
                            </span>
                        </a>

                        <ul class="dropdown-menu dropdown-user animated fadeIn border-0 shadow"
                            style="background-color: #fff; width: 200px; padding: 10px; border-radius: 10px;">
                            <li>
                                <div class="user-box d-flex align-items-center p-2">
                                    <div class="avatar-md d-flex align-items-center justify-content-center bg-primary text-white rounded-circle"
                                        style="width: 45px; height: 45px;">
                                        <i class="fas fa-user fa-lg"></i>
                                    </div>
                                    <div class="u-text ms-3">
                                        <h6 class="mb-0 fw-bold" style="font-size: 14px; color: #333;">
                                            <?= $_SESSION['username'] ?>
                                        </h6>
                                        <p class="text-muted mb-0" style="font-size: 12px;">
                                            <?= $_SESSION['nama_petugas'] ?>
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>
        <!-- End Navbar -->
        <!-- 🔹 JS Hilangkan badge merah kalau diklik -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const notifDropdown = document.getElementById('notifDropdown');

                notifDropdown.addEventListener('click', function() {
                    const badge = this.querySelector('.badge');
                    if (badge) badge.remove();

                    fetch('../../actions/notifikasi_navbar/mark_as_read.php')
                        .then(res => res.text())
                        .then(text => console.log('Server response:', text))
                        .catch(err => console.error('Fetch error:', err));
                });
            });
        </script>


    </div>