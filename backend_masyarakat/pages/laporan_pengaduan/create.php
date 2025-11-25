<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
include '../../app.php';
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['nik'])) {
    echo "
      <script>
        alert('Silakan login terlebih dahulu!');
        window.location.href = '../../auth/login.php';
      </script>
    ";
    exit;
}

// Ambil NIK dari session
$nik = $_SESSION['nik'];
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    html,
    body {
        height: 100%;
        background-color: #f8f9fa;
    }

    .page-wrapper {
        margin-left: 250px;
        padding: 90px 40px 60px 40px;
    }

    .page-inner {
        max-width: 1000px;
        margin: 0 auto 40px auto;
    }

    .card-box {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border: none;
        overflow: hidden;
    }

    .card-header {
        background-color: #0a4da3;
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px 12px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title {
        color: white !important;
        margin-bottom: 0;
        font-weight: 600;
    }

    .card-body {
        background-color: #ffffff;
        padding: 2rem;
    }

    .form-item {
        margin-bottom: 1.5rem;
    }

    .form-item .form-label {
        font-weight: 600;
        color: #0a4da3;
        display: flex;
        align-items: center;
        gap: 8px;
    }

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
        background-color: #0a4da3;
        border-color: #0a4da3;
        color: white;
    }

    .btn-primary.with-icon:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        background-color: #083c7c;
        border-color: #083c7c;
    }

    .btn-secondary.with-icon {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
    }

    .btn-secondary.with-icon:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        background-color: #5a6268;
        border-color: #5a6268;
    }

    h1.page-title {
        color: #0a4da3;
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
</style>

<div class="page-wrapper">
    <div class="page-inner">
        <h1 class="page-title mb-3">Tambah Laporan Pengaduan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="../dashboard/index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php">Laporan Pengaduan</a></li>
            <li class="breadcrumb-item active">Halaman Tambah</li>
        </ol>

        <div class="card card-box">
            <div class="card-header">
                <h4 class="card-title">Form Tambah Laporan Pengaduan</h4>
            </div>

            <div class="card-body">
                <form action="../../actions/laporan_pengaduan/store.php" method="POST" enctype="multipart/form-data">

                    <div class="form-item">
                        <label for="nik" class="form-label">
                            <i class="bi bi-person-badge"></i> NIK
                        </label>
                        <input type="text" name="nik" id="nik" class="form-control" value="<?= htmlspecialchars($nik) ?>" readonly>
                    </div>

                    <div class="form-item">
                        <label for="isi_laporan" class="form-label">
                            <i class="bi bi-chat-left-text"></i> Isi Laporan
                        </label>
                        <textarea name="isi_laporan" id="isi_laporan" class="form-control" placeholder="Tuliskan isi laporan Anda..." rows="4" required></textarea>
                    </div>

                    <div class="form-item">
                        <label for="foto" class="form-label">
                            <i class="bi bi-image"></i> Foto (Opsional)
                        </label>
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>

                    <div class="form-item">
                        <label for="tgl_pengaduan" class="form-label">
                            <i class="bi bi-calendar3"></i> Tanggal Pengaduan
                        </label>
                        <input type="date" class="form-control" id="tgl_pengaduan" name="tgl_pengaduan" required>
                    </div>

                    <!-- 🔹 Tambahan: Dropdown Tingkat Laporan -->
                    <div class="form-item">
                        <label for="tingkat" class="form-label">
                            <i class="bi bi-exclamation-triangle"></i> Tingkat Laporan
                        </label>
                        <select name="tingkat" id="tingkat" class="form-select" required>
                            <option value="info" selected>🟢 Info</option>
                            <option value="warning">🟠 Warning</option>
                            <option value="urgent">🔴 Urgent</option>
                        </select>
                    </div>
                    <!-- 🔹 End Tambahan -->

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
