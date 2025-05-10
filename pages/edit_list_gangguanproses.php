<?php 
include "../koneksi/koneksi.php";

$id = $_POST['id'];
$keterangan = $_POST['keterangan'];
$status = $_POST['status'];

if (isset($_POST['simpan'])) {
    $query_update = "UPDATE list_gangguan set keterangan='$keterangan', status='$status' WHERE id=$id";
    $update = $conn->query($query_update);

    if ($update){
        header("location: ../list_gangguan.php");
    }  else {
        echo "gagal mengubah data";
    }
}
?>