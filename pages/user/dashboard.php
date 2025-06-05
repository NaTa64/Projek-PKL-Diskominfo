<?php
session_start();

require("../../koneksi/koneksi.php");

if (!isset($_SESSION['id']) || (isset($_SESSION['id']) && $_SESSION['account_type'] != 'user')) {
    header('Location: ../../logout.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- sidebar css -->
    <link rel="stylesheet" href="../../assets/css/sidebar.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <script src="../..//js/jquery.min1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="assets/img/logo.png">

    <title>Dashboard</title>
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


    <!-- Content -->
    <div class="content">
        <h2>Dashboard</h2>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div class="panel-body">
                <h2 class="text-center">Data</h2>
                <hr>
                <div class="row">

                    <!-- <div class="col-md-4">
                        <a href="status.php" class="card-link">
                            <div class="card-info">
                                <i class="fas fa-box-open icon"></i>
                                <h4>Lapor Gangguan</h4>
                                <div class="value">
                                    <?php
                                    $query_user = $conn->query("SELECT count(id_laporan) as user from lapor_gangguan WHERE id_user='" . $_SESSION['id'] . "'");
                                    $data_user = $query_user->fetch_assoc();
                                    echo $data_user['user'];
                                    ?>
                                </div>
                            </div>
                        </a>
                    </div> -->

                    <div class="col-md-4">
                        <a href="status.php" class="card-link">
                            <div class="card-info">
                                <i class="fas fa-box-open icon"></i>
                                <h4>Status Laporan</h4>
                                <div class="value">
                                    <?php
                                    $query_user = $conn->query("SELECT count(id_laporan) as user from lapor_gangguan WHERE id_user='" . $_SESSION['id'] . "' and aktif=1");
                                    $data_user = $query_user->fetch_assoc();
                                    echo $data_user['user'];
                                    ?>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Progress Laporan -->
                    <?php
                    $no=1;
                    $query_user = $conn->query("SELECT * FROM lapor_gangguan WHERE id_user='" . $_SESSION['id'] . "' and aktif=1 ORDER BY id_laporan DESC");
                    while ($data_user = $query_user->fetch_assoc()) {
                    ?>
                        <div class="col-md-4">
                            <a href="status.php" class="card-link">
                                <div class="card-info">
                                    <i class="fas fa-box-open icon"></i>
                                    <h4>Progress Laporan <?php echo $no; ?></h4>
                                    <p style="font-size: small; margin-bottom: 0px;">
                                        <?php
                                        if (!empty($data_user['tanggal_gangguan'])) {
                                            echo 'Tanggal: ' . date('d-m-Y', strtotime($data_user['tanggal_gangguan']));
                                        } elseif (!empty($data_user['tanggal_selesai'])) {
                                            echo 'Tanggal: ' . date('d-m-Y', strtotime($data_user['tanggal_selesai']));
                                        }
                                        ?>
                                    </p>
                                    <p style="font-size: small;">
                                        <?php
                                        if (!empty($data_user['keterangan'])) {
                                            echo 'Keterangan: ' . $data_user['keterangan'];
                                        } else {
                                            echo 'Keterangan: Tidak ada keterangan';
                                        }
                                        ?>
                                    </p>
                                    <div class="value-status">
                                        <?php
                                        if ($data_user['status'] == 'open') {
                                            echo 'Sedang diproses';
                                        } elseif ($data_user['status'] == 'pending') {
                                            echo 'Tertunda';
                                        } else {
                                            echo 'Selesai';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php $no++; ?>
                    <?php
                    }
                    ?>
                    <!--END Progress Laporan -->
                </div>
            </div>

            <!-- <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div class="panel-body">
                <h2 class="text-center">Progress</h2>
                <hr>
                <div class="row">

                    <div class="col-md-4">
                        <a href="status.php" class="card-link">
                            <div class="card-info">
                                <i class="fas fa-box-open icon"></i>
                                <h4>Status Laporan</h4>
                                <div class="value">
                                    <?php
                                    $query_user = $conn->query("SELECT count(id_laporan) as user from lapor_gangguan WHERE id_user='" . $_SESSION['id'] . "'");
                                    $data_user = $query_user->fetch_assoc();
                                    echo $data_user['user'];
                                    ?>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div> -->

        </div>

</body>

</html>
