<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'] ?? 'Pengguna';
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Lip Matchers</title>
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap" rel="stylesheet" />
  </head>
  <body>
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
            <li class="list">
              <a href="#guide" class="nav-link">
                <i class="bx bx-book-open icon"></i>
                <span class="link">Panduan</span>
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
              <a href="logout.php" class="nav-link">
                <i class="bx bx-log-out icon"></i>
                <span class="link">Log Out</span>
              </a>
            </li>
          </div>
        </div>
      </div>
    </nav>

    <section class="landing-page">
      <div class="border"></div>
      <h2>Selamat datang, <?= htmlspecialchars($username) ?>!</h2>
    </section>

    <section class="dashboard-info">
      <div class="dashboard-content">
        <h2>Apa Itu <span>Lip Matchers?</span></h2>
        <p>
          Lip Matchers adalah sistem identifikasi biometrik yang menggunakan pola unik pada sidik bibir seseorang untuk melakukan verifikasi identitas. Dengan bantuan kecerdasan buatan dan pengolahan citra digital, sistem ini mampu mengenali individu berdasarkan fitur unik pada bibir mereka.
        </p>
      </div>
    </section>

    <section class="use-cases">
      <h2>Aplikasi Teknologi Ini</h2>
      <div class="use-case-container">
        <div class="use-case-box">
          <i class="bx bx-plus-medical icon"></i>
          <h3>Medis & Forensik</h3>
          <p>Membantu identifikasi pasien atau korban dalam investigasi forensik.</p>
        </div>
        <div class="use-case-box">
          <i class="bx bx-shield icon"></i>
          <h3>Keamanan & Akses</h3>
          <p>Verifikasi identitas di bandara, kantor, atau akses VIP.</p>
        </div>
        <div class="use-case-box">
          <i class="bx bx-id-card icon"></i>
          <h3>HR & Absensi</h3>
          <p>Sistem absensi biometrik yang tidak bisa dipalsukan.</p>
        </div>
        <div class="use-case-box">
          <i class="bx bx-mobile icon"></i>
          <h3>Keamanan Digital</h3>
          <p>Autentikasi pengguna dalam aplikasi dan perangkat digital.</p>
        </div>
      </div>
    </section>

    <section id="guide" class="guide">
      <h2>Panduan Penggunaan</h2>
      <div class="content-guide">
        <div class="box-guide">
          <i class="bx bxs-image icon"></i>
          <h3 class="guide-title">Unggah Gambar</h3>
          <p class="guide-description">
            Pada menu Tools, pilih Lip Matchers. Kemudian ambil atau unggah foto sidik bibir dengan resolusi kamera minimal 12MP. Pastikan kualitas cahaya dalam keadaan baik saat dilakukan pengambilan gambar.
          </p>
        </div>
        <div class="box-guide">
          <i class="bx bx-desktop icon"></i>
          <h3 class="guide-title">Proses AI</h3>
          <p class="guide-description">
            Sistem akan menganalisis pola unik sidik bibir yang telah Anda kirimkan, meneliti dan mengklasifikasikan gambar ke dalam tipe yang sesuai.
          </p>
        </div>
        <div class="box-guide">
          <i class="bx bxs-user-check icon"></i>
          <h3 class="guide-title">Hasil & Laporan</h3>
          <p class="guide-description">
            Hasil identifikasi Anda akan tersedia melalui menu Lip Reports di bagian Tools.
          </p>
        </div>
      </div>
    </section>

    <section class="overlay"></section>

    <script>
      const navBar = document.querySelector("nav"),
        menuBtns = document.querySelectorAll(".menu-icon"),
        overlay = document.querySelector(".overlay");

      menuBtns.forEach((menuBtn) => {
        menuBtn.addEventListener("click", () => {
          navBar.classList.toggle("open");
        });
      });
    </script>
  </body>
</html>
