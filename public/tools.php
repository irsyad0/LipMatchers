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
      h1 {
        font-size: 50px;
        margin: 100px 20px 20px 20px;
      }

      .tools-container {
        margin: 1px 1px 100px 1px;
        display: flex;
        flex-wrap: wrap;
        color: rgb(0, 0, 0);
        justify-content: center;
        gap: 20px;
      }

      .tools-box {
        background: #f2f2f2;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 250px;
        text-align: left;
        padding: 10px;
        margin: 2px;
      }
      h3 {
        font-size: 25px;
        width: 100%;
      }

      p {
        font-size: 12px;
        margin: 15px 5px 15px 5px;
        width: 100%;
        text-align: left;
      }

      button a {
        background-color: #163454;
        color: #efefef;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 10px;
      }

      button a:hover {
        background-color: #244f7d;
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

    <section class="tools-page">
      <h1>Tools</h1>
      <div class="tools-container">
        <div class="tools-box">
          <h3>Lip Scan</h3>
          <p>
            Lipscan adalah teknologi untuk identifikasi individu melalui sidik
            bibir dengan menggunakan deep learning, khususnya Convolutional
            Neural Networks (CNN), untuk menganalisis pola unik pada bibir.
          </p>
          <button>
            <a href="lipscan.php">Mulai</a>
          </button>
        </div>
        <div class="tools-box">
          <h3>Lip Reports</h3>
          <p>
            Lipscan adalah teknologi untuk identifikasi individu melalui sidik
            bibir dengan menggunakan deep learning, khususnya Convolutional
            Neural Networks (CNN), untuk menganalisis pola unik pada bibir.
          </p>
          <button>
            <a href="lipreports.php">Lihat</a>
          </button>
        </div>
      </div>
    </section>

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
