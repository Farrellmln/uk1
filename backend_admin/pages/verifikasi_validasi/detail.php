<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
include '../../app.php';

if (!isset($_GET['id'])) {
  echo "<script>alert('ID Laporan tidak ditemukan!'); window.location.href='index.php';</script>";
  exit;
}

$id = $_GET['id'];
$query = "
  SELECT p.*, m.nama AS nama_pelapor, m.nik, m.telp 
  FROM pengaduan p
  JOIN masyarakat m ON p.nik = m.nik
  WHERE p.id_pengaduan = '$id'
";
$result = mysqli_query($connect, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
  echo "<script>alert('Data tidak ditemukan!'); window.location.href='index.php';</script>";
  exit;
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
  .content-wrapper {
    background-color: #f8fafc;
    min-height: 100vh;
    padding: 90px 70px 50px 70px;
  }

  .page-title {
    font-size: 1.9rem;
    font-weight: 600;
    color: #1b3c74;
    margin-bottom: 8px;
  }

  .breadcrumb {
    color: #6c757d;
    font-size: 0.95rem;
    margin-bottom: 25px;
  }

  .card-custom {
    border-radius: 12px;
    overflow: hidden;
    background-color: #fff;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
  }

  .card-header-custom {
    background-color: #004c84;
    color: white;
    padding: 18px 24px;
    font-weight: 500;
  }

  .card-body {
    padding: 30px 35px;
  }

  .detail-label {
    font-weight: 600;
    color: #1b3c74;
  }

  .detail-value {
    color: #333;
  }

  /* --- BADGE STATUS --- */
  .badge-status {
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: 500;
    color: #fff !important;
  }

  .badge-primary { background-color: #007bff !important; }
  .badge-warning { background-color: #ff8800 !important; }
  .badge-success { background-color: #28a745 !important; }
  .badge-secondary { background-color: #6c757d !important; }

  /* --- BADGE TINGKAT (SOFT + ICON) --- */
  .badge-tingkat {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 25px;
    font-weight: 500;
    border: 1.6px solid transparent;
  }

  .badge-urgent {
    color: #dc3545;
    border-color: #dc3545;
    background-color: rgba(220, 53, 69, 0.1);
  }

  .badge-warning2 {
    color: #ff8800;
    border-color: #ff8800;
    background-color: rgba(255, 136, 0, 0.1);
  }

  .badge-info2 {
    color: #198754;
    border-color: #198754;
    background-color: rgba(25, 135, 84, 0.1);
  }

  .badge-tingkat i {
    font-size: 1rem;
  }

  .btn-back {
    background-color: #6c757d;
    color: white;
    border: none;
    border-radius: 10px;
    padding: 10px 22px;
    font-weight: 500;
    transition: 0.3s;
  }

  .btn-back:hover {
    background-color: #5a6268;
  }

  .card-footer-right {
    display: flex;
    justify-content: flex-end;
    padding: 16px 24px;
    background-color: #f8f9fa;
    border-top: none;
  }

  .report-image {
    border-radius: 8px;
    object-fit: cover;
    width: 300px;
    height: 220px;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
  }

  hr {
    border-top: 1px solid #dee2e6;
  }
</style>

<div class="content-wrapper">
  <div class="page-title">Detail Laporan Pengaduan</div>
  <div class="breadcrumb">Dashboard / Laporan / Detail Laporan</div>

  <div class="card card-custom">
    <div class="card-header-custom">Detail Pengaduan</div>

    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-6">
          <p><span class="detail-label">ID Pengaduan:</span>
            <span class="detail-value"><?= $data['id_pengaduan'] ?></span></p>
          <p><span class="detail-label">Tanggal:</span>
            <span class="detail-value"><?= date('d-m-Y', strtotime($data['tgl_pengaduan'])) ?></span></p>
          <p><span class="detail-label">NIK:</span>
            <span class="detail-value"><?= htmlspecialchars($data['nik']) ?></span></p>
          <p><span class="detail-label">Nama Pelapor:</span>
            <span class="detail-value"><?= htmlspecialchars($data['nama_pelapor']) ?></span></p>
          <p><span class="detail-label">Telepon:</span>
            <span class="detail-value"><?= htmlspecialchars($data['telp']) ?></span></p>

          <p>
            <span class="detail-label">Tingkat:</span>
            <?php
              $tingkat = strtolower($data['tingkat']);
              if ($tingkat === 'urgent') {
                echo '<span class="badge-tingkat badge-urgent"><i class="bi bi-exclamation-octagon"></i> Urgent</span>';
              } elseif ($tingkat === 'warning') {
                echo '<span class="badge-tingkat badge-warning2"><i class="bi bi-exclamation-triangle"></i> Warning</span>';
              } else {
                echo '<span class="badge-tingkat badge-info2"><i class="bi bi-info-circle"></i> Info</span>';
              }
            ?>
          </p>
        </div>

        <div class="col-md-6 text-center">
          <?php if (!empty($data['foto'])): ?>
            <img src="../../../storages/laporan_pengaduan/<?= $data['foto'] ?>"
                 alt="Foto Laporan" class="report-image mb-3">
          <?php else: ?>
            <p class="text-muted">Tidak ada foto</p>
          <?php endif; ?>

          <p>
            <span class="detail-label">Status:</span>
            <?php
              $status = $data['status'];
              switch ($status) {
                case '0':
                  echo '<span class="badge-status badge-primary">Baru</span>';
                  break;
                case 'proses':
                  echo '<span class="badge-status badge-warning">Proses</span>';
                  break;
                case 'selesai':
                  echo '<span class="badge-status badge-success">Selesai</span>';
                  break;
                default:
                  echo '<span class="badge-status badge-secondary">Tidak diketahui</span>';
              }
            ?>
          </p>
        </div>
      </div>

      <hr>

      <div class="mb-4">
        <h5 class="detail-label">Isi Laporan:</h5>
        <p class="detail-value" style="text-align: justify;">
          <?= nl2br(htmlspecialchars($data['isi_laporan'])) ?>
        </p>
      </div>

      <?php
      $queryTanggapan = "
        SELECT t.tgl_tanggapan, t.tanggapan, p.nama_petugas 
        FROM tanggapan t 
        JOIN petugas p ON t.id_petugas = p.id_petugas 
        WHERE t.id_pengaduan = '$id'
        ORDER BY t.tgl_tanggapan DESC
      ";
      $resTanggapan = mysqli_query($connect, $queryTanggapan);
      ?>

      <?php if (mysqli_num_rows($resTanggapan) > 0): ?>
        <hr>
        <h5 class="detail-label mb-3">Tanggapan Petugas:</h5>
        <?php while ($tg = mysqli_fetch_assoc($resTanggapan)): ?>
          <div class="p-3 mb-3 border rounded bg-light">
            <p class="mb-1"><strong><?= htmlspecialchars($tg['nama_petugas']) ?></strong></p>
            <p class="text-muted" style="font-size: 0.9rem;">
              <?= date('d-m-Y', strtotime($tg['tgl_tanggapan'])) ?>
            </p>
            <p><?= nl2br(htmlspecialchars($tg['tanggapan'])) ?></p>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <hr>
        <p class="text-muted">Belum ada tanggapan dari petugas.</p>
      <?php endif; ?>
    </div>

    <div class="card-footer-right">
      <a href="index.php" class="btn-back"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>
  </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>
