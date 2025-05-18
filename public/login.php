<?php
session_start();
$conn = new mysqli("localhost", "root", "", "lipmatchers");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$login_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password_input = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password_hash);
        $stmt->fetch();

        if (password_verify($password_input, $password_hash)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $login_error = "Password salah.";
        }
    } else {
        $login_error = "Username tidak ditemukan.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Halaman Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: Poppins, sans-serif;
      background-color: #f0f0f0;
      margin: 0;
    }
    .login-container {
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
    .login-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
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
    .error-msg {
      color: red;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="container-fluid login-wrapper">
    <div class="login-container">
      <h2>Login</h2>

      <?php if ($login_error): ?>
        <div class="error-msg"><?= $login_error ?></div>
      <?php endif; ?>

      <form method="POST" action="login.php">
        <div class="input-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required />
        </div>
        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required />
        </div>
        <div class="button-group">
          <button type="submit">Masuk</button>
        </div>
      </form>

      <p>Belum punya akun? <a href="registrasi.php">Registrasi di sini</a></p>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
