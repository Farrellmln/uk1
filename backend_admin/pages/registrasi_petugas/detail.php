<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
include '../../partials/admin_only.php';
?>


<div class="container" style="background-color: #f0f0f0; padding: 20px; border-radius: 8px;">
    <div class="page-inner">
        <h1 class="mt-4">Tentang Saya</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="../dashboard/index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Detail Tentang Saya</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">
                <i class="fas fa-plus me-1"></i>
                Form Detail Tentang Saya
            </div>
            <div class="card-body">
                <?php
                    include '../../actions/about/show.php';
                ?>
                <form action="../../actions/about/store.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nameinput" class="form-label">Nama</label>
                        <input type="text" class="form-control" value="<?= $about->name?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="borninput" class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control" value="<?= $about->born?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="zipCodeinput" class="form-label">Kode Pos</label>
                        <input type="number" class="form-control" value="<?= $about->zip_code?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="emailinput" class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?= $about->email?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="phoneinput" class="form-label">Telephone</label>
                        <input type="number" class="form-control" value="<?= $about->phone?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="TotalProjectinput" class="form-label">Total Project</label>
                        <input type="number" class="form-control" value="<?= $about->total_project?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="workinput" class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control" value="<?= $about->work?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="addressinput" class="form-label">Alamat</label>
                        <textarea class="form-control" rows="3" disabled><?= $about->address?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="gambarinput" class="form-label">Gambar</label>
                        <br>
                        <img src="../../../storages/about/<?= $about->image?>" alt="image" width="100" height="100">
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="index.php" class="btn btn-secondary me-2">Kembali</a>
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