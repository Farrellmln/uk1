<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
include '../../app.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan!');window.location.href='index.php';</script>";
    exit;
}

$id = $_GET['id'];
$qSelect = "SELECT * FROM pengaduan WHERE id_pengaduan = '$id'";
$result = mysqli_query($connect, $qSelect);
$pengaduan = mysqli_fetch_object($result);

if (!$pengaduan) {
    echo "<script>alert('Data pengaduan tidak ditemukan!');window.location.href='index.php';</script>";
    exit;
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    html,
    body {
        height: 100%;
        background-color: #f8f9fa;
    }

    /* wrapper utama biar gak ketumpuk sidebar */
    .page-wrapper {
        margin-left: 250px;
        padding: 90px 40px 40px 40px;
    }

    .page-inner {
        max-width: 1000px;
        margin: 0 auto 40px auto;
        /* jarak bawah 40px seperti create */
    }

    .card-box {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border: none;
        overflow: hidden;
        background-color: #fff;
    }

    .card-header {
        background-color: #0a4da3;
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px 12px 0 0;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
    }

    .card-body {
        background-color: #ffffff;
        padding: 2rem;
    }

    .detail-item {
        margin-bottom: 1.2rem;
    }

    .detail-label {
        font-weight: 600;
        color: #0a4da3;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 0.3rem;
    }

    .img-preview-detail {
        max-width: 220px;
        border-radius: 10px;
        border: 2px solid #e3e6f0;
        padding: 4px;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        color: white;
    }

    .status-badge.baru {
        background-color: #007bff;
    }

    .status-badge.proses {
        background-color: #ffc107;
        color: #333;
    }

    .status-badge.selesai {
        background-color: #28a745;
    }

    .btn-secondary.with-icon {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 25px;
        font-weight: 500;
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-secondary.with-icon:hover {
        transform: translateY(-2px);
        background-color: #5a6268;
        border-color: #5a6268;
    }

    h2.page-title {
        color: #0a4da3;
        font-size: 1.8rem;
        font-weight: 700;
    }

    .breadcrumb a {
        color: #0a4da3;
        text-decoration: none;
        font-weight: 500;
    }

    .breadcrumb .active {
        color: #6c757d;
    }

    @media (max-width: 992px) {
        .page-wrapper {
            margin-left: 0;
            padding: 80px 20px;
        }
    }
</style>

<div class="page-wrapper">
    <div class="page-inner">
        <h2 class="page-title mb-3">Detail Laporan Pengaduan</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="../dashboard/index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php">Laporan Pengaduan</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>

        <div class="card card-box">
            <div class="card-header">
                <i class="bi bi-info-circle"></i> Informasi Laporan
            </div>

            <div class="card-body">
                <div class="detail-item">
                    <div class="detail-label"><i class="bi bi-calendar-date"></i> Tanggal Pengaduan</div>
                    <p><?= htmlspecialchars($pengaduan->tgl_pengaduan) ?></p>
                </div>

                <div class="detail-item">
                    <div class="detail-label"><i class="bi bi-person-badge"></i> NIK Pelapor</div>
                    <p><?= htmlspecialchars($pengaduan->nik) ?></p>
                </div>

                <!-- 🔹 Tambahan: Tingkat Laporan -->
                <div class="detail-item">
                    <div class="detail-label"><i class="bi bi-lightning-charge"></i> Tingkat Laporan</div>
                    <?php
                    if ($pengaduan->tingkat == 'urgent') {
                        echo '<span class="badge" style="background: transparent; color: #dc3545; font-weight:600;">🔴 Urgent</span>';
                    } elseif ($pengaduan->tingkat == 'warning') {
                        echo '<span class="badge" style="background: transparent; color: #ffc107; font-weight:600;">🟠 Warning</span>';
                    } else {
                        echo '<span class="badge" style="background: transparent; color: #17a2b8; font-weight:600;">🟢 Info</span>';
                    }
                    ?>
                </div>
                <!-- 🔹 End Tingkat -->

                <div class="detail-item">
                    <div class="detail-label"><i class="bi bi-flag"></i> Status Laporan</div>
                    <?php
                    $status = $pengaduan->status;
                    $badgeClass = $status === '0' ? 'baru' : ($status === 'proses' ? 'proses' : 'selesai');
                    $statusText = $status === '0' ? 'Baru' : ucfirst($status);
                    ?>
                    <span class="status-badge <?= $badgeClass; ?>"><?= $statusText; ?></span>
                </div>

                <div class="detail-item">
                    <div class="detail-label"><i class="bi bi-chat-dots"></i> Isi Laporan</div>
                    <p><?= nl2br(htmlspecialchars($pengaduan->isi_laporan)) ?></p>
                </div>

                <div class="detail-item">
                    <div class="detail-label"><i class="bi bi-image"></i> Foto Bukti</div>
                    <?php if (!empty($pengaduan->foto)) : ?>
                        <img src="../../../storages/laporan_pengaduan/<?= htmlspecialchars($pengaduan->foto) ?>"
                            alt="Foto Bukti" class="img-preview-detail">
                    <?php else : ?>
                        <p>Tidak ada foto bukti</p>
                    <?php endif; ?>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="index.php" class="btn btn-secondary with-icon">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>