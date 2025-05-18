<?php
$conn = new mysqli("localhost", "root", "", "lipmatchers");

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Cek password cocok
    if ($password !== $confirmPassword) {
        $error_message = "Password dan konfirmasi password tidak cocok.";
    } else {
        // Cek apakah username sudah terdaftar
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error_message = "Username sudah digunakan. Silakan pilih yang lain.";
        } else {
            // Simpan user baru
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password_hash);

            if ($stmt->execute()) {
                $success_message = "Registrasi berhasil! Silakan login.";
                header("refresh:2;url=login.php");
            } else {
                $error_message = "Terjadi kesalahan saat registrasi.";
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Halaman Registrasi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: Poppins, sans-serif;
      background-color: #f0f0f0;
      margin: 0;
    }
    .register-container {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #163454;
    }
    .input-group {
      margin-bottom: 15px;
    }
    .input-group label {
      display: block;
      font-size: 14px;
      margin-bottom: 5px;
    }
    .input-group input {
      width: 100%;
      padding: 10px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .button-group {
      text-align: center;
    }
    .button-group button {
      width: 100%;
      padding: 10px;
      font-size: 14px;
      background-color: #163454;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .button-group button:hover {
      background-color: #1f496d;
    }
    .register-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .message {
      text-align: center;
      margin-bottom: 10px;
      font-weight: bold;
    }
    .success {
      color: green;
    }
    .error {
      color: red;
    }
    p {
      text-align: center;
      margin-top: 10px;
    }
    p a {
      color: #163454;
      text-decoration: none;
    }
    p a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container-fluid register-wrapper">
    <div class="register-container">
      <h2>Registrasi</h2>

      <?php if ($error_message): ?>
        <div class="message error"><?= $error_message ?></div>
      <?php endif; ?>
      <?php if ($success_message): ?>
        <div class="message success"><?= $success_message ?></div>
      <?php endif; ?>

      <form method="POST" action="registrasi.php">
        <div class="input-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required />
        </div>
        <div class="input-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required />
        </div>
        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required />
        </div>
        <div class="input-group">
          <label for="confirmPassword">Konfirmasi Password</label>
          <input type="password" id="confirmPassword" name="confirmPassword" required />
        </div>
        <div class="button-group">
          <button type="submit">Registrasi</button>
        </div>
      </form>

      <p>Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
