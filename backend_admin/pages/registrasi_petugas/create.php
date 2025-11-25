<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
include '../../partials/admin_only.php';
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
    <div class="page-title">Tambah Petugas</div>
    <div class="breadcrumb">Dashboard / Petugas / Halaman Tambah</div>

    <div class="card card-custom">
        <div class="card-header-custom">
            Form Tambah Petugas
        </div>
        <div class="card-body p-4">
            <form action="../../actions/registrasi_petugas/registrasi_action.php" method="POST" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Petugas</label>
                    <input type="text" name="nama_petugas" class="form-control" placeholder="Masukkan nama petugas..." required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Level</label>
                    <select name="level" class="form-select" required>
                        <option value="">-- Pilih Level --</option>
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username..." required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="telp" class="form-control" placeholder="Masukkan nomor telepon..." required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password..." required>
                </div>

                <div class="col-12 text-end mt-4">
                    <a href="index.php" class="btn-back me-2">Kembali</a>
                    <button type="submit" class="btn-primary-custom">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>
