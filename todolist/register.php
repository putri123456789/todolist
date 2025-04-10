<?php
include 'koneksi.php'; // Hubungkan ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password_input = $_POST['password'];

    // Validasi panjang password
    if (strlen($password_input) < 8) {
        $error = "Password minimal 8 karakter!";
    } else {
        $password = password_hash($password_input, PASSWORD_DEFAULT);

        // Cek apakah username sudah ada
        $check = $conn->query("SELECT * FROM users WHERE username='$username'");
        if ($check->num_rows > 0) {
            $error = "Username sudah digunakan, silakan pilih username lain!";
        } else {
            $sql = "INSERT INTO users (nama_lengkap, username, password) VALUES ('$nama_lengkap', '$username', '$password')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>
                        sessionStorage.setItem('registerSuccess', 'true');
                        window.location.href = 'login.php';
                      </script>";
                exit();
            } else {
                $error = "Registrasi gagal: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Register</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('wp.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
            margin: 0;
            height: 100vh;
        }
        .register-container {
            background: #FFF8DC;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background: #0056b3;
        }
        p {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Registrasi</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required><br>
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password (min 8 karakter)" required minlength="8"><br>
            <button type="submit">Register</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
