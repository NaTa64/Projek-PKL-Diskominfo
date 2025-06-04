<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="assets/img/logo.png">
    <title>Web Pelaporan Gangguan Jaringan</title>
    <style>
        * {
            font-family: 'Roboto', monospace;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Set the background image for the page */
        body {
            background-image: url('assets/img/bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            color: white;
        }

        /* Navbar Styling */
        .navbar {
            background-color: rgba(0, 8, 0, 0.7);
            padding: 8px 15px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            opacity: 0;
            animation: fadeInNav 1s ease-out forwards;
        }

        @keyframes fadeInNav {
            0% {
                opacity: 0;
                transform: translateY(-30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .navbar-brand {
            font-size: 22px;
            font-weight: bold;
            color: #fff;
        }

        .navbar-brand img {
            height: 40px;
            width: 40px;
            margin-right: 10px;
        }

        .navbar-nav .nav-item .nav-link {
            font-size: 16px;
            padding: 8px 12px;
            color: white;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .navbar-nav .nav-item .nav-link:hover {
            color: #00FF00;
            transform: scale(1.1);
        }

        .navbar-toggler-icon {
            background-color: #00FF00;
        }

        /* Animasi untuk tombol login */
        .navbar-nav .nav-item .btn {
            opacity: 0;
            animation: fadeInButton 1s ease-out forwards;
            animation-delay: 1s;
        }

        @keyframes fadeInButton {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animasi untuk konten */
        .content-section {
            opacity: 0;
            animation: fadeInMoveUp 2s ease-out forwards;
            text-align: center;
            margin-top: 100px;
            /* Menyesuaikan margin untuk desktop */
        }

        @keyframes fadeInMoveUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Content styling */
        .content-section h1 {
            font-size: 36px;
            font-weight: bold;
        }

        .content-section p {
            font-size: 18px;
        }

        .content-section .row {
            margin-top: 20px;
        }

        /* Footer styling */
        footer {
            background-color: #1B5D8B;
            color: white;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            opacity: 0;
            animation: fadeInFooter 1s ease-out forwards;
            animation-delay: 1.5s;
        }

        @keyframes fadeInFooter {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .footer-text {
            font-size: 14px;
        }

        /* Responsif untuk tampilan perangkat kecil */
        @media (max-width: 768px) {
            .content-section {
                margin-top: 150px;
                /* Tambahkan margin-top lebih besar pada perangkat kecil */
            }

            .content-section h1 {
                font-size: 28px;
                /* Ukuran font h1 lebih kecil di perangkat kecil */
            }

            .content-section p {
                font-size: 16px;
                /* Ukuran font paragraf lebih kecil */
            }
        }

        /* Hover Effect untuk tombol login */
        .navbar-nav .nav-item .btn {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar-nav .nav-item .btn:hover {
            background-color: #2691D9;
            color: white;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="assets/img/logo.png" alt="Logo" style="height: 45px; width: 45px;">
                Web Pelaporan Gangguan Jaringan
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item ms-5">
                        <a href="login.php">
                            <button type="button" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </button>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content Section -->
    <div class="content-section">
        <h1 class="fw-bolder mb-4">ABOUT</h1>

        <!-- Wrapper for text content with background -->
        <div class="row align-items-center">
            <!-- Gambar Perusahaan -->
            <div class="col-md-4 mt-4">
                <img src="assets/img/topologi-removebg-preview.png" alt="Company Image" class="" style="height: 250px; object-fit: cover;">
            </div>

            <!-- Deskripsi Tentang Kami -->
            <div class="col-md-8 mt-4">
                <div class="p-4" style="background-color: rgba(0, 0, 0, 0.6); border-radius: 10px;">
                    <p style="font-size: 18px; line-height: 1.6; color: white; text-align: justify;">
                        Aplikasi Pelaporan Gangguan Jaringan & CCTV merupakan platform berbasis web yang dirancang untuk memfasilitasi pelaporan dan penanganan gangguan pada infrastruktur jaringan komunikasi dan sistem pengawasan (CCTV) secara efisien.
                    </p>
                    <p style="font-size: 18px; line-height: 1.6; color: white; text-align: justify;">
                        Aplikasi ini mendukung pelaporan secara real-time, memungkinkan instansi terkait untuk merespons dan menangani masalah dengan cepat dan tepat.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>