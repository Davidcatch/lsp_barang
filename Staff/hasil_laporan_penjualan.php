<?php 
session_start();

$con = mysqli_connect("localhost","root","","2021152_raihansastrawibyanto");
error_reporting(0);

if (!isset($_SESSION['hsl'])) {
    header('location:../staff/index.php');
}

?>
<html>
    <head>
        <title>Cetak_Nota</title>
    </head>
    <body>
        <center>
            <table>
                <tr>
                    <td style="width: 1000px;">
                        <img src="../img/metik.png" alt="smkmediainformatika" style="width: 70px; position: absolute; margin: 30px 100px 0 0;"> 
                        <h1 style="text-align: center;">Laporan Penjualan</h1>
                        <p style="text-align: center;">Jl. Papan I/Pisangan Kretek No.99, Petukangan Selatan, Pesanggrahan, Jakarta 12270
                            <br>
                            Telepon/Fax : (021) 2270 4966 Website : www.smkmediainformatika.sch.id
                            <hr style="border: 1px solid black;">
                        </p>
                    </td>
                </tr>
            </table>
            <table border="1" cellspacing="0" style="width: 500px; text-align: center;">
            <thead>
                <td>No Nota</td>
                <td>Nama Pelanggan</td>
                <td>Tanggal</td>
                <td>Total Harga</td>
            </thead>
            <tbody>
                <?php 
                $dari = $_GET['dari'];
                $sampai = $_GET['sampai'];
                $sql_nota = mysqli_query($con, "select * from 2021152_nota nota,2021152_pelanggan p,
                2021152_sp sp where nota.2021152_NoSP=sp.2021152_NoSP and sp.2021152_IdPelanggan=p.2021152_IdPelanggan 
                and 2021152_TglNota between '$dari' and '$sampai'"); 
                while($ambil_nota = mysqli_fetch_assoc($sql_nota)){
                    $no_nota = $ambil_nota['2021152_NoNota'];
                    $nm_pelanggan = $ambil_nota['2021152_NmPelanggan'];
                    $tgl = $ambil_nota['2021152_TglNota'];
                    $jml = $ambil_nota['2021152_JmlHarga'];
                    
                    echo '<tr>
                            <td>'.$no_nota.'</td>
                            <td>'.$nm_pelanggan.'</td>
                            <td>'.$tgl.'</td>
                            <td>'.$jml.'</td>
                        </tr>';
                }
                
                ?>
            </tbody>
            </table>
            
        </center>
    </body>
</html>

<script>
    print();
    setTimeout(() =>{
        window.location.href="../staff/index.php";
    },300) ;
</script>
