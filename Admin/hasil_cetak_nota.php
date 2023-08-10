<?php 
session_start();

$con = mysqli_connect("localhost","root","","2021152_raihansastrawibyanto");
error_reporting(0);

if (!isset($_SESSION['hsl'])) {
    header('location:../Admin/index.php');
}

$total = "";

$no_nota = $_GET['nota'];
$nomorsp = $_GET['nosp'];
$tgl_nota = $_GET['tglnota'];

$sql_sp = mysqli_query($con, "select * from 2021152_sp where 2021152_NoSP='$nomorsp'");
$sql_dp = mysqli_query($con, "select * from 2021152_detil_pesan where 2021152_NoSP='$nomorsp'");

$ambil_idplg = mysqli_fetch_assoc($sql_sp);
$id_pelanggan = $ambil_idplg['2021152_IdPelanggan'];
$sql_plg = mysqli_query($con,"select * from 2021152_pelanggan where 2021152_IdPelanggan='$id_pelanggan'");

$ambil_nmplg = mysqli_fetch_assoc($sql_plg);
$nm_pelanggan = $ambil_nmplg['2021152_NmPelanggan'];
$alamat = $ambil_nmplg['2021152_Alamat'];
$no_telp = $ambil_nmplg['2021152_NoTelp'];

while($dp = mysqli_fetch_assoc($sql_dp)){
    $hrg_jual = $dp['2021152_HrgJual'];
    $jml_jual = $dp['2021152_JmlJual'];
    $jumlah_harga = $hrg_jual*$jml_jual;
    $total = intval($total)+intval($jumlah_harga);
}
?>

<html>
    <head>
        <title>Cetak Nota</title>
    </head>

    <body>
        <form action="" method="post">
            <center>
                <table style="width: 100%;">
                    <tr>
                        <td>
                            <img src="../img/metik.png" alt="smkmediainformatika" style="width: 70px; position: absolute; margin: 30px 100px 0 0;"> 
                            <h1 style="text-align: center;">Koperasi SMK MEDIA INFORMATIKA</h1>
                            <p style="text-align: center;">Jl. Papan I/Pisangan Kretek No.99, Petukangan Selatan, Pesanggrahan, Jakarta 12270
                                <br>
                                Telepon/Fax : (021) 2270 4966 Website : www.smkmediainformatika.sch.id
                                <hr style="border: 1px solid black;">
                            </p>
                        </td>
                    </tr>
                </table>
                    <p>NOTA</p>
                    <table style="width: 100%;">
                        <tr>
                            <td>
                                <p>Nomor Nota : <?php echo $no_nota ?></p>
                            </td>
                            <td>
                                <p style="margin-left: 20%;">Nama Pelanggan : <?php echo $nm_pelanggan ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Tanggal Nota : <?php echo $tgl_nota ?></p>
                            </td>
                            <td>
                                <p style="margin-left: 20%;">Alamat : <?php echo $alamat ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Jumlah Bayar : Rp.<?php echo $total ?></p>
                            </td>
                            <td>
                                <p style="margin-left: 20%;">Telp : <?php echo $no_telp ?></p>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table border="1" cellspacing="0" style="border-collapse: collapse; width: 80%; text-align: center; ">
                        <thead>
                            <tr>
                                <td>Kode</td>
                                <td>Nama Barang</td>
                                <td>Jumlah Pesan</td>
                                <td>Harga</td>
                                <td>Jumlah Harga</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sql_dp = mysqli_query($con, "select * from 2021152_detil_pesan where 2021152_NoSP='$nomorsp'");

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
                                
                                    </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
            </center>
        </form>
    </body>
</html>

<script>
    print();
    setTimeout(() =>{
        window.location.href="../Admin/entry_cetak_nota.php";
    },300);
</script>