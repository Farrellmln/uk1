<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
include '../../app.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID tidak valid.');window.location.href='index.php';</script>";
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM pengaduan WHERE id_pengaduan = '$id'";
$result = mysqli_query($connect, $query);
$pengaduan = mysqli_fetch_object($result);

if (!$pengaduan) {
    echo "<script>alert('Data tidak ditemukan!');window.location.href='index.php';</script>";
    exit;
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    :root {
        --main-blue: #004aad;
    }

    /* wrapper utama (biar sama kayak create) */
    .page-wrapper {
        margin-left: 250px;
        padding: 90px 40px 40px 40px;
        /* jarak atas & bawah pas */
        background-color: #f8f9fa;
        min-height: 100vh;
    }

    /* kontainer tengah */
    .page-inner {
        max-width: 1000px;
        margin: 0 auto 40px auto;
        /* jarak bawah 40px sebelum footer */
    }

    /* card utama */
    .card-box {
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        border: none;
        overflow: hidden;
        background: #fff;
    }

    /* header card */
    .card-header {
        background-color: var(--main-blue);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 14px 14px 0 0;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        font-size: 1.1rem;
    }

    /* body card */
    .card-body {
        background-color: #ffffff;
        padding: 2rem;
    }

    /* judul halaman */
    h1.page-title {
        color: var(--main-blue);
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        text-align: center;
    }

    /* breadcrumb */
    .breadcrumb {
        display: flex;
        justify-content: center;
        font-size: 0.95rem;
    }

    .breadcrumb a {
        color: var(--main-blue);
        text-decoration: none;
    }

    .breadcrumb .active {
        color: #6c757d;
    }

    /* label form */
    .form-label {
        font-weight: 600;
        color: var(--main-blue);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 6px;
    }

    /* foto preview */
    .img-preview-edit {
        max-width: 180px;
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 5px;
        margin-bottom: 10px;
    }

    /* tombol */
    .btn-primary.with-icon,
    .btn-secondary.with-icon {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary.with-icon {
        background-color: var(--main-blue);
        border-color: var(--main-blue);
        color: white;
    }

    .btn-primary.with-icon:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .btn-secondary.with-icon {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary.with-icon:hover {
        transform: translateY(-2px);
    }

    /* responsif */
    @media (max-width: 992px) {
        .page-wrapper {
            margin-left: 0;
            padding: 80px 20px;
        }
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }
    }
</style>

<div class="page-wrapper">
    <div class="page-inner">
        <h1 class="page-title">Edit Laporan Pengaduan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="../dashboard/index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php">Laporan Pengaduan</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>

        <div class="card card-box">
            <div class="card-header">
                <i class="bi bi-pencil-square"></i> Form Edit Pengaduan
            </div>

            <div class="card-body">
                <form action="../../actions/laporan_pengaduan/update.php?id=<?= $pengaduan->id_pengaduan ?>" method="POST" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-person-badge"></i> NIK Pelapor</label>
                        <input type="text" name="nik" class="form-control" value="<?= htmlspecialchars($pengaduan->nik) ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-calendar-date"></i> Tanggal Pengaduan</label>
                        <input type="date" name="tgl_pengaduan" class="form-control" value="<?= htmlspecialchars($pengaduan->tgl_pengaduan) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-lightning-charge"></i> Tingkat Laporan</label>
                        <select name="tingkat" class="form-select" required>
                            <option value="info" <?= $pengaduan->tingkat == 'info' ? 'selected' : '' ?>>🟢 Info</option>
                            <option value="warning" <?= $pengaduan->tingkat == 'warning' ? 'selected' : '' ?>>🟠 Warning</option>
                            <option value="urgent" <?= $pengaduan->tingkat == 'urgent' ? 'selected' : '' ?>>🔴 Urgent</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-chat-dots"></i> Isi Laporan</label>
                        <textarea name="isi_laporan" rows="4" class="form-control" required><?= htmlspecialchars($pengaduan->isi_laporan) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-image"></i> Foto Bukti</label><br>
                        <?php if (!empty($pengaduan->foto)) : ?>
                            <img src="../../../storages/laporan_pengaduan/<?= htmlspecialchars($pengaduan->foto) ?>" alt="Foto Bukti" class="img-preview-edit">
                        <?php endif; ?>
                        <input type="file" name="foto" class="form-control mt-2">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="index.php" class="btn btn-secondary with-icon me-2">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <button type="submit" name="tombol" class="btn btn-primary with-icon">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>