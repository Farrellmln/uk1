<?php
  include '../../app.php';
    session_start();

if (!isset($_SESSION['username'])) {
    echo "
            <script>
                alert('anda harus login dahulu');
                window.location.href = '../../../backend_masyarakat/pages/auth/login.php';
            </script>
        "; 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Admin Personal Profile</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="icon" href="../../../storages/header/pelaporan.png" type="image/x-icon" />

  <!-- Fonts and icons -->
  <script src="../../template-admin/assets/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: {
        families: ["Public Sans:300,400,500,600,700"]
      },
      custom: {
        families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
        urls: ["../../template-admin/assets/css/fonts.min.css"],
      },
      active: function() {
        sessionStorage.fonts = true;
      },
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="../../template-admin/assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../template-admin/assets/css/plugins.min.css" />
  <link rel="stylesheet" href="../../template-admin/assets/css/kaiadmin.min.css" />
  <link rel="stylesheet" href="../../template-admin/assets/css/your-style-file.css" />

  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link rel="stylesheet" href="../../template-admin/assets/css/demo.css" />
</head>