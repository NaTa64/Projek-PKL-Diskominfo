<?php
include "../koneksi/koneksi.php";

$id_lap = $_POST['id_laporan'];
$device = $_POST['device'];
$keterangan = $_POST['keterangan'];
$status = $_POST['status'];

if (isset($_POST['simpan'])) {
    if ($status == 'aktif') {
        $query_update = "UPDATE lapor_gangguan set device='$device', keterangan='$keterangan', status='$status', tanggal_selesai=NOW() where id_laporan=$id_lap";
    } else {
        $query_update = "UPDATE lapor_gangguan set device='$device', keterangan='$keterangan', status='$status', tanggal_selesai=NULL where id_laporan=$id_lap";
    }
    $update = $conn->query($query_update);

    if ($update) {
        header("location: ../status_gangguan_user.php");
    } else {
        echo "gagal mengubah data";
    }
}
