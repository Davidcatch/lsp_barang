<?php
session_start();


if (!isset($_SESSION['staff'])) {
    header('location:../index.php');
    exit;
}


$_SESSION['tsk'] = 'true';
$_SESSION['lpr'] = 'true';
$_SESSION['hsl'] = 'true';

?>

<html>

<head>
    <title> Menu Utama</title>

    <style>
        * {
            padding: 0;
            margin: 0;
            text-decoration: none;
        }

        .container {
            display: flex;
            background: rgb(0, 176, 240);
            justify-content: flex-start;
            height: 50px;
            align-items: center;
            box-shadow: 7px 7px;
        }

        a {
            color: white;
            margin-left: 10px;
            font-size: 30px;
        }

        .sidebar {
            background: rgb(0, 176, 240);
        }

        a:hover{
            color: #111;
        }

        .hide {
            display: none;
        }

        .show {
            display: inline-block;
        }
    </style>

</head>

<body>
    <form action="" method="post">
        <div class="container">
            <a href="javascript:void(0);" id="btn_transaksi">Transaksi</a>
            <a href="javascript:void(0);" id="btn_laporan">Laporan</a>
            <a href="keluar.php" id="btn_keluar">Keluar</a>
        </div>

        <div class="hide" id="btn-s-transaksi">
            <div class="sidebar">
                <a href="entry_pesanan.php">Entry Pesanan</a>
                <br>
                <hr>
                <a href="entry_cetak_nota.php">Cetak Nota</a>
            </div>
        </div>
        <div class="hide" id="btn-s-laporan">
            <div class="sidebar">
                <a href="entry_laporan_penjualan.php">Laporan Cetak Penjualan</a>
            </div>
        </div>

    </form>

    <script>
        document.getElementById("btn_transaksi")
            .addEventListener('click', (e) => {
                document.getElementById("btn-s-transaksi").classList.toggle("show")
            })
        document.getElementById("btn_laporan")
            .addEventListener('click', (e) => {
                document.getElementById("btn-s-laporan").classList.toggle("show")
            })
    </script>
</body>

</html>