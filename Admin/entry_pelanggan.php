<?php
session_start();


$con = mysqli_connect("localhost", "root", "", "2021152_raihansastrawibyanto");

$cari = mysqli_query($con, "select * from 2021152_pelanggan order by 2021152_IdPelanggan desc");
$id_plg = mysqli_fetch_assoc($cari);
$autonumber = $id_plg['2021152_IdPelanggan'];
$autonumber = substr($autonumber, 1, 3);
$autonumber = intval($autonumber);
$autonumber += 1;
$jumlah = strlen($autonumber);
if ($jumlah == 1) {
    $zero = "00";
} else if ($jumlah == 2) {
    $zero = "0";
} else if ($jumlah == 3) {
    $zero = "";
}
$autonumber = "P" . $zero . $autonumber;


$idpelanggan = "$autonumber";
$nmpelanggan = "";
$almtpelanggan = "";
$notelppelanggan = "";

if (isset($_POST['cari'])) {
    $id = $_POST['idpelanggan'];

    $cari = mysqli_query($con, "SELECT * FROM 2021152_pelanggan where 2021152_IdPelanggan='$id'");
    if ($cari && mysqli_num_rows($cari) > 0) {
        $ambil = mysqli_fetch_assoc($cari);
        $idpelanggan = $ambil['2021152_IdPelanggan'];
        $nmpelanggan = $ambil['2021152_NmPelanggan'];
        $almtpelanggan = $ambil['2021152_Alamat'];
        $notelppelanggan = $ambil['2021152_NoTelp'];
    } else {
        echo "<script>alert('Id tidak terdaftar')</script>";
        header('Refresh:0.000001');
    }
}

if (isset($_POST['simpan'])) {
    $id = $_POST['idpelanggan'];
    $nm = $_POST['nmpelanggan'];
    $almt = $_POST['alamat'];
    $notelp = $_POST['notelp'];

    $sql = mysqli_query($con, "INSERT INTO 2021152_pelanggan (2021152_IdPelanggan,2021152_NmPelanggan,2021152_Alamat,2021152_NoTelp) 
    VALUES ('$id','$nm','$almt','$notelp')");
    echo "<script>alert('Data berhasil ditambahkan')</script>";
    header('Refresh:0.0000001');
}

if (isset($_POST['ubah'])) {
    $id = $_POST['idpelanggan'];
    $nm = $_POST['nmpelanggan'];
    $almt = $_POST['alamat'];
    $notelp = $_POST['notelp'];

    if (!empty($id) || !empty($nm) || !empty($almt) || !empty($notelp)) {
        $sql = mysqli_query($con, "UPDATE 2021152_pelanggan set 2021152_IdPelanggan='$id', 
        2021152_NmPelanggan='$nm', 2021152_Alamat='$almt', 2021152_NoTelp='$notelp' WHERE 2021152_IdPelanggan='$id'");
        echo "<script>alert('Data berhasil diubah')</script>";

        $idpelanggan = "";
        $nmpelanggan = "";
        $almtpelanggan = "";
        $notelppelanggan = "";
    } else {
        echo "<script>alert('Data tidak boleh kosong')</script>";
        header('Refresh:0.0000001');
    }
}

if (isset($_POST['batal'])) {
    header("Refresh:0.00000001");
}

if (isset($_POST['keluar'])) {
    header('location:../Admin/index.php');
}

if (isset($_POST['hapus'])) {
    $id_plg = $_POST['idpelanggan'];
    $sql = mysqli_query($con, "delete from 2021152_pelanggan where 2021152_IdPelanggan='$id_plg'");
    echo "<script>alert('Data berhasil dihapus')</script>";
}

if (!isset($_SESSION['plg'])) {
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
                <table class="form-pelanggan">
                    <tr>
                        <td>
                            <p>Id Pelanggan</p>
                        </td>
                        <td>
                            <input style="margin-left: 10px;" type="text" name="idpelanggan" id="idpelanggan" value="<?php echo $idpelanggan ?>">
                            <input style="width: 70px; height: 40px; margin-left: 10px;" type="submit" name="cari" id="cari" value="Cari">

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Nama Pelanggan</p>
                        </td>
                        <td>
                            <input style="margin-left: 10px;" type="text" name="nmpelanggan" id="nmpelanggan" value="<?php echo $nmpelanggan ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Alamat Pelanggan</p>
                        </td>
                        <td>
                            <textarea style="margin-left: 10px;" name="alamat" id="alamat" cols="20" rows="5" value="<?php echo $almtpelanggan ?>"><?php echo $almtpelanggan ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>No Telp</p>
                        </td>
                        <td>
                            <input style="margin-left: 10px;" type="text" name="notelp" id="notelp" value="<?php echo $notelppelanggan ?>">
                        </td>
                    </tr>
                </table>
                <table class="button">
                <td>
                    <input style="width: 70px; height: 40px; margin-left: 10px;" type="submit" name="simpan" id="simpan" value="simpan">
                    <input style="width: 70px; height: 40px; margin-left: 10px;" type="submit" name="hapus" id="hapus" value="hapus">
                    <input style="width: 70px; height: 40px; margin-left: 10px;" type="submit" name="ubah" id="ubah" value="ubah">
                    <input style="width: 70px; height: 40px; margin-left: 10px;" type="submit" name="batal" id="batal" value="batal">
                    <input style="width: 70px; height: 40px; margin-left: 10px;" type="submit" name="keluar" id="keluar" value="keluar">
                </td>
                </table>
                </div>
            </div>
        </center>
    </form>
</body>

</html>