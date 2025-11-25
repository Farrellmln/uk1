<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

?>


<div class="container" style="background-color: #f0f0f0; padding: 20px; border-radius: 8px;">
    <div class="page-inner">
        <h1 class="mt-4">Kontak</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="../dashboard/index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Detail Kontak</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">
                <i class="fas fa-plus me-1"></i>
                Form Detail Kontak
            </div>
            <div class="card-body">
                <?php
                    include '../../actions/contact/show.php';
                ?>
                <form>
                    <div class="mb-3">
                        <label for="nameinput" class="form-label">Nama</label>
                        <input type="text" class="form-control" value="<?= $contact->name?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="emailinput" class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?= $contact->email?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="subjectinput" class="form-label">Subjek</label>
                        <input type="subject" class="form-control" value="<?= $contact->subject?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="telephoneinput" class="form-label">Telephone</label>
                        <input type="number" class="form-control" value="<?= $contact->telephone?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="messageinput" class="form-label">Pesan</label>
                        <textarea class="form-control" rows="3" disabled><?= $contact->message?></textarea>
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