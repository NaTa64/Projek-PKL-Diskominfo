<?php
session_start();
require("koneksi/koneksi.php");

if (!isset($_SESSION['id'])  && !isset($_SESSION['account_type'])) {
    echo "<script>window.open('login.php','_self')</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- sidebar css -->
    <link rel="stylesheet" href="assets/css/sidebar.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="./image aset/images-removebg-preview.png">
    <title>Riwayat List Gangguan</title>

</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>

        <?php if ($_SESSION['account_type'] === 'admin') { ?>
            <a href="device.php"><i class="fas fa-box"></i> Device</a>
        <?php } ?>

        <div class="dropdown">
            <a href="#" class="dropdown-toggle" onclick="toggleDropdown()"><i class="fas fa-clipboard"></i>List Gangguan</a>
            <div class="dropdown-menu" id="dropdown-menu">
                <?php if ($_SESSION['account_type'] === 'admin') { ?>
                    <a href="list_gangguan.php">Lapor Gangguan</a>
                <?php } else { ?>
                    <a href="#" style="cursor: not-allowed; color: #ccc; text-decoration: none; pointer-events: none;" onclick="return false;">Lapor Gangguan <i class="fas fa-lock" style="color: red;"></i></a>
                <?php } ?>
                <a href="status_gangguan.php">Status Gangguan</a>
                <a href="list_gangguan_riwayat.php">Riwayat Gangguan</a>
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
                <a href="status_gangguan_user.php">Status Gangguan</a>
                <a href="status_gangguan_user_riwayat.php">Riwayat Gangguan</a>
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
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    <!-- Sidebar -->

    <div class="content">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="page-header">Riwayat List Gangguan</h2>

            <hr>

            <!-- Filter Data -->
            <div class="row">
                <div class="col-md-5">
                    <!-- <h6>Filter Data</h6> -->
                </div>

                <div class="col-md-7">
                    <form action="" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="date" name="date" value="<?= isset($_GET['date']) == true ? $_GET['date'] : '' ?>" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" name="tipe" id="">
                                    <option value="">Pilih tipe</option>
                                    <option value="link" <?= isset($_GET['tipe']) == true ? ($_GET['tipe'] == 'link' ? 'selected' : '') : '' ?>>link</option>
                                    <option value="CCTV" <?= isset($_GET['tipe']) == true ? ($_GET['tipe'] == 'CCTV' ? 'selected' : '') : '' ?>>CCTV</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="list_gangguan_riwayat.php" class="btn btn-danger">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Filter Data -->

            <?php
            function validate($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            if (isset($_GET['date']) && $_GET['date'] != '' && isset($_GET['tipe']) && $_GET['tipe'] != '') {
                $date = validate($_GET['date']);
                $tipe = validate($_GET['tipe']);
                $query = $conn->query("SELECT * FROM list_gangguan JOIN device on list_gangguan.id_device = device.id WHERE date(tanggal_gangguan)='$date' AND device.type='$tipe'");
            } elseif (isset($_GET['date']) && $_GET['date'] != '') {
                $date = validate($_GET['date']);
                $query = $conn->query("SELECT * FROM list_gangguan JOIN device on list_gangguan.id_device = device.id WHERE date(tanggal_gangguan)='$date'");
            } elseif (isset($_GET['tipe']) && $_GET['tipe'] != '') {
                $tipe = validate($_GET['tipe']);
                $query = $conn->query("SELECT * FROM list_gangguan JOIN device on list_gangguan.id_device = device.id WHERE device.type='$tipe'");
            } else {
                $query = $conn->query("SELECT * FROM list_gangguan JOIN device on list_gangguan.id_device = device.id ORDER BY tanggal_gangguan DESC");
            }
            ?>

            <table id="tabelpelanggan" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="text-align: center;">No</th>
                        <th>Nama Device</th>
                        <th>Tipe</th>
                        <th>Keterangan</th>
                        <th style="text-align: center;">Status</th>
                        <th>Tanggal Gangguan</th>
                    </tr>
                </thead>

                <?php

                $nomor = 1;
                while ($lihat = $query->fetch_assoc()) {
                    $nm_device = $lihat['device'];
                    $ket = $lihat['keterangan'];
                    $status = $lihat['status'];
                    $tggl_gangguan = $lihat['tanggal_gangguan'];
                    $tipe = $lihat['type']

                ?>
                    <tbody>
                        <tr>
                            <td style="text-align: center;"><?php echo $nomor; ?></td>
                            <td><?php echo htmlspecialchars($nm_device); ?></td>
                            <td><?php echo ($tipe); ?></td>
                            <td><?php echo htmlspecialchars($ket); ?></td>

                            <td width="10%" style="text-align: center;">
                                <?php if ($status == 'aktif') { ?>
                                    <i class="fas fa-check" style="color: green;"></i>
                                <?php } else { ?>
                                    <i class="fas fa-times" style="color: red;"></i>
                                <?php } ?>
                            </td>

                            <td><?php echo date('d-m-Y H:i:s', strtotime($tggl_gangguan)); ?></td>
                            <!-- <td><?php echo $tggl_gangguan; ?></td> -->

                        </tr>
                        <?php $nomor++; ?>
                    <?php
                } ?>
                    </tbody>
            </table>

        </div>
    </div>
</body>

</html>