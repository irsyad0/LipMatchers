const video = document.getElementById("video");
const canvas = document.getElementById("canvas");
const snapBtn = document.getElementById("snap");
const photo = document.getElementById("photo");
const context = canvas.getContext("2d");
const saveBtn = document.getElementById("save");

// Akses kamera
navigator.mediaDevices.getUserMedia({ video: true })
  .then((stream) => {
    video.srcObject = stream;
  })
  .catch((err) => {
    console.error("Gagal akses kamera:", err);
  });

// Ambil gambar
snapBtn.addEventListener("click", () => {
  context.drawImage(video, 0, 0, canvas.width, canvas.height);
  const imageData = canvas.toDataURL("image/png");
  photo.src = imageData;
});

saveBtn.addEventListener("click", () => {
  const imageData = canvas.toDataURL("image/png");
  if (imageData) {
    document.getElementById("image_data").value = imageData;
    document.getElementById("uploadForm").submit(); // kirim ke PHP
  } else {
    alert("Silakan ambil gambar terlebih dahulu.");
  }
});
