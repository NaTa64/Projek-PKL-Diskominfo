<?php
session_start();
require_once("koneksi/koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi input (misalnya, pastikan username dan password tidak kosong)
    if (empty($username) || empty($password)) {
        echo '<div class="alert alert-danger">Username dan Password tidak boleh kosong.</div>';
        exit();
    }

    // Gunakan prepared statement untuk menghindari SQL Injection
    $query = $conn->prepare("SELECT * FROM users WHERE user_name = ? AND password = ?");
    $query->bind_Param("ss", $username, $password); // Mengikat parameter (menghindari SQL Injection)
    $query->execute();

    // Fetch the result
    $result = $query->get_result();

    if ($result->num_rows === 0) {
        // Jika username tidak ditemukan
        header('Location: login.php?error=Username atau Password salah');
        exit();
    } else {
        $row = $result->fetch_assoc();
        if ($password == $row['password']) {
            // Jika password valid, set session untuk login admin
            $_SESSION['id'] = $row['id']; // Menyimpan id admin dalam session
            $_SESSION['account_type'] = $row['type']; // Menyimpan tipe admin dalam session

            // Redirect ke dashboard
            if ($_SESSION['account_type'] == 'admin') {
                header("Location: dashboard.php");
            } elseif ($_SESSION['account_type'] == 'user') {
                header("Location: pages/user/lapor.php"); // Ubah ke halaman yang diinginkan
            } elseif ($_SESSION['account_type'] == 'teknisi') {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            // Jika password salah
            header('Location: login.php?error=Username atau Password salah');
            exit();
        }
    }
}
