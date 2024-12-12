<?php
// Koneksi ke database
include("koneksi.php");

// Memulai sesi
session_start();

// Cek apakah form login sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST["nim"];
    $password = $_POST["password"];

    // Query untuk memeriksa data mahasiswa yang aktif
    $query = "SELECT * FROM mahasiswa WHERE nim = '$nim' AND password = '$password' AND status = 'Aktif'";
    $result = mysqli_query($koneksi, $query);

    // Jika data ditemukan, arahkan ke halaman KRS
    if (mysqli_num_rows($result) == 1) {
        $_SESSION["nim"] = $nim;
        header("location: krs.php");
        exit(); // Pastikan untuk keluar dari skrip setelah melakukan redirect
    } else {
        $error = "NIM atau Password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Mahasiswa</title>
  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .login-container {
      margin-top: 100px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 login-container">
        <div class="card">
          <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Login Mahasiswa</h4>
          </div>
          <div class="card-body">
            <form id="loginForm" action="index.php" method="POST">
              <div class="form-group">
                <label for="nim">NIM:</label>
                <input type="text" class="form-control" id="nim" name="nim" required>
              </div>
              <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>