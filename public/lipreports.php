<?php
session_start();
$conn = new mysqli("localhost", "root", "", "lipmatchers");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM lip_scans WHERE user_id = $user_id ORDER BY scan_time DESC");

while ($row = $result->fetch_assoc()) {
    echo "<p><strong>{$row['scan_time']}</strong>: {$row['scan_result']}</p>";
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lip Matchers</title>
    <link rel="stylesheet" href="css/style.css" />
    <!-- Boxicons CSS -->
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <style>
      h2 {
        margin: 90px 30px;
      }
    </style>
    <nav>
      <div class="logo">
        <i class="bx bx-menu menu-icon"></i>
        <span class="logo-name">Lip Matchers</span>
      </div>
      <div class="sidebar">
        <div class="logo">
          <i class="bx bx-menu menu-icon"></i>
          <span class="logo-name">Lip Matchers</span>
        </div>
        <div class="sidebar-content">
          <ul class="lists">
            <li class="list">
              <a href="index.php" class="nav-link">
                <i class="bx bx-home-alt icon"></i>
                <span class="link">Dashboard</span>
              </a>
            </li>

            <li class="list" id="tools">
              <a href="tools.php" class="nav-link">
                <i class="bx bx-wrench icon"></i>
                <span class="link">Tools</span>
              </a>
            </li>
          </ul>
          <div class="bottom-content">
            <li class="list">
              <a href="profile.php" class="nav-link">
                <i class="bx bx-user icon"></i>
                <span class="link">Profile</span>
              </a>
            </li>
            <li class="list">
              <a href="settings.php" class="nav-link">
                <i class="bx bx-cog icon"></i>
                <span class="link">Settings</span>
              </a>
            </li>
            <li class="list">
              <a href="login.php" class="nav-link">
                <i class="bx bx-log-out icon"></i>
                <span class="link">Log Out</span>
              </a>
            </li>
          </div>
        </div>
      </div>
    </nav>
    <h2>LIP REPORTS</h2>
    <section class="overlay"></section>
    <script>
      const navBar = document.querySelector("nav"),
        menuBtns = document.querySelectorAll(".menu-icon"),
        overlay = document.querySelector(".overlay"),
        toolsLink = document.getElementById("tools"),
        toolsDropdown = document.getElementById("tools-dropdown");

      menuBtns.forEach((menuBtn) => {
        menuBtn.addEventListener("click", () => {
          navBar.classList.toggle("open");
        });
      });
    </script>
  </body>
</html>
