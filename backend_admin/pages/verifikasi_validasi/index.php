<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
include '../../app.php';
?>

<!-- Bootstrap Icons -->
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
    .btn-detail { background-color: #17a2b8; }
    .btn-detail:hover { background-color: #138496; }
    .btn-verify { background-color: #28a745; }
    .btn-verify:hover { background-color: #218838; }
    .btn-tanggapi { background-color: #ffc107; color: #fff; }
    .btn-tanggapi:hover { background-color: #e0a800; color: #fff; }
    .btn-delete { background-color: #dc3545; }
    .btn-delete:hover { background-color: #c82333; }
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
    .tingkat-box {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 16px;
        font-weight: 500;
        font-size: 0.9rem;
        backdrop-filter: blur(4px);
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.03);
    }
    .tingkat-urgent { background: rgba(220, 53, 69, 0.12); color: #b71c1c; }
    .tingkat-warning { background: rgba(255, 159, 10, 0.12); color: #cc6600; }
    .tingkat-info { background: rgba(40, 167, 69, 0.12); color: #1b5e20; }
</style>

<div class="content-wrapper">
    <div class="page-title">Verifikasi & Validasi</div>
    <div class="breadcrumb">Dashboard / Laporan / Verifikasi & Validasi</div>

    <div class="card card-custom">
        <div class="card-header-custom">
            <span>Tabel Laporan Masyarakat</span>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="verifTable" class="table table-bordered align-middle text-center mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Nama Pelapor</th>
                            <th>Isi Laporan</th>
                            <th>Foto</th>
                            <th>Tingkat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // ✅ QUERY URUTAN SESUAI KOMBINASI STATUS + TINGKAT
                        $query = "
                            SELECT p.id_pengaduan, p.nik, p.tgl_pengaduan, m.nama AS nama_pelapor,
                                   p.isi_laporan, p.foto, p.status, p.tingkat
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
                                p.id_pengaduan DESC
                        ";
                        $result = mysqli_query($connect, $query) or die(mysqli_error($connect));

                        while ($row = mysqli_fetch_assoc($result)):
                            $status = $row['status'] ?? '0';
                            $tingkat = strtolower($row['tingkat'] ?? 'info');
                            $isi_singkat = strlen($row['isi_laporan']) > 30 
                                ? substr($row['isi_laporan'], 0, 30) . '...' 
                                : $row['isi_laporan'];
                        ?>
                        <tr>
                            <td><?= $row['id_pengaduan'] ?></td>
                            <td><?= date('d-m-Y', strtotime($row['tgl_pengaduan'])) ?></td>
                            <td><?= htmlspecialchars($row['nama_pelapor']) ?></td>
                            <td style="max-width: 250px; text-align: left;"><?= htmlspecialchars($isi_singkat) ?></td>
                            <td>
                                <?php if (!empty($row['foto'])): ?>
                                    <img src="../../../storages/laporan_pengaduan/<?= $row['foto'] ?>" alt="foto" width="70" height="70" style="object-fit:cover;border-radius:5px;">
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada foto</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($tingkat === 'urgent'): ?>
                                    <div class="tingkat-box tingkat-urgent"><i class="bi bi-exclamation-octagon"></i> Urgent</div>
                                <?php elseif ($tingkat === 'warning'): ?>
                                    <div class="tingkat-box tingkat-warning"><i class="bi bi-exclamation-triangle"></i> Warning</div>
                                <?php else: ?>
                                    <div class="tingkat-box tingkat-info"><i class="bi bi-info-circle"></i> Info</div>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php
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
                                        break;
                                }
                                ?>
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="detail.php?id=<?= $row['id_pengaduan'] ?>" 
                                       class="btn-action btn-detail" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <?php if ($status == '0'): ?>
                                        <a href="../../actions/verifikasi_validasi/verifikasi_action.php?id=<?= $row['id_pengaduan'] ?>&status=proses"
                                           onclick="return confirm('Verifikasi laporan ini menjadi PROSES?')"
                                           class="btn-action btn-verify" title="Verifikasi">
                                           <i class="bi bi-check-circle"></i>
                                        </a>
                                    <?php elseif ($status == 'proses'): ?>
                                        <a href="../beri_tanggapan/create.php?id=<?= $row['id_pengaduan'] ?>" 
                                           class="btn-action btn-tanggapi" title="Beri Tanggapan">
                                           <i class="bi bi-chat-dots"></i>
                                        </a>
                                    <?php endif; ?>

                                    <a href="../../actions/verifikasi_validasi/destroy.php?id=<?= $row['id_pengaduan'] ?>"

                                       onclick="return confirm('Yakin hapus data ini?')"
                                       class="btn-action btn-delete" title="Hapus">
                                       <i class="bi bi-trash"></i>
                                    </a>
                                </div>
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

<script>
$(document).ready(function() {
    $('#verifTable').DataTable({
        "pageLength": 10,
        "lengthMenu": [10, 25, 50, 100],
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data",
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
