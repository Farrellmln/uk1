<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
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
        margin-bottom: 30px;
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

    .btn-action {
        border: none;
        border-radius: 8px;
        color: #fff;
        padding: 10px 16px;
        font-size: 17px;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 44px;
    }

    .btn-tanggapi {
        background-color: #ffc107;
        color: #fff;
    }

    .btn-tanggapi:hover {
        background-color: #e0a800;
        color: #fff;
    }

    .badge-status {
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 500;
        color: #fff !important;
    }

    .badge-warning {
        background-color: #ffc107 !important;
    }

    .badge-success {
        background-color: #28a745 !important;
    }

    /* 🔹 Badge untuk kolom tingkat */
    .badge-tingkat {
        border-radius: 20px;
        font-weight: 500;
        padding: 6px 14px;
        border: 1px solid transparent;
        background: rgba(0, 0, 0, 0.05);
        display: inline-block;
    }

    .badge-tingkat.rendah {
        background: rgba(25, 135, 84, 0.1);
        border-color: #198754;
        color: #198754;
    }

    .badge-tingkat.sedang {
        background: rgba(255, 193, 7, 0.1);
        border-color: #ffc107;
        color: #ffc107;
    }

    .badge-tingkat.tinggi {
        background: rgba(220, 53, 69, 0.1);
        border-color: #dc3545;
        color: #dc3545;
    }

    .badge-tingkat.urgent {
        background: rgba(255, 0, 0, 0.15);
        border-color: #dc3545;
        color: #dc3545;
        font-weight: 600;
    }
</style>

