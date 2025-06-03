<?php
session_start();

require("koneksi/koneksi.php");

if (!isset($_SESSION['id']) || (isset($_SESSION['id']) && $_SESSION['account_type'] != 'admin' && $_SESSION['account_type'] != 'teknisi')) {
  header('Location: logout.php');
  exit;
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

  <script src="/js/jquery.min1.js"></script>
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


  <!-- Content -->
  <div class="content">
    <h2>Dashboard</h2>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <div class="panel-body">
        <h2 class="text-center">Data</h2>
        <hr>
        <div class="row">

          <?php if ($_SESSION['account_type'] === 'admin') { ?>
            <div class="col-md-4">
              <a href="device.php" class="card-link">
                <div class="card-info">
                  <i class="fas fa-box icon"></i>
                  <h4>Device</h4>
                  <div class="value">
                    <?php

                    $query = $conn->query("SELECT count(id) as a FROM device");
                    $data = $query->fetch_assoc();
                    echo $data['a'];
                    ?>
                  </div>
                </div>
              </a>
            </div>
          <?php } ?>

          <!-- <div class="row"> -->
          <div class="col-md-4">
            <a href="status_gangguan.php" class="card-link">
              <div class="card-info">
                <i class="fas fa-clipboard icon"></i>
                <h4>List Gangguan Down</h4>
                <div class="value">
                  <?php
                  $query_list = $conn->query("SELECT count(id) as gangguan FROM list_gangguan WHERE status='tidak_aktif' and DATE(tanggal_gangguan) = CURDATE()");
                  $data_list = $query_list->fetch_assoc();
                  echo $data_list['gangguan'];
                  ?>
                </div>
              </div>
            </a>
          </div>
          <!-- </div> -->

          <div class="col-md-4">
            <a href="status_gangguan_user.php" class="card-link">
              <div class="card-info">
                <i class="fas fa-box-open icon"></i>
                <h4>Laporan User Down</h4>
                <div class="value">
                  <?php
                  $query_user = $conn->query("SELECT count(id_laporan) as user from lapor_gangguan WHERE status='tidak_aktif' and aktif=1");
                  $data_user = $query_user->fetch_assoc();
                  echo $data_user['user'];
                  ?>
                </div>
              </div>
            </a>
          </div>

          <!-- Barang Dikembalikan -->
          <!-- <div class="col-md-4">
            <a href="riwayatpemesanan.php" class="card-link">
              <div class="card-info">
                <i class="fas fa-undo icon"></i>
                <h4>Riwayat Pemesanan</h4>
                <div class="value">
                  <?php

                  ?>
                </div>
              </div>
            </a>
          </div> -->

        </div>
      </div>
    </div>
  </div>

</body>

</html>