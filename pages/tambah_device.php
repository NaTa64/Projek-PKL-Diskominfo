<?php
session_start();

if (!isset($_SESSION['id'])  && !isset($_SESSION['account_type'])) {
    echo "<script>window.open('login.php','_self')</script>";
}

require("../koneksi/koneksi.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/sidebar.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="./image aset/images-removebg-preview.png">
    <title>Administrator</title>
</head>

<body>
    
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>

        <?php if ($_SESSION['account_type'] === 'admin') { ?>
            <a href="../device.php"><i class="fas fa-box"></i> Device</a>
        <?php } ?>

        <div class="dropdown">
            <a href="#" class="dropdown-toggle" onclick="toggleDropdown()"><i class="fas fa-clipboard"></i>List Gangguan</a>
            <div class="dropdown-menu" id="dropdown-menu">
                <?php if ($_SESSION['account_type'] === 'admin') { ?>
                    <a href="../list_gangguan.php">Lapor Gangguan</a>
                <?php } else { ?>
                    <a href="#" style="cursor: not-allowed; color: #ccc; text-decoration: none; pointer-events: none;" onclick="return false;">Lapor Gangguan <i class="fas fa-lock" style="color: red;"></i></a>
                <?php } ?>
                <a href="../status_gangguan.php">Status Gangguan</a>
                <a href="../list_gangguan_riwayat.php">Riwayat Gangguan</a>
            </div>
            <script>
                function toggleDropdown() {
                    var dropdownMenu = document.getElementById("dropdown-menu");
                    if (dropdownMenu.style.display === "block") {
                        dropdownMenu.style.display = "none";
                        dropdownToggle.innerHTML = '<i class="fas fa-clipboard"></i> Gangguan <i class="fas fa-angle-left"></i>';
                    } else {
                        dropdownMenu.style.display = "block";
                        dropdownToggle.innerHTML = '<i class="fas fa-clipboard"></i> Gangguan <i class="fas fa-angle-down"></i>';
                    }
                }
            </script>
        </div>

        <div class="dropdown">
            <a href="#" class="dropdown-toggle" onclick="toggleDropdown2()"><i class="fas fa-clipboard"></i> User</a>
            <div class="dropdown-menu" id="dropdown-menu-user">
                <a href="../status_gangguan_user.php">Status Gangguan</a>
                <a href="../status_gangguan_user_riwayat.php">Riwayat Gangguan</a>
            </div>
            <script>
                function toggleDropdown2() {
                    var dropdownMenu = document.getElementById("dropdown-menu-user");
                    if (dropdownMenu.style.display === "block") {
                        dropdownMenu.style.display = "none";
                        dropdownToggle.innerHTML = '<i class="fas fa-clipboard"></i> Gangguan <i class="fas fa-angle-left"></i>';
                    } else {
                        dropdownMenu.style.display = "block";
                        dropdownToggle.innerHTML = '<i class="fas fa-clipboard"></i> Gangguan <i class="fas fa-angle-down"></i>';
                    }
                }
            </script>
        </div>

        <div style="flex-grow: 1;"></div>
        <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    <!-- Sidebar -->

    <!-- content -->
    <div class="content">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="page-header">Tambah Device</h2>
            <hr>
            <form role="form1" action="tambah_deviceproses.php" method="post">
                <table>
                    <div class="box-body">

                        <div class="form-group mt-3">
                            <label for="">Nama Device : </label>
                            <input type="text" name="device" class="form-control mt-2" placeholder="Nama Device..." required>
                        </div>

                        <div class="form-group mt-3">
                            <label for="">Tipe : </label>
                            <select name="tipe" class="form-control mt-2" required>
                                <option value="">Pilih Tipe</option>
                                <option value="CCTV">CCTV</option>
                                <option value="link">link</option>
                            </select>
                        </div>

                        <!-- <div class="box mt-5" style=" display: flex; justify-content: space-between;"> -->
                        <div class="box mt-5">
                            <button type="submit" class="btn btn-primary" name="tambah"><i class="fa fa-plus"></i> Tambah Data</button>
                            <!-- <div class="d-flex"> -->
                            <button type="reset" class="btn btn-danger">Reset Data</button>
                            <a href="produk.php" class="btn btn-warning">Kembali</a>
                            <!-- </div> -->
                        </div>

                    </div>
        </div>
    </div>