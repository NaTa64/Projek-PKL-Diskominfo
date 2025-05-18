<?php
session_start();
require("koneksi/koneksi.php");

if (!isset($_SESSION['id']) && !isset($_SESSION['account_type'])) {
    header('location: logout.php');
}

// Konfigurasi pagination
$records_per_page =10; // Jumlah record per halaman

// Hitung total records
if (isset($_GET['date']) && $_GET['date'] != '' && isset($_GET['tipe']) && $_GET['tipe'] != '') {
    $date = validate($_GET['date']);
    $tipe = validate($_GET['tipe']);
    $count_query = $conn->query("SELECT COUNT(*) as total FROM list_gangguan JOIN device on list_gangguan.id_device = device.id WHERE date(tanggal_gangguan)='$date' AND device.type='$tipe'");
} elseif (isset($_GET['date']) && $_GET['date'] != '') {
    $date = validate($_GET['date']);
    $count_query = $conn->query("SELECT COUNT(*) as total FROM list_gangguan JOIN device on list_gangguan.id_device = device.id WHERE date(tanggal_gangguan)='$date'");
} elseif (isset($_GET['tipe']) && $_GET['tipe'] != '') {
    $tipe = validate($_GET['tipe']);
    $count_query = $conn->query("SELECT COUNT(*) as total FROM list_gangguan JOIN device on list_gangguan.id_device = device.id WHERE device.type='$tipe'");
} else {
    $count_query = $conn->query("SELECT COUNT(*) as total FROM list_gangguan JOIN device on list_gangguan.id_device = device.id");
}

$total_records = $count_query->fetch_assoc()['total'];
$total_pages = ceil($total_records / $records_per_page);

// Dapatkan halaman saat ini
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) {
    $current_page = 1;
} elseif ($current_page > $total_pages) {
    $current_page = $total_pages;
}

// Hitung offset
$offset = ($current_page - 1) * $records_per_page;

// Query dengan pagination
if (isset($_GET['date']) && $_GET['date'] != '' && isset($_GET['tipe']) && $_GET['tipe'] != '') {
    $date = validate($_GET['date']);
    $tipe = validate($_GET['tipe']);
    $query = $conn->query("SELECT * FROM list_gangguan JOIN device on list_gangguan.id_device = device.id WHERE date(tanggal_gangguan)='$date' AND device.type='$tipe' ORDER BY tanggal_gangguan DESC LIMIT $offset, $records_per_page");
} elseif (isset($_GET['date']) && $_GET['date'] != '') {
    $date = validate($_GET['date']);
    $query = $conn->query("SELECT * FROM list_gangguan JOIN device on list_gangguan.id_device = device.id WHERE date(tanggal_gangguan)='$date' ORDER BY tanggal_gangguan DESC LIMIT $offset, $records_per_page");
} elseif (isset($_GET['tipe']) && $_GET['tipe'] != '') {
    $tipe = validate($_GET['tipe']);
    $query = $conn->query("SELECT * FROM list_gangguan JOIN device on list_gangguan.id_device = device.id WHERE device.type='$tipe' ORDER BY tanggal_gangguan DESC LIMIT $offset, $records_per_page");
} else {
    $query = $conn->query("SELECT * FROM list_gangguan JOIN device on list_gangguan.id_device = device.id ORDER BY tanggal_gangguan DESC LIMIT $offset, $records_per_page");
}

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/sidebar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <p>Total Data: <?php echo $total_records; ?></p>
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
                <tbody>
                    <?php
                    $nomor = $offset + 1;
                    while ($lihat = $query->fetch_assoc()) {
                        $nm_device = $lihat['device'];
                        $ket = $lihat['keterangan'];
                        $status = $lihat['status'];
                        $tggl_gangguan = $lihat['tanggal_gangguan'];
                        $tipe = $lihat['type'];
                    ?>
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
                        </tr>
                    <?php
                        $nomor++;
                    }
                    ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($current_page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $current_page - 1; ?><?php echo isset($_GET['date']) ? '&date=' . $_GET['date'] : ''; ?><?php echo isset($_GET['tipe']) ? '&tipe=' . $_GET['tipe'] : ''; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php
                    // Tampilkan 5 halaman sebelum dan sesudah halaman saat ini
                    $start_page = max(1, $current_page - 2);
                    $end_page = min($total_pages, $current_page + 2);

                    if ($start_page > 1) {
                        echo '<li class="page-item"><a class="page-link" href="?page=1' . (isset($_GET['date']) ? '&date=' . $_GET['date'] : '') . (isset($_GET['tipe']) ? '&tipe=' . $_GET['tipe'] : '') . '">1</a></li>';
                        if ($start_page > 2) {
                            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        }
                    }

                    for ($i = $start_page; $i <= $end_page; $i++) {
                        $active = ($i == $current_page) ? 'active' : '';
                        echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page=' . $i . (isset($_GET['date']) ? '&date=' . $_GET['date'] : '') . (isset($_GET['tipe']) ? '&tipe=' . $_GET['tipe'] : '') . '">' . $i . '</a></li>';
                    }

                    if ($end_page < $total_pages) {
                        if ($end_page < $total_pages - 1) {
                            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        }
                        echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . (isset($_GET['date']) ? '&date=' . $_GET['date'] : '') . (isset($_GET['tipe']) ? '&tipe=' . $_GET['tipe'] : '') . '">' . $total_pages . '</a></li>';
                    }
                    ?>

                    <?php if ($current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $current_page + 1; ?><?php echo isset($_GET['date']) ? '&date=' . $_GET['date'] : ''; ?><?php echo isset($_GET['tipe']) ? '&tipe=' . $_GET['tipe'] : ''; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <!-- End Pagination -->

        </div>
    </div>
</body>

</html>