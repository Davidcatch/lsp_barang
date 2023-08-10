<?php 
session_start();

$con = mysqli_connect("localhost","root","","2021152_raihansastrawibyanto");

if (!isset($_SESSION['tsk'])) {
    header('location:../index.php');
    exit;
}

$total = "0";

$sql_auto = mysqli_query($con, "select * from 2021152_Nota order by 2021152_NoNota desc");
$fetch = mysqli_fetch_assoc($sql_auto);
$autonumber = $fetch ['2021152_NoNota'];
$autonumber = substr($autonumber,2,5);
$autonumber = intval($autonumber);
$autonumber +=1;
$jumlah = strlen($autonumber);

if($jumlah == 1){
    $zero = "000";
}else
if($jumlah == 2){
    $zero = "00";
}else
if($jumlah == 3){
    $zero = "0";
}else
if($jumlah == 4){
   $zero = ""; 
}

$autonumber = "NO".$zero.$autonumber;
$nomornota = $autonumber;

$tgl = date("Y-m-d");

$no_sp = "";
$tgl_sp = "";
$id_pelanggan = "";
$nm_pelanggan = "";
$almt_pelanggan = "";
$no_telp = "";

$kd_barang = "";
$nm_barang = "";
$satuan_barang = "";
$jumlah_barang = "";
$harga_barang = "";
$total_harga = "";

if(isset($_POST['cari_sp'])){
    $no_sp = $_POST['no_sp'];
    $sql_sp = mysqli_query($con,"select * from 2021152_sp where 2021152_NoSP='$no_sp'");
    if($sql_sp && mysqli_num_rows($sql_sp) > 0){
        $ambil_sp = mysqli_fetch_assoc($sql_sp);
        $no_sp = $ambil_sp['2021152_NoSP'];
        $tgl_sp = $ambil_sp['2021152_TglSP'];
        $id_pelanggan = $ambil_sp['2021152_IdPelanggan'];

        $sql_pelanggan = mysqli_query($con, "select * from 2021152_pelanggan where 2021152_IdPelanggan='$id_pelanggan'");
        $ambil_pelanggan = mysqli_fetch_assoc($sql_pelanggan);
        $nm_pelanggan = $ambil_pelanggan['2021152_NmPelanggan'];
        $almt_pelanggan = $ambil_pelanggan['2021152_Alamat'];
        $no_telp = $ambil_pelanggan['2021152_NoTelp'];
    } else{
        echo"<script>alert('No SP tidak terdaftar')</script>";
        header('Refresh:0.00000001');
    }
}

if(isset($_POST['cetak'])){
    $no_nota = $_POST['no_nota'];
    $nomorsp = $_POST['no_sp'];
    $tgl_nota = $_POST['tgl_nota'];
    
    $sql_dp = mysqli_query($con, "select * from 2021152_detil_pesan where 2021152_NoSP='$nomorsp'");
    while($dp = mysqli_fetch_assoc($sql_dp)){
        $hrg_jual = $dp['2021152_HrgJual'];
        $jml_jual = $dp['2021152_JmlJual'];
        $jml_harga = $hrg_jual*$jml_jual;
        $total = intval($total)+intval($jml_harga);
    }
    $sql_simpan = mysqli_query($con, "insert into 2021152_Nota (2021152_NoNota,
        2021152_NoSP,2021152_TglNota,2021152_JmlHarga)
        values('$no_nota','$nomorsp','$tgl_nota','$total')");
    header('location:hasil_cetak_nota.php?nota='.$no_nota.' && nosp='.$nomorsp.' && tglnota='.$tgl_nota.'');
}

if (isset($_POST['keluar'])) {
    header("location:../staff/index.php");
}

