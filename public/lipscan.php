<?php
session_start();
$conn = new mysqli("localhost", "root", "", "lipmatchers");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['image_data'])) {
    $user_id = $_SESSION['user_id'];
    $image_data = $_POST['image_data'];

    // Ambil base64 dari data:image/png;base64,...
    $image_parts = explode(";base64,", $image_data);
    if (count($image_parts) == 2) {
        $base64_data = base64_decode($image_parts[1]);

        // Simpan ke folder uploads/
        $file_name = uniqid() . '.png';
        $file_path = 'uploads/' . $file_name;
        file_put_contents($file_path, $base64_data);

        // Simpan path ke database
        $stmt = $conn->prepare("INSERT INTO lip_scans (user_id, scan_result) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $file_path);
        $stmt->execute();

        echo "success";
        exit();
    } else {
        echo "invalid_format";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lip Matchers</title>
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap" rel="stylesheet" />
    <style>
      h2 { margin: 90px 30px; }
      .camera-container { text-align: center; margin-top: 20px; }
      #video, #canvas, #photo { border: 1px solid #ccc; margin-top: 10px; }
      .controls { margin-top: 10px; text-align: center; }
      .controls button, .controls input { margin: 5px; padding: 8px 12px; font-size: 16px; }

      .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #e6ffed;
        color: #2e7d32;
        border: 3px solid #a5d6a7;
        padding: 50px 60px;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        z-index: 1000;
        animation: fadeInOut 3s ease-in-out forwards;
        font-size: 28px;
        text-align: center;
      }

      .popup-content {
        display: flex;
        align-items: center;
        gap: 25px;
        justify-content: center;
      }

      .checkmark {
        font-size: 50px;
        background-color: #4caf50;
        color: white;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      @keyframes fadeInOut {
        0% { opacity: 0; transform: translate(-50%, -60%); }
        10% { opacity: 1; transform: translate(-50%, -50%); }
        90% { opacity: 1; }
        100% { opacity: 0; transform: translate(-50%, -60%); }
      }
    </style>
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
            <li class="list"><a href="index.php" class="nav-link"><i class="bx bx-home-alt icon"></i><span class="link">Dashboard</span></a></li>
            <li class="list" id="tools"><a href="tools.php" class="nav-link"><i class="bx bx-wrench icon"></i><span class="link">Tools</span></a></li>
          </ul>
          <div class="bottom-content">
            <li class="list"><a href="profile.php" class="nav-link"><i class="bx bx-user icon"></i><span class="link">Profile</span></a></li>
            <li class="list"><a href="settings.php" class="nav-link"><i class="bx bx-cog icon"></i><span class="link">Settings</span></a></li>
            <li class="list"><a href="login.php" class="nav-link"><i class="bx bx-log-out icon"></i><span class="link">Log Out</span></a></li>
          </div>
        </div>
      </div>
    </nav>

    <h2>LIP SCAN</h2>
    <div class="camera-container">
      <video id="video" width="320" height="240" autoplay playsinline></video><br />
      <button id="snap">Ambil Gambar</button><br />
      <canvas id="canvas" width="320" height="240" style="display: none;"></canvas><br />
      <img id="photo" alt="Hasil Gambar Akan Muncul Di Sini" />
    </div>

    <div class="controls">
      <br />
      <label for="file-input">Unggah File:</label>
      <input type="file" id="file-input" accept="image/*" /><br />
      <button id="save">Simpan ke Lip Reports</button>
    </div>

    <!-- Form tersembunyi -->
    <form id="uploadForm" method="POST" style="display: none;">
      <input type="hidden" name="image_data" id="image_data" />
    </form>

    <!-- Popup Notifikasi -->
    <div id="notification" class="popup">
      <div class="popup-content">
        <span class="checkmark">&#10004;</span>
        <p>Berhasil diupload</p>
      </div>
    </div>

    <script>
      const video = document.getElementById("video");
      const canvas = document.getElementById("canvas");
      const snapBtn = document.getElementById("snap");
      const photo = document.getElementById("photo");
      const context = canvas.getContext("2d");
      const saveBtn = document.getElementById("save");
      const fileInput = document.getElementById("file-input");

      // Akses kamera
      navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => { video.srcObject = stream; })
        .catch(err => { console.error("Gagal mengakses kamera:", err); });

      // Ambil gambar dari video
      snapBtn.addEventListener("click", () => {
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = canvas.toDataURL("image/png");
        photo.src = imageData;
      });

      // Simpan gambar ke server via AJAX
      saveBtn.addEventListener("click", () => {
        const imageData = canvas.toDataURL("image/png");
        if (imageData) {
          document.getElementById("image_data").value = imageData;
          fetch("lipscan.php", {
            method: "POST",
            body: new FormData(document.getElementById("uploadForm"))
          })
            .then(response => response.text())
            .then(data => {
              if (data.trim() === "success") {
                showNotification();
              } else {
                alert("Gagal menyimpan gambar: " + data);
              }
            })
            .catch(err => {
              alert("Error saat menyimpan gambar.");
              console.error(err);
            });
        } else {
          alert("Silakan ambil gambar terlebih dahulu.");
        }
      });

      // Tampilkan gambar hasil unggahan
      fileInput.addEventListener("change", (event) => {
        const file = event.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function (e) {
            photo.src = e.target.result;
          };
          reader.readAsDataURL(file);
        }
      });

      function showNotification() {
        const notif = document.getElementById("notification");
        notif.style.display = "block";
        setTimeout(() => {
          notif.style.display = "none";
        }, 3000);
      }

      fileInput.addEventListener("change", (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      // Tampilkan gambar
      photo.src = e.target.result;

      // Ambil base64 string
      const base64String = e.target.result.split(",")[1];

      // Set ke input hidden
      document.getElementById("image_data").value = base64String;
    };
    reader.readAsDataURL(file);
  }
});

      
    </script>
  </body>
</html>
