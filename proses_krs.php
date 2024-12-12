<?php
include("koneksi.php");
session_start();

$nim_terpilih = $_POST["nim_terpilih"];
$tahun_terpilih = $_POST["tahun_terpilih"];
$semester_terpilih = $_POST["semester_terpilih"];

// Periksa metode permintaan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["simpan"])) {
        // Ambil data dari form
        $mk_terpilih = $_POST["mk"];
        $kelas_terpilih = (array)$_POST["kelas"]; // Ensure $kelas_terpilih is an array

        // Iterate over selected courses and check if they are already in KRS
        foreach ($mk_terpilih as $index => $kode_mk) {
            $query_check_course = "SELECT * FROM krs 
                                   WHERE nim = '$nim_terpilih' 
                                   AND tahun = '$tahun_terpilih' 
                                   AND semester = '$semester_terpilih' 
                                   AND kode_mk = '$kode_mk'";

            $result_check_course = mysqli_query($koneksi, $query_check_course);

            if ($result_check_course && mysqli_num_rows($result_check_course) > 0) {
                // Course already taken, show an error message
                echo '<div class="alert alert-danger" role="alert">Mata kuliah dengan kode ' . $kode_mk . ' sudah diambil sebelumnya.</div>';
                
                // Redirect back to KRS page after displaying the error message
                header("Refresh: 3; URL=krs.php"); // Change "krs.php" to the actual filename of your KRS page
                exit;
            } else {
                // Course not taken, insert it into the KRS table
                $query_insert_krs = "INSERT INTO krs (nim, kode_mk, tahun, semester, kelas) 
                                     VALUES ('$nim_terpilih', '$kode_mk', '$tahun_terpilih', '$semester_terpilih', '$kelas_terpilih[$index]')";
                mysqli_query($koneksi, $query_insert_krs);
            }
        }

        // Now, display the selected courses
        $query_tampil_krs = "SELECT * FROM krs WHERE nim = '$nim_terpilih' AND tahun = '$tahun_terpilih' AND semester = '$semester_terpilih'";
        $result_tampil_krs = mysqli_query($koneksi, $query_tampil_krs);

        if ($result_tampil_krs && mysqli_num_rows($result_tampil_krs) > 0) {
            // Display the table
            echo '<div class="alert alert-success" role="alert">Data berhasil disimpan!</div>';
            echo '<h2>Tabel KRS yang Sudah Dipilih:</h2>';
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>View KRS - <?php echo $nim_terpilih; ?></title>
                <link rel="stylesheet" href="css/bootstrap.min.css">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
            </head>
            <body>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Kode MK</th>
                                    <th>TAHUN</th>
                                    <th>SEMESTER</th>
                                    <th>Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row_krs = mysqli_fetch_assoc($result_tampil_krs)) { ?>
                                    <tr>
                                        <td><?php echo $row_krs["nim"]; ?></td>
                                        <td><?php echo $row_krs["kode_mk"]; ?></td>
                                        <td><?php echo $row_krs["tahun"]; ?></td>
                                        <td><?php echo $row_krs["semester"]; ?></td>
                                        <td><?php echo $row_krs["kelas"]; ?></td>
                                        <td>
                                            <a class='btn btn-danger btn-sm' href='hapus_krs.php?delete_course=<?php echo $row_krs["kode_mk"]; ?>' onclick="return confirm('Hapus MK ini dari KRS?')">
                                                <i class='bi-trash'></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php
        } else {
            echo "<p>Belum ada mata kuliah yang dipilih.</p>";
        }
    }
}
?>
</body>
</html>
