<?php 
include '../koneksi/koneksi.php';

$device = $_POST['device'];
$tipe   = $_POST['tipe'];

if (isset($_POST['tambah'])) {

    $query = "INSERT into device (device, type) VALUES ('$device', '$tipe')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("location: ../device.php");
    } else {
        echo "gagal menambah data";
    }
}

mysqli_close($conn);
?>