<?php
session_start();
require("../../koneksi/koneksi.php");

// jika sesi id tidak ada maka arahkan ke logout ATAU jika sesi ada DAN tipe akunnya bukan user arahkan ke logout
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
    <link rel="stylesheet" href="../../assets/css/sidebar.css
    ">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="./image aset/images-removebg-preview.png">
    <title>User</title>
</head>

<body>
    <div class="sidebar">
        <a href="lapor.php"><i class="fas fa-clipboard"></i> Lapor Gangguan</a>
        <a href="status.php"><i class="fas fa-clipboard"></i> Status</a>
        <div style="flex-grow: 1;"></div>
        <a href="../../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="content">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="page-header">Status Gangguan</h2>
            <hr>

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
                $query = $conn->query("SELECT * FROM lapor_gangguan WHERE aktif=1");

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

                            <td style="text-align: center;">
                                <?php if ($status == 'aktif') { ?>
                                    <i class="fas fa-check" style="color: green;"></i>
                                <?php } else { ?>
                                    <i class="fas fa-times" style="color: red;"></i>
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