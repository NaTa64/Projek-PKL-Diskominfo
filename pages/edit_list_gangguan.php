<?php

session_start();
require('../koneksi/koneksi.php');

if (!isset($_SESSION['id']) || $_SESSION['account_type'] != 'admin' && $_SESSION['account_type'] != 'teknisi') {
    header('location: ../logout.php');
}


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
      <link rel="icon" type="image/png" href="assets/img/logo.png">

    <link href="../assets/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/status.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <title>Administrator</title>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="../dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>

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
            <h2 class="page-header">Edit List Gangguan</h2>
            <hr>
            <form action="edit_list_gangguanproses.php" method="post" enctype="multipart/form-data">
                <table>

                    <?php
                    $id = $_GET['id'];

                    $query = $conn->query("SELECT
                    list_gangguan.id,
                    list_gangguan.keterangan,
                    list_gangguan.status,
                    list_gangguan.tanggal_gangguan,
                    device.device as nama_device
                    from list_gangguan
                    JOIN device on device.id = list_gangguan.id_device
                    WHERE list_gangguan.id = $id");

                    $result = $query->fetch_assoc();
                    ?>

                    <div class="box-body">

                        <div class="form-group">
                            <!-- <label>ID :</label> -->
                            <input type="hidden" value="<?php echo $result['id'] ?>" name="id">
                            <input type="hidden" value="<?= $result['id']; ?>" name="id">
                        </div>

                        <div class="form-group mt-3">
                            <label>Device : </label>
                            <input type="text" disabled value="<?php echo $result['nama_device'] ?>" name="device" class="form-control mt-2">
                            <input type="hidden" value="<?php echo $result['nama_device'] ?>" name="device">
                        </div>

                        <div class="form-group mt-3">
                            <label for="">Keterangan : <?php echo $result['keterangan']; ?></label>
                            <input type="text" value="<?php echo $result['keterangan'] ?>" name="keterangan" class="form-control mt-2">
                        </div>

                        <div class="form-group mt-3">
                            <label for="">Status : </label>
                            <div class="form-group" style="margin-top: 10px; ">
                                <label class="radio-inline">
                                    <input type="radio" name="status" value="open" id="open" <?php if ($result['status'] == 'open') echo 'checked'; ?> required />
                                    Open
                                </label>

                                <label class="radio-inline">
                                    <input type="radio" name="status" value="pending" id="pending" <?php if ($result['status'] == 'pending') echo 'checked'; ?> required />
                                    Pending
                                </label>

                                <label class="radio-inline">
                                    <input type="radio" name="status" value="closed" id="closed" <?php if ($result['status'] == 'closed') echo 'checked'; ?> required />
                                    Closed
                                </label>
                            </div>
                        </div>

                        <div class="box mt-5">
                            <button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-plus"></i> Simpan</button>
                            <?php if ($_SESSION['account_type'] == 'admin') { ?>
                                <a href="../list_gangguan.php" class="btn btn-warning">Kembali</a>
                            <?php }else { ?>
                                <a href="../status_gangguan.php" class="btn btn-warning">Kembali</a>
                            <?php } ?>
                        </div>

                    </div>
        </div>
    </div>