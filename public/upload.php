<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $image = $_FILES['image'];

    if ($image['error'] === 0) {
        $targetDir = "uploads/";
        $fileName = uniqid() . "_" . basename($image["name"]);
        $targetFilePath = $targetDir . $fileName;

        // Buat folder uploads jika belum ada
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Pindahkan file ke folder uploads
        if (move_uploaded_file($image["tmp_name"], $targetFilePath)) {
            // Simpan path ke database
            $stmt = $pdo->prepare("INSERT INTO images (user_id, image_path) VALUES (?, ?)");
            $stmt->execute([$user_id, $targetFilePath]);

            echo "Gambar berhasil diupload dan disimpan!";
        } else {
            echo "Gagal mengupload gambar.";
        }
    } else {
        echo "Terjadi error saat mengupload file.";
    }
}
?>
