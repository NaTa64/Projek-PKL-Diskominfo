<?php
session_start();
require("koneksi/koneksi.php");

if (!isset($_SESSION['id']) || (isset($_SESSION['id']) && $_SESSION['account_type'] != 'admin')) {
  echo "<script>window.open('logout.php','_self')</script>";
}

function validate($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if (isset($_GET['tipe']) && $_GET['tipe'] != '') {
  $tipe = validate($_GET['tipe']);
  $query = "SELECT * from device where type='$tipe'";
} else {
  $query = "SELECT * from device order by type desc";
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
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="assets/img/logo.png">
  <title>Device</title>

  <style>
    .form-select {
      width: 95%;
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

  <!-- container -->
  <div class="content">
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <h2 class="page-header">Device</h2>

      <hr>

      <!-- sesi untuk tombol tambah gangguan & filter data-->
      <?php
      if ($_SESSION['account_type'] === 'admin') {
      ?>
        <div class="row-search flex-end" style="padding-bottom: 10px;">
          <form action="" method="get" class="d-flex me-2">
            <div class="col-md-6">
              <select class="form-select" name="tipe">
                <option value="">Pilih tipe</option>
                <option value="link" <?= isset($_GET['tipe']) == true ? ($_GET['tipe'] == 'link' ? 'selected' : '') : '' ?>>link</option>
                <option value="CCTV" <?= isset($_GET['tipe']) == true ? ($_GET['tipe'] == 'CCTV' ? 'selected' : '') : '' ?>>CCTV</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="device.php" class="btn btn-danger">Reset</a>
          </form>
          
          <a href="https://pwa.samagov.id/masyarakat/pantau-sekitar" class="btn btn-info" target="_blank">Pantau CCTV</a>
          <a href="pages/tambah_device.php" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Device</a>
        </div>
      <?php
      }
      ?>
      <!-- sesi untuk tombol tambah gangguan & filter data-->

      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th width="5%" style="text-align: center;">No</th>
            <th width="20%">Nama Device</th>
            <th width="5%">Tipe</th>
          </tr>
        </thead>

        <?php

        $result = $conn->query($query);
        $no = 1;
        while ($lihat = $result->fetch_assoc()) {
          $nama_device = $lihat['device'];
          $tipe_device = $lihat['type'];

        ?>
          <tbody>
            <tr>
              <td style="text-align: center;"><?php echo $no; ?></td>

              <td><?php echo $nama_device; ?></td>

              <td><?php echo $tipe_device; ?></td>

              <!-- <td>
                <div class="btn-group">
                  <a href="pesanan_edit.php?order_id=<?php echo $lihat['order_id']; ?>" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
                  <a href="hapuspeminjaman.php?id=<?php echo $lihat['order_id']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                </div>
              </td> -->

            </tr>
            <?php $no++; ?>
          <?php
        } ?>
          </tbody>
      </table>
      <hr>

    </div>
  </div>
  <!-- container -->

</body>

</html>