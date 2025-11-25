<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
include '../../app.php';
global $connect;

// --- DATA DATABASE ---
$total_laporan   = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) AS total FROM pengaduan"))['total'];
$laporan_proses  = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) AS total FROM pengaduan WHERE status='proses'"))['total'];
$laporan_selesai = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) AS total FROM pengaduan WHERE status='selesai'"))['total'];
$laporan_baru    = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) AS total FROM pengaduan WHERE status='0'"))['total'];

// ✅ Urutkan berdasarkan status + tingkat (Baru > Proses > Selesai, lalu Urgent > Warning > Info)
$pesan_terbaru = mysqli_query($connect, "
  SELECT p.tgl_pengaduan, p.isi_laporan, p.status, p.tingkat, m.nama 
  FROM pengaduan p
  JOIN masyarakat m ON p.nik = m.nik
  ORDER BY 
    CASE 
      WHEN p.status = '0' AND p.tingkat = 'urgent' THEN 1
      WHEN p.status = '0' AND p.tingkat = 'warning' THEN 2
      WHEN p.status = '0' AND p.tingkat = 'info' THEN 3
      WHEN p.status = 'proses' AND p.tingkat = 'urgent' THEN 4
      WHEN p.status = 'proses' AND p.tingkat = 'warning' THEN 5
      WHEN p.status = 'proses' AND p.tingkat = 'info' THEN 6
      WHEN p.status = 'selesai' AND p.tingkat = 'urgent' THEN 7
      WHEN p.status = 'selesai' AND p.tingkat = 'warning' THEN 8
      WHEN p.status = 'selesai' AND p.tingkat = 'info' THEN 9
      ELSE 10
    END,
    p.tgl_pengaduan DESC
  LIMIT 5
");

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin';
?>

<style>
  body {
    background: #f4f7fb;
    font-family: 'Poppins', sans-serif;
    color: #2a3f5f;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }

  .container-fluid {
    flex: 1;
    padding: 30px 50px;
  }

  .page-header {
    margin-top: 50px;
    text-align: center;
  }

  .page-header h2 {
    font-weight: 700;
    color: #0d47a1;
    font-size: 30px;
    margin-bottom: 10px;
  }

  .page-header p {
    color: #607d8b;
    font-size: 16px;
  }

  .fade-in {
    opacity: 0;
    transform: translateY(10px);
    animation: fadeInUp 0.8s ease forwards;
  }

  @keyframes fadeInUp {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .card-stat {
    border-radius: 16px;
    background: #ffffff;
    border: none;
    padding: 1.3rem 1rem;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    text-align: center;
    transition: all 0.3s ease;
  }

  .card-stat:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
  }

  .card-stat i {
    font-size: 2rem;
    margin-bottom: 0.4rem;
  }

  .card-stat h6 {
    font-weight: 600;
    font-size: 14px;
    color: #607d8b;
  }

  .card-stat h3 {
    font-weight: 700;
    font-size: 22px;
    margin-top: 3px;
  }

  .text-purple {
    color: #7e57c2;
  }

  .text-yellow {
    color: #fbc02d;
  }

  .text-green {
    color: #2ecc71;
  }

  .text-blue {
    color: #1565c0;
  }

  .card {
    border-radius: 16px;
    border: none;
    background: #ffffff;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
  }

  .card-body h6 {
    font-weight: 600;
    color: #1565c0;
  }

  table thead {
    background-color: #e3f2fd;
    color: #0d47a1;
    font-weight: 600;
  }

  table tbody tr:hover {
    background-color: #f5faff;
    transition: 0.3s;
  }

  .badge {
    font-size: 12px;
    padding: 6px 10px;
    border-radius: 8px;
  }

  /* 🎨 Tingkat (INFO, WARNING, URGENT) */
  .badge-tingkat {
    font-size: 13px;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 30px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 1px solid transparent;
  }

  .badge-tingkat.info {
    background-color: #d1f2e0;
    color: #198754;
    border-color: #198754;
  }

  .badge-tingkat.warning {
    background-color: #fff3cd;
    color: #f0ad4e;
    border-color: #f0ad4e;
  }

  .badge-tingkat.urgent {
    background-color: #f8d7da;
    color: #dc3545;
    border-color: #dc3545;
  }

  footer {
    background: #ffffff !important;
    padding: 6px 0 !important;
    text-align: center;
    font-size: 13px;
    color: #607d8b;
    border-top: 1px solid #e0e0e0;
    margin-top: auto;
  }

  footer a {
    color: #1565c0;
    text-decoration: none;
    font-weight: 500;
  }

  footer a:hover {
    text-decoration: underline;
  }
</style>

<div class="container-fluid">
  <div class="page-header mb-5 text-center fade-in">
    <div class="welcome-box mx-auto" style="max-width: 600px;">
      <h2>Selamat Datang, <?= htmlspecialchars($username); ?> 👋</h2>
      <p>Berikut ringkasan laporan dan aktivitas terbaru di sistem pelaporan masyarakat.</p>
    </div>
  </div>

  <!-- STATISTIK -->
  <div class="row g-4 mb-5">
    <div class="col-md-3">
      <div class="card-stat">
        <i class="fas fa-file-alt text-purple"></i>
        <h6>Total Laporan</h6>
        <h3 class="text-purple"><?= $total_laporan; ?></h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card-stat">
        <i class="fas fa-spinner text-yellow"></i>
        <h6>Dalam Proses</h6>
        <h3 class="text-yellow"><?= $laporan_proses; ?></h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card-stat">
        <i class="fas fa-check-circle text-green"></i>
        <h6>Selesai</h6>
        <h3 class="text-green"><?= $laporan_selesai; ?></h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card-stat">
        <i class="fas fa-bell text-blue"></i>
        <h6>Laporan Baru</h6>
        <h3 class="text-blue"><?= $laporan_baru; ?></h3>
      </div>
    </div>
  </div>

  <!-- PESAN TERBARU -->
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold text-primary mb-0">
              <i class="fas fa-envelope me-2"></i>Pesan Terbaru dari Masyarakat
            </h6>
            <a href="../verifikasi_validasi/index.php" class="text-decoration-none text-primary fw-semibold" style="font-size: 14px;">
              Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
            </a>
          </div>
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th width="15%">Tanggal</th>
                <th width="20%">Nama Pengirim</th>
                <th width="35%">Isi Laporan</th>
                <th width="15%">Status</th>
                <th width="15%">Tingkat</th>
              </tr>
            </thead>
            <tbody>
              <?php if (mysqli_num_rows($pesan_terbaru) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($pesan_terbaru)) : ?>
                  <?php
                  $isi_singkat = strlen($row['isi_laporan']) > 50 ? substr($row['isi_laporan'], 0, 50) . '...' : $row['isi_laporan'];

                  switch ($row['status']) {
                    case '0':
                      $status_text = 'Baru';
                      $badge_class = 'bg-primary';
                      break;
                    case 'proses':
                      $status_text = 'Proses';
                      $badge_class = 'bg-warning text-dark';
                      break;
                    case 'selesai':
                      $status_text = 'Selesai';
                      $badge_class = 'bg-success';
                      break;
                    default:
                      $status_text = ucfirst($row['status']);
                      $badge_class = 'bg-secondary';
                  }

                  $tingkat = strtolower($row['tingkat'] ?? '');
                  if ($tingkat === 'info') {
                    $badge_tingkat = '<span class="badge badge-tingkat info"><i class="fas fa-info-circle me-1"></i>Info</span>';
                  } elseif ($tingkat === 'warning') {
                    $badge_tingkat = '<span class="badge badge-tingkat warning"><i class="fas fa-exclamation-triangle me-1"></i>Warning</span>';
                  } elseif ($tingkat === 'urgent') {
                    $badge_tingkat = '<span class="badge badge-tingkat urgent"><i class="fas fa-exclamation-circle me-1"></i>Urgent</span>';
                  } else {
                    $badge_tingkat = '<span class="text-muted">-</span>';
                  }
                  ?>
                  <tr>
                    <td><?= htmlspecialchars($row['tgl_pengaduan']); ?></td>
                    <td><?= htmlspecialchars($row['nama']); ?></td>
                    <td><?= htmlspecialchars($isi_singkat); ?></td>
                    <td><span class="badge <?= $badge_class; ?>"><?= $status_text; ?></span></td>
                    <td><?= $badge_tingkat; ?></td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" class="text-center text-muted py-4">Belum ada pesan masuk</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>~
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>
