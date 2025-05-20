<?php
session_start();

require("../../koneksi/koneksi.php");

if (!isset($_SESSION['id']) || (isset($_SESSION['id']) && $_SESSION['account_type'] != 'user')) {
    session_destroy(); // hapus session
    header('Location: ../../logout.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="./image aset/images-removebg-preview.png">
    <title>Lapor</title>
    <style>
        /* Style the sidebar */
        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background: linear-gradient(to right, #007bff, #5c9fff);
            /* Gradasi biru lebih soft */
            display: flex;
            flex-direction: column;
            padding-top: 70px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            /* Bayangan lembut di samping */
        }

        .sidebar a {
            padding: 12px 8px 12px 32px;
            text-decoration: none;
            font-size: 16px;
            color: white;
            display: block;
            margin-bottom: 12px;
            border-radius: 4px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        /* Efek hover untuk link di sidebar */
        .sidebar a:hover {
            background-color: #f1f1f1;
            /* Warna latar belakang saat hover */
            color: #007bff;
            /* Mengubah warna teks menjadi biru */
            transform: translateX(10px);
            /* Efek geser ke kanan */
        }

        /* Style the content */
        .content {
            margin-left: 200px;
            padding: 20px;
            padding-top: 30px;

        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="lapor.php"><i class="fas fa-clipboard"></i> Lapor Gangguan</a>
        <a href="status.php"><i class="fas fa-clipboard"></i> Status</a>
        <div style="flex-grow: 1;"></div>
        <a href="../../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    <!-- Sidebar -->

    <!-- content -->
    <div class="content">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="page-header">Tambah Laporan Gangguan</h2>
            <hr>
            <form action="lapor_tambahgangguanproses.php" method="post" enctype="multipart/form-data">
                <table>
                    <div class="box-body">

                        <div class="form-group mt-3">
                            <label for="">Device : </label>
                            <input type="text" name="device" class="form-control mt-2" placeholder="Nama Device..." required>
                        </div>

                        <div class="form-group mt-3">
                            <label for="">Keterangan : </label>
                            <input type="text" name="keterangan" class="form-control mt-2" placeholder="Keterangan..." required>
                        </div>

                        <div class="form-group mt-3">
                            <label for="">Upload gambar : </label>
                            <input type="file" name="upload" class="form-control mt-2" required>
                        </div>

                        <!-- <div class="box mt-5" style=" display: flex; justify-content: space-between;"> -->
                        <div class="box mt-5">
                            <button type="submit" class="btn btn-primary" name="tambah"><i class="fa fa-plus"></i> Tambah Data</button>
                            <!-- <div class="d-flex"> -->
                            <button type="reset" class="btn btn-danger">Reset Data</button>
                            <a href="lapor.php" class="btn btn-warning">Kembali</a>
                            <!-- </div> -->
                        </div>

                    </div>
        </div>
    </div>