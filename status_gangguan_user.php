<?php
session_start();
require("koneksi/koneksi.php");

if (!isset($_SESSION['id']) || (isset($_SESSION['id']) && $_SESSION['account_type'] != 'admin' && $_SESSION['account_type'] != 'teknisi')) {
    header('Location: logout.php');
    exit;
}

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_GET['date']) && $_GET['date'] != '') {
    $date = validate($_GET['date']);
    $query = $conn->query("SELECT
                lapor_gangguan.id_laporan,
                lapor_gangguan.id_user,
                lapor_gangguan.device,
                lapor_gangguan.keterangan,
                lapor_gangguan.tanggal_gangguan,
                lapor_gangguan.tanggal_selesai,
                lapor_gangguan.status,
                lapor_gangguan.image,
                lapor_gangguan.aktif,
                users.user_name
                FROM lapor_gangguan
                JOIN users ON users.id = lapor_gangguan.id_user and date(tanggal_gangguan) = '$date'
                where aktif=1 order by status desc");
} else {
    $query = $conn->query("SELECT
                lapor_gangguan.id_laporan,
                lapor_gangguan.id_user,
                lapor_gangguan.device,
                lapor_gangguan.keterangan,
                lapor_gangguan.tanggal_gangguan,
                lapor_gangguan.tanggal_selesai,
                lapor_gangguan.status,
                lapor_gangguan.image,
                lapor_gangguan.aktif,
                users.user_name
                FROM lapor_gangguan
                JOIN users ON users.id = lapor_gangguan.id_user 
                order by status desc");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/sidebar.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <link rel="icon" type="image/png" href="assets/img/logo.png">
    <title>Status Gangguan User</title>

    <script>
        $(document).ready(function() {
            $('.btn-hapus').click(function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'pages/sg_user_hapus.php?id=' + id;
                    }
                });
            });
        });
    </script>

    <style>
        @media (max-width: 768px) {
            th {
                display: none;
            }

            td {
                display: grid;
            }

            td:first-child {
                padding-top: 2rem;
            }

            td:last-child {
                padding-bottom: 2rem;
            }

            td::before {
                content: attr(data-th) ": " attr(data-value);
                font-weight: 700;
            }

            /* Untuk form filter di mobile */
            form.d-flex {
                flex-direction: column;
                gap: 10px !important;
                width: 100%;
            }

            form.d-flex .form-select,
            form.d-flex .btn {
                width: 100% !important;
                max-width: 100% !important;
            }
        }
    </style>
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
            <h2 class="page-header">Status Gangguan User</h2>

            <hr>

            <!-- Filter Data -->
            <div class="row mb-2">
                <div class="col-md-12 d-flex justify-content-end">
                    <form action="" method="get" class="d-flex align-items-center gap-2">
                        <!-- Input tanggal gangguan -->
                        <input type="date" name="date" value="<?= isset($_GET['date']) == true ? $_GET['date'] : '' ?>" class="form-control">

                        <!-- Tombol Filter -->
                        <button type="submit" class="btn btn-primary">Filter</button>

                        <!-- Tombol Reset -->
                        <a href="status_gangguan_user.php" class="btn btn-danger">Reset</a>
                    </form>
                </div>
            </div>
            <!--END Filter Data -->

            <table id="tabel" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="text-align: center;">No</th>
                        <th>Pelapor</th>
                        <th>Nama Device</th>
                        <th>Keterangan</th>
                        <th>Tanggal Gangguan</th>
                        <th>Gambar Device</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center;">Opsi</th>
                    </tr>
                </thead>

                <?php

                $nomor = 1;
                while ($lihat = $query->fetch_assoc()) {
                    $nm_device = $lihat['device'];
                    $ket = $lihat['keterangan'];
                    $tggl_gangguan = $lihat['tanggal_gangguan'];
                    // $tggl_selesai = $lihat['tanggal_selesai'];
                    $gambar = $lihat['image'];
                    $status = $lihat['status'];

                ?>
                    <tbody>
                        <tr>
                            <td data-th="No" style="text-align: center;"><?php echo $nomor; ?></td>
                            <td data-th="Pelapor"><?php echo $lihat['user_name']; ?></td>
                            <td data-th="Nama Device"><?php echo htmlspecialchars($nm_device); ?></td>
                            <td data-th="Keterangan"><?php echo htmlspecialchars($ket); ?></td>
                            <td data-th="Tanggal Gangguan"><?php echo date('d-m-Y H:i:s', strtotime($tggl_gangguan)); ?></td>

                            <td data-th="Gambar Device"><a href="<?php echo 'pages/user/bukti_device/' . $gambar; ?>" target="_blank">lihat</a></td>

                            <td width="10%" style="text-align: center;">
                                <?php if ($status == 'open') { ?>
                                    <button class="btn btn-success btn-md">Open</button>
                                <?php } elseif ($status == 'pending') { ?>
                                    <button class="btn btn-warning btn-md">Pending</button>
                                <?php } else { ?>
                                    <button class="btn btn-secondary btn-md">Closed</button>
                                <?php } ?>
                            </td>

                            <td data-th="Opsi" style="text-align: center;">
                                <a href="pages/sg_user_edit.php?id=<?php echo $lihat['id_laporan'] ?>" class="btn btn-primary"><i class="fas fa-edit"> Edit</i></a>

                                <?php if ($_SESSION['account_type'] == 'admin') { ?>
                                    <button class="btn btn-danger btn-hapus" data-id="<?php echo $lihat['id_laporan']; ?>">
                                        <i class="fa fa-trash"> Hapus</i>
                                    </button>
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