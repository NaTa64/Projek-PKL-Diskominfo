<?php
session_start();
include "../koneksi/koneksi.php";

$sesi_akun = $_SESSION['account_type'];

$id = $_POST['id'];
$keterangan = $_POST['keterangan'];
$status = $_POST['status'];

if (isset($_POST['simpan'])) {
    $query_update = "UPDATE list_gangguan set keterangan='$keterangan', status='$status' WHERE id=$id";
    $update = $conn->query($query_update);

    if ($update) {
        if ($sesi_akun == 'admin') {
            header("location: ../list_gangguan.php");
        }elseif ($sesi_akun == 'teknisi') {
            header("location: ../status_gangguan.php");
        }
    } else {
        echo "gagal mengubah data";
    }
}
