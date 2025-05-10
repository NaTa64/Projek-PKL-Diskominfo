<?php
session_start();
require("koneksi/koneksi.php");

if (!isset($_SESSION['id']) || (isset($_SESSION['id']) && $_SESSION['account_type'] != 'admin')) {
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
      <h2 class="page-header">Lapor List Gangguan</h2>
      <p>Tanggal: <?php echo date('d/m/Y'); ?></p>
      <hr>

      <!-- sesi untuk tombol tambah gangguan -->
      <?php
      if ($_SESSION['account_type'] === 'admin') {
      ?>
        <div class="row-search" style="padding-bottom: 10px;">
          <a href="pages/tambah_gangguan.php" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Gangguan</a>
        </div>
      <?php
      }
      ?>


      <table id="tabelpelanggan" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th style="text-align: center;">No</th>
            <th>Nama Device</th>
            <th>Keterangan</th>
            <!-- <th>Tanggal Gangguan</th> -->
            <th style="text-align: center;">Status</th>
            <th style="text-align: center;">Opsi</th>
          </tr>
        </thead>

        <?php
        $query = $conn->query("SELECT
        list_gangguan.id,
        list_gangguan.keterangan,
        list_gangguan.status,
        list_gangguan.tanggal_gangguan,
        device.device as nama_device
        from list_gangguan
        JOIN device on device.id = list_gangguan.id_device
        WHERE DATE(tanggal_gangguan) = CURDATE()");

        $nomor = 1;
        while ($lihat = $query->fetch_assoc()) {
          $nm_device = $lihat['nama_device'];
          $ket = $lihat['keterangan'];
          $status = $lihat['status'];
          $tggl_gangguan = $lihat['tanggal_gangguan'];

        ?>
          <tbody>
            <tr>
              <td style="text-align: center;"><?php echo $nomor; ?></td>
              <td><?php echo htmlspecialchars($nm_device); ?></td>
              <td><?php echo htmlspecialchars($ket); ?></td>

              <!-- <td><?php echo date('d-m-Y H:i:s', strtotime($tggl_gangguan)); ?></td> -->

              <td width="10%" style="text-align: center;">
                <?php if ($status == 'aktif') { ?>
                  <i class="fas fa-check" style="color: green;"></i>
                <?php } else { ?>
                  <i class="fas fa-times" style="color: red;"></i>
                <?php } ?>
              </td>

              <td style="text-align: center;">
                <a href="pages/edit_list_gangguan.php?id=<?php echo htmlspecialchars($lihat['id']); ?>" class="btn btn-primary"><i class="fas fa-edit"> Edit</i></a>
                <a href="#?id=<?php echo htmlspecialchars($lihat['id']); ?>" class="btn btn-danger"><i class="fa fa-trash"> Hapus</i></a>
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