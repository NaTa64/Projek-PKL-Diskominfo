<?php include "../koneksi/koneksi.php";

$id_laporan = $_GET['id'];

$query_hapus = "UPDATE lapor_gangguan set aktif=0 WHERE id_laporan=$id_laporan";
$hapus = $conn->query($query_hapus);

if ($hapus) {
    header("location: ../status_gangguan_user.php");
} else {
    echo "gagal menghapus data";
}
?>