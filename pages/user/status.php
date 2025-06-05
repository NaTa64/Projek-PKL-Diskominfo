<?php
session_start();
require("../../koneksi/koneksi.php");

// jika sesi id tidak ada maka arahkan ke logout ATAU jika sesi ada DAN tipe akunnya bukan user arahkan ke logout
if (!isset($_SESSION['id']) || (isset($_SESSION['id']) && $_SESSION['account_type'] != 'user')) {
    session_destroy(); // hapus session
    header('Location: ../../logout.php');
    exit;
}

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_GET['date']) && $_GET['date'] != '' && isset($_GET['status']) && $_GET['status'] != '') {
    $date = validate($_GET['date']);
    $status = validate($_GET['status']);
     $query = $conn->query("SELECT * FROM lapor_gangguan
    JOIN users ON users.id = lapor_gangguan.id_user and date(tanggal_gangguan) = '$date' and status='$status' WHERE lapor_gangguan.aktif=1 AND lapor_gangguan.id_user = '" . $_SESSION['id'] . "' order by tanggal_gangguan desc");
} elseif (isset($_GET['date']) && $_GET['date'] != '') {
    $date = validate($_GET['date']);
    $query = $conn->query("SELECT * FROM lapor_gangguan
    JOIN users ON users.id = lapor_gangguan.id_user and date(tanggal_gangguan) = '$date' WHERE lapor_gangguan.aktif=1 AND lapor_gangguan.id_user = '" . $_SESSION['id'] . "' order by tanggal_gangguan desc");
} elseif (isset($_GET['status']) && $_GET['status'] != '') {
    $status = validate($_GET['status']);
    $query = $conn->query("SELECT * FROM lapor_gangguan
    JOIN users ON users.id = lapor_gangguan.id_user and status = '$status' WHERE lapor_gangguan.aktif=1 AND lapor_gangguan.id_user = '" . $_SESSION['id'] . "' order by tanggal_gangguan desc");
} else {
    $query = $conn->query("SELECT * FROM lapor_gangguan
    JOIN users ON users.id = lapor_gangguan.id_user WHERE lapor_gangguan.aktif=1 AND lapor_gangguan.id_user = '" . $_SESSION['id'] . "' order by tanggal_gangguan desc");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/css/sidebar.css
    ">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="assets/img/logo.png">
    <title>User</title>
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

    <div class="content">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="page-header">Status Gangguan</h2>

            <hr>

            <!-- Filter Data -->
            <div class="row mb-2">
                <div class="col-md-12 d-flex justify-content-end">
                    <form action="" method="get" class="d-flex align-items-center gap-2">
                        <!-- Input tanggal gangguan -->
                        <input type="date" name="date" value="<?= isset($_GET['date']) == true ? $_GET['date'] : '' ?>" class="form-control">

                        <!-- Input Tipe perangkat -->
                        <select class="form-select" name="status">
                            <option value="">Pilih status</option>
                            <option value="open" <?= (isset($_GET['status']) && $_GET['status'] == 'open') ? 'selected' : '' ?>>Open</option>
                            <option value="pending" <?= (isset($_GET['status']) && $_GET['status'] == 'pending') ? 'selected' : '' ?>>Pending</option>
                            <option value="closed" <?= (isset($_GET['status']) && $_GET['status'] == 'closed') ? 'selected' : '' ?>>Closed</option>
                        </select>

                        <!-- Tombol Filter -->
                        <button type="submit" class="btn btn-primary">Filter</button>


                        <!-- Tombol Reset -->
                        <a href="status.php" class="btn btn-danger">Reset</a>
                    </form>
                </div>
            </div>
            <!--END Filter Data -->

            <table id="tabelpelanggan" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="text-align: center;">No</th>
                        <th>Nama Device</th>
                        <th>Keterangan</th>
                        <th>Tanggal Gangguan</th>
                        <th>Tanggal Selesai</th>
                        <th style="text-align: center;">Status</th>
                    </tr>
                </thead>

                <?php
                // pakai query ini jika hanya menampilkan laporan hanya hari ini
                // $query = $conn->query("SELECT * FROM lapor_gangguan WHERE DATE(tanggal_gangguan) = CURDATE()");

                $nomor = 1;
                while ($lihat = $query->fetch_assoc()) {
                    $nm_device = $lihat['device'];
                    $ket = $lihat['keterangan'];
                    $tggl_gangguan = $lihat['tanggal_gangguan'];
                    $tggl_selesai = $lihat['tanggal_selesai'];
                    $status = $lihat['status'];

                ?>
                    <tbody>
                        <tr>
                            <td style="text-align: center;"><?php echo $nomor; ?></td>
                            <td><?php echo htmlspecialchars($nm_device); ?></td>
                            <td><?php echo htmlspecialchars($ket); ?></td>
                            <td><?php echo date('d-m-Y H:i:s', strtotime($tggl_gangguan)); ?></td>

                            <td>
                                <?php if ($tggl_selesai == null) { ?>
                                <?php } else { ?>
                                    <?php echo date('d-m-Y H:i:s', strtotime($tggl_selesai)); ?>
                                <?php } ?>
                            </td>

                            <td data-th="Status" width="10%" style="text-align: center;">
                                <?php if ($status == 'open') { ?>
                                    <button class="btn btn-success btn-md">Open</button>
                                <?php } elseif ($status == 'pending') { ?>
                                    <button class="btn btn-warning btn-md">Pending</button>
                                <?php } else { ?>
                                    <button class="btn btn-secondary btn-md">Closed</button>
                                <?php } ?>
                            </td>

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