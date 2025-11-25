<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
include '../../app.php';
session_start();

global $connect;

// Ambil NIK dari session (user yang login)
$nik = $_SESSION['nik'];
?>

<style>
:root {
  --main-blue: #005B8F;
}

.page-wrapper {
  margin-left: 250px;
  padding-top: 90px;
  background-color: #f8f9fa;
  min-height: 100vh;
}

.page-inner {
  padding: 20px 60px;
}

h1.dashboard-title {
  color: var(--main-blue);
  font-weight: 700;
  margin-bottom: 30px;
}

.stat-cards {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
  margin-bottom: 25px;
}

.stat-card {
  flex: 1;
  min-width: 250px;
  background: white;
  border: 1px solid #dee2e6;
  border-radius: 12px;
  box-shadow: 0 3px 8px rgba(0,0,0,0.06);
  text-align: center;
  padding: 20px;
}

.stat-card h4 {
  color: var(--main-blue);
  font-weight: 600;
  margin-bottom: 5px;
}

.stat-card p {
  font-size: 1.8rem;
  font-weight: 700;
  color: #333;
  margin: 0;
}

.btn-primary.with-icon {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 18px;
  border-radius: 25px;
  font-weight: 500;
  background-color: var(--main-blue);
  border: none;
  color: white;
  transition: all 0.3s ease;
}
.btn-primary.with-icon:hover {
  background-color: #00446b;
  transform: translateY(-2px);
}

.table {
  border: 1px solid #dee2e6 !important;
}
.table th, .table td {
  border: 1px solid #dee2e6 !important;
  vertical-align: middle !important;
  text-align: center;
}
thead.table-primary th {
  background-color: #EAF3F9 !important;
  color: var(--main-blue) !important;
  font-weight: 600;
}
.table-img {
  width: 60px;
  height: 60px;
  border-radius: 8px;
  object-fit: cover;
}

/* 🔹 Tampilan Tingkat */
.tingkat-wrapper {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-weight: 600;
}
.tingkat-dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  display: inline-block;
}
.tingkat-info { background-color: #00c853; }     /* Hijau */
.tingkat-warning { background-color: #ff9800; }  /* Oranye */
.tingkat-urgent { background-color: #e53935; }   /* Merah */

footer.app-footer {
  margin-top: 40px;
  text-align: center;
  padding: 15px 0;
  color: #666;
  border-top: 1px solid #ddd;
  background: #fff;
}

.btn-outline-primary {
  border-color: var(--main-blue);
  color: var(--main-blue);
  border-radius: 25px;
}
.btn-outline-primary:hover {
  background-color: var(--main-blue);
  color: white;
}
</style>

<div class="page-wrapper">
  <div class="page-inner">
    <h1 class="dashboard-title">Dashboard</h1>

    <?php
    $total = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM pengaduan WHERE nik='$nik'"));
    $diproses = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM pengaduan WHERE nik='$nik' AND status='proses'"));
    $selesai = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM pengaduan WHERE nik='$nik' AND status='selesai'"));
    ?>

    <div class="stat-cards">
      <div class="stat-card">
        <h4>Total Laporan</h4>
        <p><?= $total ?></p>
      </div>
      <div class="stat-card">
        <h4>Laporan Diproses</h4>
        <p><?= $diproses ?></p>
      </div>
      <div class="stat-card">
        <h4>Laporan Selesai</h4>
        <p><?= $selesai ?></p>
      </div>
    </div>

    <a href="../laporan_pengaduan/create.php" class="btn btn-primary with-icon mb-3">
      <i class="bi bi-plus-lg"></i> Buat Laporan Baru
    </a>

    <div class="card card-box mb-5" style="margin-bottom: 80px;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="text-dark fw-semibold m-0">Laporan Terbaru</h5>
          <a href="../laporan_pengaduan/index.php" class="btn btn-outline-primary btn-sm px-3">
            Lihat Semua
          </a>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead class="table-primary">
              <tr>
                <th>Status</th>
                <th>Tingkat</th>
                <th>Tanggal</th>
                <th>Isi Laporan</th>
                <th>Foto</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $query = "SELECT * FROM pengaduan WHERE nik='$nik' ORDER BY id_pengaduan DESC LIMIT 3";
              $result = mysqli_query($connect, $query);
              if (mysqli_num_rows($result) > 0):
                while ($row = mysqli_fetch_object($result)):
              ?>
                <tr>
                  <td>
                    <?php
                    if ($row->status == '0') echo '<span class="badge bg-info text-white">Baru</span>';
                    elseif ($row->status == 'proses') echo '<span class="badge bg-warning text-dark">Proses</span>';
                    elseif ($row->status == 'selesai') echo '<span class="badge bg-success">Selesai</span>';
                    ?>
                  </td>
                  <td>
                    <?php
                    $tingkatClass = '';
                    $tingkatText = '';
                    if ($row->tingkat == 'urgent') {
                      $tingkatClass = 'tingkat-urgent';
                      $tingkatText = 'Urgent';
                    } elseif ($row->tingkat == 'warning') {
                      $tingkatClass = 'tingkat-warning';
                      $tingkatText = 'Warning';
                    } else {
                      $tingkatClass = 'tingkat-info';
                      $tingkatText = 'Info';
                    }
                    ?>
                    <div class="tingkat-wrapper">
                      <span class="tingkat-dot <?= $tingkatClass ?>"></span>
                      <span><?= $tingkatText ?></span>
                    </div>
                  </td>
                  <td><?= htmlspecialchars($row->tgl_pengaduan) ?></td>
                  <td><?= htmlspecialchars(substr($row->isi_laporan, 0, 40)) ?><?= strlen($row->isi_laporan) > 40 ? '...' : '' ?></td>
                  <td>
                    <?php if (!empty($row->foto)) : ?>
                      <img src="../../../storages/laporan_pengaduan/<?= $row->foto ?>" class="table-img" alt="Foto">
                    <?php else : ?>
                      <span class="text-muted">-</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php
                endwhile;
              else:
              ?>
                <tr>
                  <td colspan="5" class="text-muted text-center">Belum ada laporan pengaduan.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

<?php
include '../../partials/script.php';
include '../../partials/footer.php';
?>
