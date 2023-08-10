<?php
session_start();


$con = mysqli_connect("localhost", "root", "", "2021152_raihansastrawibyanto");

$cari = mysqli_query($con, "select * from 2021152_barang order by 2021152_KdBarang desc");
$kd_brg = mysqli_fetch_assoc($cari);
$autonumber = $kd_brg['2021152_KdBarang'];
$autonumber = substr($autonumber, 2, 5);
$autonumber = intval($autonumber);
$autonumber += 1;
$jumlah = strlen($autonumber);
if ($jumlah == 1) {
    $zero = "000";
} else if ($jumlah == 2) {
    $zero = "00";
} else if ($jumlah == 3) {
    $zero = "0";
} else if ($jumlah == 4) {
    $zero = "";
}
$autonumber = "B" . $zero . $autonumber;

/* $kd_brg = $autonumber; */

$kdbarang = "$autonumber";
$nmbarang = "";
$stok = "";
$satuan = "";
$hargabarang = "";


if (isset($_POST['cari'])) {
    $kd = $_POST['kdbarang'];

    $cari = mysqli_query($con, "SELECT * FROM 2021152_barang where 2021152_kdBarang='$kd'");
    if ($cari && mysqli_num_rows($cari) > 0) {
        $ambil = mysqli_fetch_assoc($cari);
        $kdbarang = $ambil['2021152_KdBarang'];
        $nmbarang = $ambil['2021152_NmBarang'];
        $stok = $ambil['2021152_Stok'];
        $satuan = $ambil['2021152_Satuan'];
        $hargabarang = $ambil['2021152_HrgBarang'];
    } else {
        echo "<script>alert('Kd tidak terdaftar')</script>";
        header('Refresh:0.000001');
    }
}

if (isset($_POST['simpan'])) {
    $kd = $_POST['kdbarang'];
    $nm = $_POST['nmbarang'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];
    $hargabarang = $_POST['hrgbarang'];

    $sql = mysqli_query($con, "INSERT INTO 2021152_barang (2021152_kdBarang,2021152_NmBarang,2021152_Stok,2021152_Satuan, 2021152_Hrgbarang) 
    VALUES ('$kd','$nm','$stok','$satuan','$hargabarang')");
    echo "<script>alert('Data berhasil ditambahkan')</script>";
    header('Refresh:0.0000001');
}

if (isset($_POST['ubah'])) {
    $kd = $_POST['kdbarang'];
    $nm = $_POST['nmbarang'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];
    $hargabarang = $_POST['hrgbarang'];

    if (!empty($kd) || !empty($nm) || !empty($stok) || !empty($satuan) || !empty($hargabarang)) {
        $sql = mysqli_query($con, "UPDATE 2021152_barang set 2021152_KdBarang='$kd', 
        2021152_NmBarang='$nm', 2021152_Stok='$stok', 2021152_Satuan='$satuan', 2021152_HrgBarang='$hargabarang' WHERE 2021152_KdBarang='$kd'");
        echo "<script>alert('Data berhasil diubah')</script>";

        $kdbarang = "";
        $nmbarang = "";
        $stok = "";
        $satuan = "";
        $hargabarang = "";
    } else {
        echo "<script>alert('Data tidak boleh kosong')</script>";
        header('Refresh:0.0000001');
    }
}

if (isset($_POST['batal'])) {
    header('Refresh:0.00000001');
    /* $kdbarang = "";
    $nmbarang = "";
    $stok = "";
    $satuan = "";
    $hargabarang = ""; */
}

if (isset($_POST['hapus'])) {
    $KdBarang = $_POST['kdbarang'];
    $sql = mysqli_query($con, "delete from 2021152_barang where 2021152_Kdbarang='$KdBarang'");
    echo "<script>alert('Data berhasil dihapus')</script>";
}

if (isset($_POST['keluar'])) {
    header('location:../Admin');
}

if (!isset($_SESSION['brg'])) {
    header('location:../index.php');
    exit;
}

?>

<html>

<head>
    <title>Entry Pelanggan</title>

    <style>
        .container
        {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100vh;
        }

        .box
        {
            width: 500px;
            height: 300px;
            border: 2px solid;
            border-radius: 10px;
            box-shadow: 7px 7px;
        }

       p
       {
           margin: 10px 0 0 10px;
       }

       input,textarea
       {
        margin: 10px 10px 0 0;
       }
    </style>

</head>

<body>
    <form action="" method="post">
    <center>
        <div class="container">
            <div class="box">
            <table class="form-barang">
                <tr>
                    <td>
                        <p>Kd Barang</p>
                    </td>
                    <td>
                        <input style="margin-left: 10px;" type="text" name="kdbarang" id="kdbarang" value="<?php echo $kdbarang ?>">
                        <input style="width: 70px; height: 40px; margin-left: 10px;" type="submit" name="cari" id="cari" value="Cari">

                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Nama Barang</p>
                    </td>
                    <td>
                        <input style="margin-left: 10px;" type="text" name="nmbarang" id="nmbarang" value="<?php echo $nmbarang ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Stok</p>
                    </td>
                    <td>
                        <input style="margin-left: 10px;" type="text" name="stok" id="stok" value="<?php echo $stok ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Satuan</p>
                    </td>
                    <td>
                        <input style="margin-left: 10px;" type="text" name="satuan" id="satuan" value="<?php echo $satuan ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Harga Barang</p>
                    </td>
                    <td>
                        <input style="margin-left: 10px;" type="text" name="hrgbarang" id="hrgbarang" value="<?php echo $hargabarang ?>">
                    </td>
                </tr>
            </table>
            <table>
            <td class="button">
                <input style="width: 70px; height: 40px; margin-left: 10px;" type="submit" name="simpan" id="simpan" value="simpan">
                <input style="width: 70px; height: 40px; margin-left: 10px;" type="submit" name="ubah" id="ubah" value="ubah">
                <input style="width: 70px; height: 40px; margin-left: 10px;" type="submit" name="hapus" id="hapus" value="hapus">
                <input style="width: 70px; height: 40px; margin-left: 10px;" type="submit" name="batal" id="batal" value="batal">
                <input style="width: 70px; height: 40px; margin-left: 10px;" type="submit" name="keluar" id="keluar" value="keluar">
            </td>
            </table>
        </center>
        </div>
        </div>
    </form>
</body>

</html>