?>
<html>
    <head>
        <style>
            *{
        margin:0;
        padding:0;
    }

    th{
        font-size:20px;
        padding-top:20px;
        padding-bottom:10px;    
    }

    .input input,button{
        margin-left:30px; 
        width:100px; 
        height:25px;
    }

    .input a{
        text-decoration: none;
        color:black;
    }

    .table{
        border:1px solid black;
        border-collapse:collapse;
        width:100%;
    }
    .table td{
        border:1px solid black;
        padding:10px;
    }

    .table p{
        text-align:center;
    }
        </style>
    </head>
    <body>
        <form action="" method="post">
            <table>
                    <th><p>Data Nota</p></th>
                <tr>
                    <td><p>Nomor Nota</p></td>
                    <td><input type="text" name="no_nota" id="" value=<?php echo $nomornota ?>></td>
                </tr>
                <tr>
                    <td><p>Tanggal Nota</p></td>
                    <td><input type="text" name="tgl_nota" id="" value=<?php echo $tgl?>></td>
                </tr>

                <th><p>Data Pesanan</p></th>
                <td></td>
                <td></td>

                <th style="margin-left: 20px;"><p>Data Pelanggan</p></th>
                <tr>
                    <td><p>Nomor Pesanan</p></td>
                    <td><input type="text" name="no_sp" id="" value=<?php echo $no_sp?>></td>
                    <td><input style="width:80px;" type="submit" value="Cari" name="cari_sp"></td>
                    <td><p style="margin-left:20px;">Id Pelanggan</p></td>
                    <td><input type="text" name="id_pelanggan" id="" value=<?php echo $id_pelanggan?>></td>
                </tr>
                <tr>
                    <td><p>Tanggal Pesanan</p></td>
                    <td><textarea name="tgl_sp" id="" cols="20" rows="1"><?php echo $tgl_sp?></textarea></td>
                    <td></td>
                    <td><p style="margin-left: 20px;">Nama Pelanggan</p></td>
                    <td><input type="text" name="nm_pelanggan" id="" value=<?php echo $nm_pelanggan?>></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><p style="margin-left: 20px;">Alamat Pelanggan</p></td>
                    <td><textarea name="almt_pelanggan" id="" cols="20" rows="5"><?php echo $almt_pelanggan?></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><p style="margin-left: 20px;">Telepon Pelanggan</p></td>
                    <td><input type="text" name="no_telp" id="" value=<?php echo $no_telp?>></td>
                </tr>
            </table>
            <br>
            <table class="table">
            <thead>
                <td><p>Kode Barang</p></td>
                <td><p>Nama Barang</p></td>
                <td><p>Satuan Barang</p></td>
                <td><p>Jumlah Pesan</p></td>
                <td><p>Harga Pesan</p></td>
                <td><p>Jumlah harga</p></td>
            </thead>
            <tbody>
                <?php 
                if(isset($_POST['cari_sp'])){
                    $no_sp = $_POST['no_sp'];
                    $sql_dp = mysqli_query($con, "select * from 2021152_detil_pesan where 2021152_NoSP='$no_sp'");

                    while($ambil_dp = mysqli_fetch_assoc($sql_dp)){
                        $kd_barang = $ambil_dp['2021152_KdBarang'];
                        $jumlah_barang = $ambil_dp['2021152_JmlJual'];
                        $harga_barang = $ambil_dp['2021152_HrgJual'];
                        $total_harga = $jumlah_barang*$harga_barang;
                        $total = intval($total)+intval($total_harga);

                        $sql_barang = mysqli_query($con, "select * from 2021152_barang where 2021152_KdBarang='$kd_barang'");
                        $properties = mysqli_fetch_assoc($sql_barang);
                        $nm_barang = $properties ['2021152_NmBarang'];
                        $satuan_barang = $properties ['2021152_Satuan'];

                        echo"<tr>
                                <td>
                                    $kd_barang
                                </td>
                                <td>
                                    $nm_barang
                                </td>
                                <td>
                                    $satuan_barang
                                </td>
                                <td>
                                    $jumlah_barang
                                </td>
                                <td>
                                    $harga_barang
                                </td>
                                <td>
                                    $total_harga
                                </td>
                        
                            </tr>";
                        
                    }
                }
                    
                ?>
            </tbody>
            </table>
            <br>
            <?php
            echo "<p>Total Harga</p><input readonly type='text' value=$total>";
            ?>
            <center>
            <table style="margin-top: 2rem;">
                <tr>
                    <td><input style="width: 80px; height: 40px;;" type="submit" name="cetak" id="cetak" value="Cetak"></td>
                    <td><input style="margin-left: 20px; width: 80px; height: 40px;;" type="submit" name="batal" id="batal" value="Batal"></td>
                    <td><input style="margin-left: 20px; width: 80px; height: 40px; " type="submit" name="keluar" id="keluar" value="Keluar"></td>
                </tr>
            </table>
            </center>
        </form>
    </body>
</html>