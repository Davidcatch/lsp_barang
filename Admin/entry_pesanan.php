<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "2021152_raihansastrawibyanto");

if (!isset($_SESSION['tsk'])) {
    header('location:../index.php');
    exit;
}

#error_reporting(E_ERROR); 
$cari = mysqli_query($con, "select * from 2021152_sp order by 2021152_NoSP desc");
$waktu = date("Y-m-d");
$no_sp = mysqli_fetch_assoc($cari);
$autonumber = $no_sp['2021152_NoSP'];
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
$autonumber = "SP" . $zero . $autonumber;

$nosp = $autonumber;

$total=0;
$id_barang = "";
$nm_barang = "";
$satuan_barang = "";
$harga_barang = "";
$jumlah_barang = "";

$id_pelanggan = "";
$nm_pelanggan = "";
$alamat_pelanggan = "";
$nomor_telp = "";

if (isset($_POST['tambah'])) {
    $id = $_POST['id_barang'];
    $nm = $_POST['nm_barang'];
    $satuan = $_POST['satuan'];
    $hrg_barang = $_POST['hrg_barang'];
    $hrg_pesan = $_POST['hrg_pesan'];
    $jml_pesan = $_POST['jml_pesan'];

    $sql_barang=mysqli_query($con,"select * from 2021152_barang where 2021152_KdBarang='$id'");
    $ambil=mysqli_fetch_assoc($sql_barang);

    $sql = mysqli_query($con, "INSERT INTO temporary_sp (no_sp,id_barang,nm_barang,satuan,hrg_barang,hrg_pesan,jml_pesan) 
        values ('$nosp','$id','$nm','$satuan','$hrg_barang','$hrg_pesan','$jml_pesan')");
}

if (isset($_POST['keluar'])) {
    header("location:../Admin/index.php");
}

if (isset($_POST['batal'])) {
    header("refresh:0.000000001");
}

if (isset($_POST['hapus'])) {
    mysqli_query($con, "delete from temporary_sp");
    header("refresh:0.000001");
}

if (isset($_POST['cari_barang'])) {
    $id = $_POST['id_barang'];

    $sql = mysqli_query($con, "select * from 2021152_barang where 2021152_KdBarang='$id'");
    if ($sql) {
        if ($sql && mysqli_num_rows($sql) > 0) {
            $ambil = mysqli_fetch_assoc($sql);

            $id_barang = $ambil['2021152_KdBarang'];
            $nm_barang = $ambil['2021152_NmBarang'];
            $satuan_barang = $ambil['2021152_Satuan'];
            $harga_barang = $ambil['2021152_HrgBarang'];
            $jumlah_barang = $ambil['2021152_Stok'];
        }
    }
}

if (isset($_POST['cari_pelanggan'])) {
    $id = $_POST['id_pelanggan'];

    $sql = mysqli_query($con, "select * from 2021152_pelanggan where 2021152_IdPelanggan='$id'");
    if ($sql) {
        if ($sql && mysqli_num_rows($sql) > 0) {
            $ambil = mysqli_fetch_assoc($sql);

            $id_pelanggan = $ambil['2021152_IdPelanggan'];
            $nm_pelanggan = $ambil['2021152_NmPelanggan'];
            $alamat_pelanggan = $ambil['2021152_Alamat'];
            $nomor_telp = $ambil['2021152_NoTelp'];
        }
    }
}

if (isset($_POST['simpan'])) {
    $id_pelanggan = $_POST['id_pelanggan'];
    if (!empty($id_pelanggan)) {
        $sql = mysqli_query($con, "insert into 2021152_sp (2021152_NoSP,2021152_IdPelanggan,2021152_TglSP) values ('$nosp','$id_pelanggan','$waktu')");
        $sql_dp = mysqli_query($con, "insert into 2021152_detil_pesan (2021152_NoSP,2021152_KdBarang,2021152_JmlJual,2021152_HrgJual) select no_sp,
        id_barang,jml_pesan,hrg_pesan from temporary_sp");
        $delete = mysqli_query($con, "delete from temporary_sp");
        header("refresh:0.0000001");
    } else {
        echo "<script>alert('Data pelanggan tidak boleh kosong')</script>";
        header("refresh:0.0000001");
    }
}
?>

<style>
    * {
        margin: 0;
        padding: 0;
    }

    th {
        font-size: 20px;
        padding-top: 20px;
        padding-bottom: 10px;
    }

    .input input {
        margin-left: 30px;
        width: 100px;
        height: 25px;
    }

    .table {
        border: 1px solid black;
        border-collapse: collapse;
        width: 100%;
    }

    .table td {
        border: 1px solid black;
        padding: 10px;
    }

    .table p {
        text-align: center;
    }
</style>

<html>

<head>
    <title>Entry Pesanan</title>
</head>

<body>

    <form action="" method="post">
        <table style="margin-left:20px;">

            <th>
                <p>Data Pesanan</p>
            </th>


            <tr>
                <td>
                    <p>Nomor Pesanan</p>
                </td>

                <td>
                    <input type="text" value=<?php echo $nosp ?> name="no_sp">
                </td>


            </tr>


            <tr>
                <td>
                    <p>Tanggal Pesanan</p>
                </td>
                <td>
                    <textarea value=<?php echo $waktu ?>><?php echo $waktu ?></textarea>
                </td>
            </tr>

            <tr>
                <th>
                    <p>Data Barang</p>
                </th>
                <td></td>
                <td></td>

                <th>
                    <p style="margin-left:20px;">Data Pelanggan</p>
                </th>

            </tr>

            <tr>
                <td>
                    <p>Kode Barang</p>
                </td>
                <td>
                    <input type="text" name="id_barang" value=<?php echo $id_barang ?>>
                </td>
                <td>
                    <input style="width:80px;" type="submit" value="Cari" name="cari_barang">
                </td>
                <td>
                    <p style="margin-left:20px;">ID Pelanggan</p>
                </td>
                <td>
                    <input type="text" name="id_pelanggan" value=<?php echo $id_pelanggan ?>>
                </td>
                <td>
                    <input style="width:80px;" type="submit" value="Cari" name="cari_pelanggan">
                </td>
            </tr>
            <tr>
                <td>
                    <p>Nama Barang</p>
                </td>
                <td>
                    <textarea name="nm_barang" value=<?php echo $nm_barang ?>><?php echo $nm_barang ?></textarea>
                </td>
                <td>
                </td>
                <td>
                    <p style="margin-left:20px;">Nama Pelanggan</p>
                </td>
                <td>
                    <textarea name="nm_pelanggan" value=<?php echo $nm_pelanggan ?>><?php echo $nm_pelanggan ?></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Satuan Barang</p>
                </td>
                <td>
                    <input type="text" name="satuan" value=<?php echo $satuan_barang ?>>
                </td>
                <td>
                </td>
                <td>
                    <p style="margin-left:20px;">Alamat</p>
                </td>
                <td>
                    <textarea name="alamat" value=<?php echo $alamat_pelanggan ?>><?php echo $alamat_pelanggan ?></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Harga Barang</p>
                </td>
                <td>
                    <input type="text" name="hrg_barang" value=<?php echo $harga_barang ?>>
                </td>
                <td>
                </td>
                <td>
                    <p style="margin-left:20px;">No Telp</p>
                </td>
                <td>
                    <input type="text" name="no_telp" value=<?php echo $nomor_telp ?>>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Harga Pesan</p>
                </td>
                <td>
                    <input type="text" name="hrg_pesan">
                </td>
            </tr>
            <tr>
                <td>
                    <p>Jumlah Pesan</p>
                </td>
                <td>
                    <input type="number" name="jml_pesan">
                </td>
            </tr>
        </table>

        <table style="margin-top:50px;">
            <td div class="input">
                <input style="margin-left:50px;" type="submit" value="Tambah" name="tambah">
                <input type="submit" value="Hapus" name="hapus">
                <input style="margin-left:150px;" type="submit" value="Simpan" name="simpan">
                <input type="submit" value="Batal" name="batal">
                <input type="submit" value="Keluar" name="keluar">
            </td>
        </table>

        <table div class="table" style="margin-top:50px;">
            <td>
                <p>Kode barang</p>
            </td>
            <td>
                <p>Nama Barang</p>
            </td>
            <td>
                <p>Satuan barang</p>
            </td>
            <td>
                <p>Jumlah Pesan</p>
            </td>
            <td>
                <p>Harga Pesan</p>
            </td>
            <td>
                <p>Jumlah Harga</p>
            </td>
            <?php
            $sql = mysqli_query($con, "select * from temporary_sp");
            if ($sql) {
                while ($row = mysqli_fetch_assoc($sql)) {
                    $id = $row['id_barang'];
                    $nama = $row['nm_barang'];
                    $stn = $row['satuan'];
                    $jml_pesan = $row['jml_pesan'];
                    $hrg_pesan = $row['hrg_pesan'];
                    $jml_harga = intval($jml_pesan) * intval($hrg_pesan);
                    $total=intval($total) + intval($jml_harga);

                    echo '<tr>
          <td style="text-align:center;">' . $id . '</td>
          <td style="text-align:center;">' . $nama . '</td>
          <td style="text-align:center;">' . $stn . '</td>
          <td style="text-align:center;">' . $jml_pesan . '</td>
          <td style="text-align:center;">' . $hrg_pesan . '</td>
          <td style="text-align:center;">' . $jml_harga . '</td>
          <tr>';
                }
            }
            ?>
        </table>
        <br>
        <p style="display:flex; justify-content: flex-end;">Total Harga <input readonly style="border: 1px solid black;" type="text" value=<?php echo $total?>></p>

</body>
</form>

</html>