<div class="content-wrapper">
    <div class="page-title">Tanggapan Pengaduan</div>
    <div class="breadcrumb">Dashboard / Laporan / Tanggapan</div>

    <!-- 🔹 PENGADUAN STATUS PROSES -->
    <div class="card card-custom">
        <div class="card-header-custom">Daftar Pengaduan (Proses)</div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tanggapanTable" class="table table-bordered align-middle text-center mb-0">
                    <thead>
                        <tr>
                            <th>ID Pengaduan</th>
                            <th>Tanggal</th>
                            <th>Isi Laporan</th>
                            <th>Foto</th>
                            <th>Tingkat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Urgent paling atas
                        $qProses = "
                            SELECT * FROM pengaduan 
                            WHERE status='proses' 
                            ORDER BY 
                                CASE 
                                    WHEN tingkat='Urgent' THEN 1
                                    WHEN tingkat='Tinggi' THEN 2
                                    WHEN tingkat='Sedang' THEN 3
                                    WHEN tingkat='Rendah' THEN 4
                                    ELSE 5
                                END ASC, 
                                id_pengaduan DESC
                        ";
                        $res = mysqli_query($connect, $qProses);
                        while ($row = mysqli_fetch_assoc($res)):
                            $isi_singkat = strlen($row['isi_laporan']) > 30
                                ? substr($row['isi_laporan'], 0, 30) . '...'
                                : $row['isi_laporan'];

                            $tingkat = strtolower(trim($row['tingkat'] ?? ''));
                            switch ($tingkat) {
                                case 'urgent':
                                    $badge_tingkat = '<span class="badge-tingkat urgent"><i class="bi bi-exclamation-octagon me-1"></i>Urgent</span>';
                                    break;
                                case 'warning':
                                    $badge_tingkat = '<span class="badge-tingkat sedang"><i class="bi bi-exclamation-triangle me-1"></i>Warning</span>';
                                    break;
                                case 'info':
                                    $badge_tingkat = '<span class="badge-tingkat rendah"><i class="bi bi-info-circle me-1"></i>Info</span>';
                                    break;
                                default:
                                    $badge_tingkat = '<span class="text-muted">-</span>';
                            }

                        ?>
                            <tr>
                                <td><?= $row['id_pengaduan'] ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tgl_pengaduan'])) ?></td>
                                <td style="text-align:left;"><?= htmlspecialchars($isi_singkat) ?></td>
                                <td>
                                    <?php if (!empty($row['foto'])): ?>
                                        <img src="../../../storages/laporan_pengaduan/<?= htmlspecialchars($row['foto']) ?>" width="70" height="70" style="object-fit:cover;border-radius:5px;">
                                    <?php else: ?>
                                        <span class="text-muted">Tidak ada foto</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $badge_tingkat ?></td>
                                <td><span class="badge-status badge-warning">Proses</span></td>
                                <td>
                                    <a href="create.php?id=<?= $row['id_pengaduan'] ?>" class="btn-action btn-tanggapi" title="Tanggapi">
                                        <i class="bi bi-chat-dots"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 🔹 RIWAYAT TANGGAPAN -->
    <div class="card card-custom">
        <div class="card-header-custom bg-success">Riwayat Tanggapan</div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="riwayatTable" class="table table-bordered align-middle text-center mb-0">
                    <thead>
                        <tr>
                            <th>ID Pengaduan</th>
                            <th>Tanggal Pengaduan</th>
                            <th>Isi Laporan</th>
                            <th>Tingkat</th>
                            <th>Tanggapan</th>
                            <th>Tanggal Tanggapan</th>
                            <th>Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $qRiwayat = "
                            SELECT p.id_pengaduan, p.tgl_pengaduan, p.isi_laporan, p.tingkat,
                                   t.tanggapan, t.tgl_tanggapan, pg.nama_petugas
                            FROM pengaduan p
                            JOIN tanggapan t ON p.id_pengaduan = t.id_pengaduan
                            JOIN petugas pg ON pg.id_petugas = t.id_petugas
                            WHERE p.status = 'selesai'
                            ORDER BY 
                                CASE 
                                    WHEN p.tingkat='Urgent' THEN 1
                                    WHEN p.tingkat='Tinggi' THEN 2
                                    WHEN p.tingkat='Sedang' THEN 3
                                    WHEN p.tingkat='Rendah' THEN 4
                                    ELSE 5
                                END ASC,
                                p.id_pengaduan DESC
                        ";
                        $resRiwayat = mysqli_query($connect, $qRiwayat);
                        while ($r = mysqli_fetch_assoc($resRiwayat)):
                            $isi_singkat = strlen($r['isi_laporan']) > 200
                                ? substr($r['isi_laporan'], 0, 200) . '...'
                                : $r['isi_laporan'];

                            $tingkat = strtolower(trim($r['tingkat'] ?? ''));
                            switch ($tingkat) {
                                case 'urgent':
                                    $badge_tingkat = '<span class="badge-tingkat urgent"><i class="bi bi-exclamation-octagon me-1"></i>Urgent</span>';
                                    break;
                                case 'warning':
                                    $badge_tingkat = '<span class="badge-tingkat sedang"><i class="bi bi-exclamation-triangle me-1"></i>Warning</span>';
                                    break;
                                case 'info':
                                    $badge_tingkat = '<span class="badge-tingkat rendah"><i class="bi bi-info-circle me-1"></i>Info</span>';
                                    break;
                                default:
                                    $badge_tingkat = '<span class="text-muted">-</span>';
                            }

                        ?>
                            <tr>
                                <td><?= $r['id_pengaduan'] ?></td>
                                <td><?= date('d-m-Y', strtotime($r['tgl_pengaduan'])) ?></td>
                                <td style="text-align:left;"><?= htmlspecialchars($isi_singkat) ?></td>
                                <td><?= $badge_tingkat ?></td>
                                <td><?= htmlspecialchars($r['tanggapan']) ?></td>
                                <td><?= date('d-m-Y', strtotime($r['tgl_tanggapan'])) ?></td>
                                <td><?= htmlspecialchars($r['nama_petugas']) ?></td>
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

<script>
    $(document).ready(function() {
        $('#tanggapanTable, #riwayatTable').DataTable({
            "pageLength": 10,
            "lengthMenu": [10, 25, 50],
            "language": {
                "search": "Cari:",
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya"
                },
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Tidak ada data",
                "infoFiltered": "(disaring dari _MAX_ total data)"
            },
            "ordering": false
        });
    });
</script>