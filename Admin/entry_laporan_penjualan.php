<?php 

$con = mysqli_connect("localhost","root","","2021152_raihansastrawibyanto");

if(isset($_POST['keluar'])){
  header("location:../Admin/index.php");
}

if(isset($_POST['cetak'])){
  $dari = $_POST['dari'];
  $sampai = $_POST['sampai'];
  if(!empty($dari) && !empty($sampai)){
    header("location:hasil_laporan_penjualan.php?dari=$dari && sampai=$sampai");
  }else{
    echo"<script>alert('Periode tidak boleh kosong')</script>";
    header("Refresh:0.00000001");
  }
}

?>
<html>
  <head>
    <title>Laporan Penjualan</title>
    <style>
      center {
        margin-top: 20%;
      }
      p {
        font-size: 25px;
      }
      input {
        width: 150px;
        height: 20px;
      }
    </style>
  </head>
  <body>
    <form
      action=""
      method="post"
    >
      <center>
        <table>
          <h1>Laporan Penjualan</h1>
          <tr>
            <td><p>Periode</p></td>
            <td>
              <input
                type="date"
                name="dari"
                id="periode"
              />
            </td>
            <td><p>S/D</p></td>
            <td>
              <input
                type="date"
                name="sampai"
                id="s_d"
              />
            </td>
          </tr>
        </table>
        <br />
        <table>
          <tr>
            <td>
              <input
                style="width: 80px; margin-left: 10px; height: 30px"
                type="submit"
                name="cetak"
                id="cetak"
                value="Cetak"
              />
            </td>
            <td>
              <input
                style="width: 80px; margin-left: 10px; height: 30px"
                type="submit"
                name="keluar"
                id="keluar"
                value="Keluar"
              />
            </td>
          </tr>
        </table>
      </center>
    </form>
  </body>
</html>
