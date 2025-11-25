<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
include '../../app.php';
session_start();
global $connect;

// Cek apakah sudah login dan ada NIK di session
if (!isset($_SESSION['nik'])) {
  echo "
    <script>
      alert('Silakan login terlebih dahulu!');
      window.location.href = '../../auth/login.php';
    </script>
  ";
  exit;
}

$nik = $_SESSION['nik']; // Ambil nik dari session
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<style>
  :root {
    --main-blue: #005B8F;
  }

  .main-panel {
    margin-left: 250px;
    padding-top: 80px;
    background-color: #f8f9fa;
    min-height: 100vh;
    overflow-y: auto;
  }

  .page-inner {
    padding: 30px 60px;
  }

  .card-box {
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    border: none;
    background: white;
    margin-bottom: 70px;
  }

  .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: var(--main-blue);
    color: white;
    padding: 1rem 1.5rem;
    border-radius: 12px 12px 0 0;
  }

  .card-title {
    color: white !important;
    font-weight: 600;
  }

  .btn-primary.with-icon {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 25px;
    font-weight: 500;
    background-color: white;
    color: var(--main-blue);
    border: 2px solid white;
    transition: all 0.3s ease;
  }

  .btn-primary.with-icon:hover {
    background-color: #ffffffcc;
    transform: translateY(-2px);
  }

  .table {
    border: 1px solid #dee2e6 !important;
  }

  .table th,
  .table td {
    vertical-align: middle !important;
    text-align: center !important;
    border: 1px solid #dee2e6 !important;
  }

  thead.table-primary th {
    background-color: #EAF3F9 !important;
    color: var(--main-blue) !important;
    font-weight: 600;
  }

  .table-img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
  }

  .badge-info-custom {
    background-color: #17a2b8;
  }

  .badge-warning-custom {
    background-color: #ffc107;
    color: #212529;
  }

  .badge-urgent-custom {
    background-color: #dc3545;
  }

  .dataTables_wrapper {
    margin-top: 15px !important;
    margin-bottom: 15px !important;
  }

  .dataTables_wrapper .dataTables_filter {
    margin-bottom: 10px !important;
  }

  .dataTables_wrapper .dataTables_length select {
    border-radius: 5px;
    border: 1px solid var(--main-blue);
    padding: 5px;
  }

  .dataTables_wrapper .dataTables_filter input {
    border-radius: 25px;
    border: 1px solid var(--main-blue);
    padding: 8px 16px;
  }

  .dataTables_wrapper .dataTables_filter input:focus {
    border-color: var(--main-blue);
    box-shadow: 0 0 8px rgba(0, 91, 143, 0.3);
  }

  .dataTables_wrapper .dataTables_paginate {
    margin-top: 15px !important;
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background-color: var(--main-blue) !important;
    color: white !important;
  }

  footer.app-footer {
    margin-top: 20px;
    background-color: #fff;
    color: #666;
    text-align: center;
    padding: 15px 0;
    border-top: 1px solid #ddd;
  }
</style>

<div class="main-panel">
  <div class="page-inner">
    <h1 class="fw-bold mb-3" style="color:var(--main-blue);">Laporan Pengaduan</h1>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item"><a href="../dashboard/index.php">Dashboard</a></li>
      <li class="breadcrumb-item active">Halaman Laporan Pengaduan</li>
    </ol>

    <div class="card w-100 card-box">
      <div class="card-header">
        <h4 class="card-title">Tabel Laporan Pengaduan</h4>
        <a href="create.php" class="btn btn-primary with-icon">
          <i class="bi bi-plus-lg"></i> Tambah Laporan
        </a>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table id="pengaduanTable" class="display table table-bordered table-hover text-center align-middle" style="width:100%">
            <thead class="table-primary">
              <tr>
                <th>No</th>
                <th>Tanggal Pengaduan</th>
                <th>NIK</th>
                <th>Isi Laporan</th>
                <th>Foto</th>
                <th>Tingkat</th> <!-- 🔹 Tambahan Kolom -->
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $query = "SELECT * FROM pengaduan WHERE nik = '$nik' ORDER BY id_pengaduan DESC";
              $result = mysqli_query($connect, $query);
              $no = 1;

              if (mysqli_num_rows($result) > 0) :
                while ($item = mysqli_fetch_object($result)) :
              ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($item->tgl_pengaduan) ?></td>
                    <td><?= htmlspecialchars($item->nik) ?></td>
                    <td>
                      <?php
                      $isi_laporan = htmlspecialchars($item->isi_laporan);
                      echo strlen($isi_laporan) > 50 ? substr($isi_laporan, 0, 50) . '...' : $isi_laporan;
                      ?>
                    </td>
                    <td>
                      <?php if (!empty($item->foto)) : ?>
                        <img src="../../../storages/laporan_pengaduan/<?= htmlspecialchars($item->foto) ?>" alt="Foto" class="table-img">
                      <?php else : ?>
                        <span class="text-muted">Tidak ada</span>
                      <?php endif; ?>
                    </td>

                    <!-- 🔹 Kolom Tingkat -->
                    <!-- 🔹 Kolom Tingkat -->
                    <td>
                      <?php
                      if ($item->tingkat == 'urgent') {
                        echo '<span class="badge" style="background: transparent; color: #dc3545; font-weight:600;">🔴 Urgent</span>';
                      } elseif ($item->tingkat == 'warning') {
                        echo '<span class="badge" style="background: transparent; color: #ffc107; font-weight:600;">🟠 Warning</span>';
                      } else {
                        echo '<span class="badge" style="background: transparent; color: #17a2b8; font-weight:600;">🟢 Info</span>';
                      }
                      ?>
                    </td>


                    <td>
                      <?php
                      if ($item->status == '0') echo '<span class="badge bg-secondary">Baru</span>';
                      elseif ($item->status == 'proses') echo '<span class="badge bg-warning text-dark">Proses</span>';
                      elseif ($item->status == 'selesai') echo '<span class="badge bg-success">Selesai</span>';
                      else echo '<span class="badge bg-light text-dark">Tidak Diketahui</span>';
                      ?>
                    </td>
                    <td>
                      <div class="d-flex justify-content-center gap-2">
                        <a href="detail.php?id=<?= $item->id_pengaduan ?>" class="btn btn-sm btn-success"><i class="bi bi-eye"></i></a>
                        <a href="edit.php?id=<?= $item->id_pengaduan ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                        <a href="../../actions/laporan_pengaduan/destroy.php?id=<?= $item->id_pengaduan ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus laporan ini?')">
                          <i class="bi bi-trash"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
              <?php
                endwhile;
              else :
                echo '<tr><td colspan="8" class="text-muted">Belum ada laporan yang Anda buat.</td></tr>';
              endif;
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include '../../partials/script.php';
include '../../partials/footer.php';
?>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function() {
    $('#pengaduanTable').DataTable({
      pageLength: 5,
      lengthMenu: [5, 10, 20],
      language: {
        search: "Cari:",
        lengthMenu: "Tampilkan _MENU_ data",
        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        paginate: {
          next: "Selanjutnya",
          previous: "Sebelumnya"
        },
        emptyTable: "Tidak ada data tersedia"
      }
    });
  });
</script>