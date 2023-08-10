<?php
include 'logout.php';
session_start();
$con = mysqli_connect("localhost", "root", "", "2021152_raihansastrawibyanto");

$user = "";
$hak = "";
$pass = "";
$cpass = "";

//add user
if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $hakakses = $_POST['hakakses'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

   /*  $cari = mysqli_query($con,"select * from 2021152_user where 2021152_username='$username'");
    if($sql && mysqli_num_rows($sql) > 0){
        echo"<script>alert('Username sudah ada')</script>";
        header("Refresh:0.0000000001");
        die;
    } */

    if(!empty($username) && !empty($hakakses) && !empty($password) && !empty($cpassword)){
        if($password == $cpassword){
            $sql = mysqli_query($con, "insert into 2021152_user (2021152_username,2021152_password,2021152_hakakses)
              values ('$username','$password','$hakakses')");
            echo"<script>alert('Username sudah ada')</script>";
        header("location:../index.php?username=Admin");
        }
        echo"<script>alert('password & confirm password tidak sama!')</script>";
        header("Refresh:0.0000000001");
        die;
    }   
    echo"<script>alert('Masukkan data!')</script>";
        header("Refresh:0.0000000001");
        die;
    
}
//batal
if (isset($_POST['batal'])) {
    $user = "";
    $hak = "";
    $pass = "";
    $cpass = "";
}

?>


<html>

<head>
    <title>Login</title>

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
            width: 400px;
            height: 200px;
            border: 2px solid;
            border-radius: 10px;
            box-shadow: 7px 7px;
        }

        input,select 
        {
            width: 100px;
        }

        table.form-signup
        {
            margin-top: 10%;
        }

    </style>
</head>

<body>
    <form action="" method="post">
        <center>
        <div class="container">
            <div class="box">
        <table class="form-signup">
            <tr>
                <td>
                    <p>Username</p>
                </td>
                <td>
                    <input type="text" name="username" id="username" required>

                </td>

            </tr>
            <tr>
                <td>
                    <p>Hak Akses</p>
                </td>
                <td>
                    <select name="hakakses" id="hakakses">
                        <option>admin</option>
                        <option>staff</option>
                    </select>
                </td>

            </tr>
            <tr>
                <td>
                    <p>Password</p>
                </td>
                <td>
                    <input type="password" name="password" id="password">
                </td>
            </tr>
            <tr>
                <td>
                    <p>confirm Password</p>
                </td>
                <td>
                    <input type="password" name="cpassword" id="cpassword">
                </td>
            </tr>
        </table>
        <table>
                <td>
                    <input type="submit" name="tambah" id="tambah" value="tambah">
                    <input type="submit" name="batal" id="batal" value="batal">
                    <input type="submit" name="keluar" id="keluar" value="keluar">
                </td>
        </table>
        </center>
        </div>
        </div>
    </form>
    <table>
</body>

</html>