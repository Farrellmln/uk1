<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
include '../../partials/admin_only.php';
include '../../app.php';

// Ambil data petugas
$qPetugas = "SELECT * FROM petugas ORDER BY id_petugas DESC";
$result = mysqli_query($connect, $qPetugas) or die(mysqli_error($connect));
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
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 500;
    }

    .btn-tambah {
        background-color: #0d6efd;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 15px;
        transition: all 0.2s;
    }

    .btn-tambah:hover {
        background-color: #0b5ed7;
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

    /* Tombol aksi */
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

    .btn-edit {
        background-color: #fbc02d;
    }

    .btn-edit:hover {
        background-color: #f9a825;
    }

    .btn-delete {
        background-color: #ef5350;
    }

    .btn-delete:hover {
        background-color: #e53935;
    }

    /* Badge Level */
    .badge-level {
        padding: 6px 14px;
        border-radius: 20px;
        color: #fff;
        font-weight: 500;
    }

    .badge-admin {
        background-color: #007bff;
    }

    .badge-petugas {
        background-color: #28a745;
    }
</style>

<div class="content-wrapper">
    <div class="page-title">Data Petugas</div>
    <div class="breadcrumb">Dashboard / Halaman Data Petugas</div>

    <div class="card card-custom">
        <div class="card-header-custom">
            <span>Tabel Akun Petugas</span>
            <a href="create.php" class="btn-tambah"><i class="bi bi-plus-circle"></i> Tambah Petugas</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="petugasTable" class="table table-bordered align-middle text-center mb-0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">NO</th>
                            <th>NAMA</th>
                            <th>USERNAME</th>
                            <th>LEVEL</th>
                            <th>TELEPON</th>
                            <th style="width: 15%;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0):
                            $no = 1;
                            while ($item = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($item['nama_petugas']); ?></td>
                            <td><?= htmlspecialchars($item['username']); ?></td>
                            <td>
                                <?php if ($item['level'] == 'admin'): ?>
                                    <span class="badge-level badge-admin">Admin</span>
                                <?php else: ?>
                                    <span class="badge-level badge-petugas">Petugas</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($item['telp']); ?></td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="edit_petugas.php?id=<?= $item['id_petugas']; ?>" 
                                       class="btn-action btn-edit" title="Edit Petugas">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="../../actions/registrasi_petugas/destroy.php?id=<?= $item['id_petugas']; ?>" 
                                       onclick="return confirm('Yakin ingin menghapus data ini?')" 
                                       class="btn-action btn-delete" title="Hapus Petugas">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data petugas.</td>
                        </tr>
                        <?php endif; ?>
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
    $('#petugasTable').DataTable({
        "pageLength": 10, // tampilkan default 10 data
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
