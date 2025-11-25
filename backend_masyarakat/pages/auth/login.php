<?php
session_start();

if (isset($_SESSION['text'])) {
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
    <title>Login | Pengaduan Masyarakat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="icon" href="../../../storages/header/pelaporan.png" type="image/x-icon" />

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

        .icon-wrapper {
            width: 70px;
            height: 70px;
            margin: 0 auto 10px;
            background-color: var(--main-blue);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .icon-wrapper i {
            font-size: 32px;
            color: white;
        }

        h1 {
            margin-top: 0;
            margin-bottom: 4px; /* jarak lebih rapat */
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
        input[type='password'] {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type='text']:focus,
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
            margin-top: 16px; /* dirapetin biar sama kaya register */
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

        /* Tambah sedikit transisi smooth */
        .login-box {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <div class="icon-wrapper">
                <i class="bi bi-megaphone-fill"></i>
            </div>
            <h1>Login</h1>
            <p>Silakan masuk ke akun Anda</p>

            <form action="../../actions/auth/login_action.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username Anda" maxlength="25" required />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" maxlength="32" required />
                </div>

                <button type="submit" class="sign-in-button">Masuk</button>
            </form>

            <div class="new-user">
                Belum punya akun? <a href="register.php">Buat akun</a>
            </div>
        </div>
    </div>
</body>

</html>
