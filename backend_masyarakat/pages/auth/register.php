<?php
session_start();

if (isset($_SESSION['nik'])) {
    echo "
      <script>
        alert('Anda harus logout dahulu');
        window.location.href = '../dashboard/index.php';
      </script>
    ";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registrasi Akun | Pengaduan Masyarakat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="icon" href="../../../storages/profile/frl.jpg" type="image/x-icon" />

    <style>
        :root {
            --main-blue: #005b8f;
            --light-blue: #eaf3f9;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--light-blue) 0%, #cde8f5 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .login-box {
            background-color: #fff;
            border-radius: 16px;
            padding: 32px 28px 35px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-top: 6px solid var(--main-blue);
        }

        h1 {
            margin-top: 0; /* rapetin jarak ke atas */
            margin-bottom: 4px; /* jarak kecil ke bawah */
            font-weight: 600;
            color: var(--main-blue);
        }

        p {
            margin-top: 0;
            margin-bottom: 20px;
            color: #555;
            font-size: 14px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 16px;
        }

        label {
            font-weight: 600;
            font-size: 14px;
            display: block;
            margin-bottom: 6px;
            color: var(--main-blue);
        }

        input[type='text'],
        input[type='email'],
        input[type='password'] {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type='text']:focus,
        input[type='email']:focus,
        input[type='password']:focus {
            outline: none;
            border-color: var(--main-blue);
            box-shadow: 0 0 6px rgba(0, 91, 143, 0.3);
        }

        .sign-in-button {
            width: 100%;
            padding: 13px 0;
            border: none;
            background: var(--main-blue);
            color: white;
            font-weight: 600;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
            margin-top: 8px;
        }

        .sign-in-button:hover {
            background: #004b7a;
            transform: translateY(-2px);
        }

        .new-user {
            margin-top: 16px; /* dikurangin sedikit dari 20px */
            font-size: 14px;
            color: #333;
        }

        .new-user a {
            color: var(--main-blue);
            text-decoration: none;
            font-weight: 600;
        }

        .new-user a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <h1>Registrasi</h1>
            <p>Silakan buat akun baru Anda</p>

            <form action="../../actions/auth/register_action.php" method="POST">
                <div class="form-group">
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" name="nik" placeholder="Masukkan NIK Anda (Max 16 karakter)" maxlength="16" required />
                </div>

                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama Anda" maxlength="35" required />
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Buat username" maxlength="25" required />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" maxlength="32" required />
                </div>

                <div class="form-group">
                    <label for="telp">Nomor Telepon</label>
                    <input type="text" id="telp" name="telp" placeholder="Masukkan nomor telepon" maxlength="13" required />
                </div>

                <button type="submit" class="sign-in-button">Daftar</button>
            </form>

            <div class="new-user">
                Sudah punya akun? <a href="login.php">Masuk</a>
            </div>
        </div>
    </div>
</body>

</html>
