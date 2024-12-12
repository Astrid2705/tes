<?php
include("koneksi.php");
session_start();

$nim_terpilih = $_SESSION["nim"];
$tahun_terpilih = $_SESSION["tahun"];
$semester_terpilih = $_SESSION["semester"];

$query_tampil_krs = "SELECT * FROM krs WHERE nim = '$nim_terpilih' AND tahun = '$tahun_terpilih' AND semester = '$semester_terpilih'";
$result_tampil_krs = mysqli_query($koneksi, $query_tampil_krs);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat KRS - <?php echo $nim_terpilih; ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Add any additional styling or include necessary CSS/JS files here -->
</head>
<body>
    <div class="container">
        <h2>Tabel KRS yang Sudah Dipilih</h2>
        <?php
        if ($result_tampil_krs && mysqli_num_rows($result_tampil_krs) > 0) {
            ?>
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
                        <th>AKSI</th>
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
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        </div>

    </div>
</div>
        <?php
        } else {
            echo "<p>Belum ada mata kuliah yang dipilih.</p>";
        }
        ?>
    </div>
</body>
</html>
