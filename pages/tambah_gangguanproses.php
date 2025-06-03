<?php
include '../koneksi/koneksi.php';

$id_device = $_POST['device'];
$keterangan = $_POST['keterangan'];

// $status = $_POST['status'];

if (isset($_POST['tambah'])) {

    $query = "SELECT * FROM device WHERE id = $id_device";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $device = $row['device'];

    // tiket
    $tiket = substr(strtoupper(uniqid()), 0, 5);
    
    // $query = $conn->query("INSERT INTO list_gangguan (id_device, keterangan, status, tanggal_gangguan) VALUES ($id_device, '$keterangan', '$status', NOW())");
    $query = $conn->query("INSERT INTO list_gangguan (id_device, keterangan, tanggal_gangguan,tiket) VALUES ($id_device, '$keterangan', NOW(),'$tiket')");

    if ($query) {
        header("location: ../list_gangguan.php");
    } else {
        echo "gagal menambah data";
    }
}

// Tutup koneksi database
mysqli_close($conn);
?>
