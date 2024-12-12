<?php
// Koneksi ke database
include("koneksi.php");

// Memulai sesi
session_start();

// Cek apakah sudah login
if (!isset($_SESSION["nim"])) {
    header("location: index.php");
    exit();
}

// Ambil data mahasiswa berdasarkan NIM
$nim = $_SESSION["nim"];
$query_mahasiswa = "SELECT * FROM mahasiswa WHERE nim = '$nim'";
$result_mahasiswa = mysqli_query($koneksi, $query_mahasiswa);
$mahasiswa = mysqli_fetch_assoc($result_mahasiswa);

// Ambil data semester aktif
$query_semester_aktif = "SELECT * FROM semester WHERE status = 'Aktif'";
$result_semester_aktif = mysqli_query($koneksi, $query_semester_aktif);
$semester_aktif = mysqli_fetch_assoc($result_semester_aktif);

// Ambil daftar MK yang dapat diambil sesuai semester (contoh hanya untuk semester ganjil)
$query_daftar_mk = "SELECT * FROM mk WHERE semester % 2 = 1";
$result_daftar_mk = mysqli_query($koneksi, $query_daftar_mk);

// krs.php
$_SESSION["nim"] = $nim;
$_SESSION["tahun"] = $semester_aktif["tahun"];
$_SESSION["semester"] = $semester_aktif["semester"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KRS Mahasiswa - <?php echo $mahasiswa["nama"]; ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Tambahkan link ke Bootstrap CSS di sini -->
</head>
<div class="container">
<body>
<h2>KRS Mahasiswa</h2>
<style>
    .box {
        border: 1px solid #ccc; /* Menambahkan border agar terlihat seperti kotak */
        padding: 20px; /* Menambahkan padding untuk memberi ruang di dalam kotak */
        border-radius: 10px; /* Mengatur border-radius agar sudut kotak lebih membulat */
        max-width: 400px; /* Menentukan lebar maksimum kotak */
        margin-left: 3px; /* Menyertakan margin sebelah kiri */
    }
    h1 {
        text-align: center;
    }
    p {
        margin: 10px 0; /* Menambahkan margin atas dan bawah untuk setiap paragraf */
    }
</style>
    <div class="box">
        <p>NIM: <?php echo $mahasiswa["nim"]; ?></p>
        <p>NAMA: <?php echo $mahasiswa["nama"]; ?> </p>
        <p>TAHUN: <?php echo $semester_aktif["tahun"]; ?></p>
        <p>SEMESTER: <?php echo $semester_aktif["semester"]; ?></p>
    </div>

        <h3>Daftar MK yang dapat diambil</h3>
        <form method="post" action="proses_krs.php">
            <input type="hidden" name="nim_terpilih" value="<?php echo $nim; ?>">
            <input type="hidden" name="tahun_terpilih" value="<?php echo $semester_aktif["tahun"]; ?>">
            <input type="hidden" name="semester_terpilih" value="<?php echo $semester_aktif["semester"]; ?>">
    <!-- Tampilkan daftar MK sebagai tabel -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Kode MK</th>
                <th>Nama MK</th>
                <th>Semester</th>
                <th>SKS</th>
                <th>Pilih</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row_daftar_mk = mysqli_fetch_assoc($result_daftar_mk)) { ?>
                <tr>
                    <td><?php echo $row_daftar_mk["kode_mk"]; ?></td>
                    <td><?php echo $row_daftar_mk["nama_mk"]; ?></td>
                    <td><?php echo $row_daftar_mk["semester"]; ?></td>
                    <td><?php echo $row_daftar_mk["sks"]; ?></td>
                    <td>
                        <input type="checkbox" name="mk[]" value="<?php echo $row_daftar_mk["kode_mk"]; ?>">
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
        </div>

    </div>
</div>
<style>
    .custom-form {
        max-width: 200px; /* Ganti sesuai kebutuhan lebar maksimum yang diinginkan */
        margin-left: 50px; /* Menyertakan margin sebelah kiri */ /* Untuk memusatkan kotak select di tengah halaman */
    }

    .form-label {
        width: 100%; /* Membuat label memanjang sesuai lebar parent (max-width) */
        box-sizing: border-box; /* Memastikan lebar termasuk padding dan border */
    }

    .form-select {
        width: 100%; /* Membuat select memanjang sesuai lebar parent (max-width) */
    }
</style>
<div class="custom-form">
    <label class="form-label" for="kelas">Pilih Kelas (A/B):</label>
            <select class="form-select" name="kelas" required>
                <option value="A">A</option>
                <option value="B">B</option>
            </select>
</div>
<style>
    .custom-button {
        margin-left: 50px; /* Menyertakan margin sebelah kiri */
        margin-top: 10px;  /* Menyertakan margin di atas */
        margin-bottom: 10px; /* Menyertakan margin di bawah */
        background-color: #4CAF50; /* Warna hijau */
        color: white; /* Warna teks putih */
        padding: 10px 20px; /* Padding pada tombol */
        border: none; /* Menghilangkan border */
        border-radius: 5px; /* Mengatur border-radius agar tombol terlihat lebih membulat */
        cursor: pointer; /
    }
</style>
<div class="col-md-8">
    <button class="custom-button" type="submit" name="simpan" value="simpan">Simpan</button>
    <a href="lihat_krs.php" class="custom-button">Lihat KRS</a>
</div>
</form>