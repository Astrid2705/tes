<?php
include("koneksi.php");
session_start();

$nim_terpilih = $_SESSION["nim"];
$tahun_terpilih = $_SESSION["tahun"];
$semester_terpilih = $_SESSION["semester"];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete_course"])) {
    $kode_mk_to_delete = $_GET["delete_course"];

    // Process deletion of the specified course from KRS
    $query_hapus_mk_krs = "DELETE FROM krs WHERE nim = '$nim_terpilih' AND tahun = '$tahun_terpilih' AND semester = '$semester_terpilih' AND kode_mk = '$kode_mk_to_delete'";
    mysqli_query($koneksi, $query_hapus_mk_krs);

    // Redirect back to lihat_krs.php after deletion
    header("Location: lihat_krs.php");
    exit();
}
?>
