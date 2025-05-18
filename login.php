<?php
session_start();
require("koneksi/koneksi.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="icon" type="image/png" href="./image aset/images-removebg-preview.png">
    <title>Login</title>
</head>

<body>
    <!----------------------- Main Container -------------------------->
    <div class="row" style="background:#0379C8">
        <div class="container d-flex justify-content-center align-items-center min-vh-100">

            <!----------------------- Login Container -------------------------->

            <div class="row border rounded-5 p-3 bg-white shadow">

                <!-------------------- ------ Right Box ---------------------------->

                <div class="col-md right-box">
                    <div class="row align-items- text-center">
                        <div class="header-text mb-4">
                            <h2>Silahkan Login!</h2>
                        </div>
                        <?php if (isset($_GET['error'])) : ?>
                            <?php if ($_GET['error'] == 'Username atau Password salah') : ?>
                                <div class="alert alert-danger">Username atau Password salah</div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <form action="proseslogin.php" method="post">
                            <div class="input-group mb-3">
                                <input name="username" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Username" required>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" name="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password" required>
                            </div>
                            <div class="input-group mb-3">
                                <button class="btn btn-lg btn-primary w-100 fs-6">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</body>

</html>
</div>