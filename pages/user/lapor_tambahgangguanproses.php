<?php
session_start();

include '../../koneksi/koneksi.php';

$id_user = $_SESSION['id'];

$device = $_POST['device'];
$keterangan = $_POST['keterangan'];
$upload = $_FILES['upload'];

if (isset($_POST['tambah'])) {

    if ($upload['error'] == 0) {
        //Simpan file ke direktory
        $nama_file = $upload['name'];
        $tmp_name = $upload['tmp_name'];
        $path = 'bukti_device/';
        move_uploaded_file($tmp_name, $path . $nama_file);

        // Insert data ke database
        $query = "INSERT INTO lapor_gangguan (id_user, device, keterangan, tanggal_gangguan, image) VALUES ($id_user,'$device', '$keterangan', NOW(), '$nama_file')";
        $result = $conn->query($query);

        if ($result) {
            header("location: lapor.php");
        } else {
            echo "gagal menambah data";
        }
    } else {
        echo "gagal upload file";
    }
}

// Tutup koneksi database
mysqli_close($conn);
?>