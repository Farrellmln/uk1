<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
include '../../app.php';

$id_pengaduan = $_GET['id'] ?? null;
if (!$id_pengaduan) {
    echo "<script>alert('ID Pengaduan tidak ditemukan!'); window.location.href='index.php';</script>";
    exit;
}
?>

<style>
    .content-wrapper {
        background-color: #f8fafc;
        padding: 90px 70px 50px 70px;
        min-height: 100vh;
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
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .card-header-custom {
        background-color: #004c84;
        color: #fff;
        font-weight: 600;
        font-size: 1.1rem;
        padding: 18px 24px;
        border-bottom: none;
    }

    .form-label {
        font-weight: 500;
        color: #1b3c74;
    }

    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 14px;
        border: 1px solid #d0d7de;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
    }

    .btn-primary-custom {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-primary-custom:hover {
        background-color: #0056b3;
    }

    .btn-back {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-back:hover {
        background-color: #5a6268;
    }
</style>

<div class="content-wrapper">
    <div class="page-title">Beri Tanggapan</div>
    <div class="breadcrumb">Dashboard / Laporan / Beri Tanggapan</div>

    <div class="card card-custom">
        <div class="card-header-custom">
            Formulir Tanggapan
        </div>
        <div class="card-body p-4">
            <form action="../../actions/tanggapan/beri_tanggapan_action.php" method="POST" class="row g-3">
                <input type="hidden" name="id_pengaduan" value="<?= $id_pengaduan ?>">

                <div class="col-md-6">
                    <label for="tgl_tanggapan" class="form-label">Tanggal Tanggapan</label>
                    <input type="date" name="tgl_tanggapan" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="col-12">
                    <label for="tanggapan" class="form-label">Isi Tanggapan</label>
                    <textarea name="tanggapan" id="tanggapan" class="form-control" rows="6" placeholder="Tuliskan tanggapan..." required></textarea>
                </div>

                <div class="col-12 text-end mt-4">
                    <a href="index.php" class="btn-back me-2">Kembali</a>
                    <button type="submit" class="btn-primary-custom">Kirim Tanggapan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../../partials/script.php'; ?>
<?php include '../../partials/footer.php'; ?>
