const express = require("express");
const mysql = require("mysql");
const bodyParser = require("body-parser");
const cors = require("cors");
const path = require("path");

const app = express();
app.use(cors());
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());
app.use(express.static(path.join(__dirname, "public"))); // akses file HTML

// Koneksi ke MySQL
const db = mysql.createConnection({
  host: "localhost",
  user: "root",       // ganti kalau username MySQL kamu beda
  password: "",       // isi password MySQL kamu
  database: "userdb", // pastikan sesuai nama database
});

db.connect((err) => {
  if (err) throw err;
  console.log("Terkoneksi ke database MySQL.");
});

// Route untuk registrasi
app.post("/register", (req, res) => {
  const { username, email, password } = req.body;

  const sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
  db.query(sql, [username, email, password], (err, result) => {
    if (err) {
      console.error("Error insert:", err);
      res.status(500).send("Gagal menyimpan data.");
    } else {
      res.send("Registrasi berhasil!");
    }
  });
});

app.post("/login", (req, res) => {
  const { username, password } = req.body;

  const sql = "SELECT * FROM users WHERE username = ? AND password = ?";
  db.query(sql, [username, password], (err, results) => {
    if (err) {
      console.error("Error saat login:", err);
      res.status(500).send("Terjadi kesalahan server.");
    } else {
      if (results.length > 0) {
        res.send("Login berhasil");
      } else {
        res.status(401).send("Username atau password salah.");
      }
    }
  });
});

app.listen(3000, () => {
  console.log("Server jalan di http://localhost:3000");
});
