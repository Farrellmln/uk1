<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
include '../../partials/admin_only.php';
include '../../app.php';
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
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
  }

  .card-header-custom {
    background-color: #004c84;
    color: white;
    padding: 18px 24px;
    font-weight: 500;
  }

  .table th {
    background-color: #e8f4fa;
    color: #1b3c74;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
  }

  .table td {
    vertical-align: middle;
    text-align: center;
  }

  .table tbody tr:hover {
    background-color: #f2f9ff;
  }

  .badge-status {
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: 500;
    color: #fff !important;
  }

  .badge-primary { background-color: #007bff !important; }
  .badge-warning { background-color: #ffc107 !important; color: #fff !important; }
  .badge-success { background-color: #28a745 !important; }
  .badge-secondary { background-color: #6c757d !important; }

  /* === STYLE BARU UNTUK TINGKAT === */
  .badge-tingkat {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 600;
    border-radius: 50px;
    padding: 6px 14px;
    font-size: 0.9rem;
  }

  .badge-tingkat.info {
    background-color: #d1f3e0;
    color: #0b875b;
    border: 1px solid #a6e4c3;
  }

  .badge-tingkat.warning {
    background-color: #fff3cd;
    color: #b77900;
    border: 1px solid #ffe69c;
  }

  .badge-tingkat.urgent {
    background-color: #f8d7da;
    color: #b71c1c;
    border: 1px solid #f1aeb5;
  }

  .badge-tingkat i {
    font-size: 1rem;
  }

  .badge-tingkat:hover {
    filter: brightness(0.95);
    transition: 0.2s;
  }

  /* Tombol Export */
  .dt-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    margin-bottom: 15px;
  }

  .dt-button {
    border: none !important;
    border-radius: 8px !important;
    color: #fff !important;
    padding: 8px 14px !important;
    font-weight: 500 !important;
    transition: 0.3s;
    display: inline-flex !important;
    align-items: center;
    gap: 6px;
  }

  .dt-button i { font-size: 1rem; }

  .buttons-pdf { background-color: #dc3545 !important; }
  .buttons-excel { background-color: #198754 !important; }
  .buttons-csv { background-color: #6f42c1 !important; }
  .buttons-print { background-color: #212529 !important; }
  .buttons-copy { background-color: #0078d7 !important; }

  .dt-button:hover { opacity: 0.85; }
</style>

<div class="content-wrapper">
  <div class="page-title">Generate Laporan Pengaduan</div>
  <div class="breadcrumb">Dashboard / Laporan / Generate Laporan</div>

  <div class="card card-custom">
    <div class="card-header-custom d-flex justify-content-between align-items-center">
      <span>Filter & Export Laporan</span>
    </div>

    <div class="card-body">
      <!-- FORM FILTER -->
      <form method="GET" class="mb-4">
        <div class="row g-3 align-items-end justify-content-center">
          <div class="col-md-3">
            <label for="dari" class="form-label fw-semibold text-primary">Dari Tanggal</label>
            <input type="date" class="form-control" name="dari" value="<?= $_GET['dari'] ?? '' ?>">
          </div>
          <div class="col-md-3">
            <label for="sampai" class="form-label fw-semibold text-primary">Sampai Tanggal</label>
            <input type="date" class="form-control" name="sampai" value="<?= $_GET['sampai'] ?? '' ?>">
          </div>
          <div class="col-md-3">
            <label for="status" class="form-label fw-semibold text-primary">Status</label>
            <select name="status" class="form-select">
              <option value="">Semua</option>
              <option value="0" <?= (isset($_GET['status']) && $_GET['status'] == '0') ? 'selected' : '' ?>>Baru</option>
              <option value="proses" <?= (isset($_GET['status']) && $_GET['status'] == 'proses') ? 'selected' : '' ?>>Proses</option>
              <option value="selesai" <?= (isset($_GET['status']) && $_GET['status'] == 'selesai') ? 'selected' : '' ?>>Selesai</option>
            </select>
          </div>
          <div class="col-md-2 text-center">
            <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
          </div>
        </div>
      </form>

      <!-- TABEL -->
      <div class="table-responsive">
        <table id="laporanTable" class="table table-bordered align-middle text-center mb-0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Tanggal</th>
              <th>Nama Pelapor</th>
              <th>Isi Laporan</th>
              <th>Foto</th>
              <th>Status</th>
              <th>Tingkat</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $where = [];
            if (!empty($_GET['dari']) && !empty($_GET['sampai'])) {
              $where[] = "p.tgl_pengaduan BETWEEN '{$_GET['dari']}' AND '{$_GET['sampai']}'";
            }
            if (!empty($_GET['status'])) {
              $where[] = "p.status = '{$_GET['status']}'";
            }
            $whereSQL = count($where) ? "WHERE " . implode(' AND ', $where) : "";

            $sql = "SELECT p.*, m.nama FROM pengaduan p 
                    JOIN masyarakat m ON p.nik = m.nik 
                    $whereSQL 
                    ORDER BY p.id_pengaduan DESC";
            $res = mysqli_query($connect, $sql);

            while ($row = mysqli_fetch_assoc($res)):
            ?>
              <tr>
                <td><?= $row['id_pengaduan'] ?></td>
                <td><?= date('d-m-Y', strtotime($row['tgl_pengaduan'])) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td style="text-align:left;max-width:400px;"><?= nl2br(htmlspecialchars($row['isi_laporan'])) ?></td>
                <td>
                  <?php if ($row['foto']): ?>
                    <img src="../../../storages/laporan_pengaduan/<?= $row['foto'] ?>" width="70" height="70" style="object-fit:cover;border-radius:5px;">
                  <?php else: ?>
                    <span class="text-muted">Tidak ada foto</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php
                  if ($row['status'] == '0') echo '<span class="badge-status badge-primary">Baru</span>';
                  elseif ($row['status'] == 'proses') echo '<span class="badge-status badge-warning">Proses</span>';
                  elseif ($row['status'] == 'selesai') echo '<span class="badge-status badge-success">Selesai</span>';
                  else echo '<span class="badge-status badge-secondary">Tidak Diketahui</span>';
                  ?>
                </td>
                <td>
                  <?php
                  switch ($row['tingkat']) {
                    case 'urgent':
                      echo '<span class="badge-tingkat urgent"><i class="bi bi-exclamation-octagon"></i> Urgent</span>';
                      break;
                    case 'warning':
                      echo '<span class="badge-tingkat warning"><i class="bi bi-exclamation-triangle"></i> Warning</span>';
                      break;
                    case 'info':
                      echo '<span class="badge-tingkat info"><i class="bi bi-info-circle"></i> Info</span>';
                      break;
                    default:
                      echo '<span class="text-muted">Belum diatur</span>';
                  }
                  ?>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>

<!-- DataTables Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
$(document).ready(function() {
  $('#laporanTable').DataTable({
    dom: '<"d-flex justify-content-between align-items-center mb-3"Bf>rtip',
    buttons: [
      { extend: 'print', text: '<i class="bi bi-printer"></i> Print', title: 'Laporan Pengaduan' },
      { extend: 'pdfHtml5', text: '<i class="bi bi-file-earmark-pdf"></i> PDF', title: 'Laporan Pengaduan', orientation: 'landscape', pageSize: 'A4' },
      { extend: 'excelHtml5', text: '<i class="bi bi-file-earmark-excel"></i> Excel', title: 'Laporan Pengaduan' },
      { extend: 'csvHtml5', text: '<i class="bi bi-filetype-csv"></i> CSV', title: 'Laporan Pengaduan' },
      { extend: 'copyHtml5', text: '<i class="bi bi-file-earmark-word"></i> Word', title: 'Laporan Pengaduan' }
    ],
    "pageLength": 10,
    "lengthMenu": [5, 10, 25, 50, 100],
    "language": {
      "lengthMenu": "Tampilkan _MENU_ data per halaman",
      "search": "Cari:",
      "paginate": {"previous": "Sebelumnya", "next": "Selanjutnya"},
      "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
      "infoEmpty": "Tidak ada data"
    }
  });
});
</script>
