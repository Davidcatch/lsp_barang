<?php
session_start();
include 'config.php';

$user = "";
$pass = "";
$hak = "";

if(isset($_GET['username'])){
    $user = $_GET['username'];
    $sql = mysqli_query($con, "select * from 2021152_user where 2021152_username='$user'");
    if($sql && mysqli_num_rows($sql)){
        $ambil = mysqli_fetch_assoc($sql);
        $hak = $ambil ['2021152_hakakses'];
    }
}

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $hak = $_POST['hak'];
    
    $sql = mysqli_query($con, "select * from 2021152_user where 2021152_username='$user' and 2021152_password='$pass' and 2021152_hakakses='$hak'");
    if ($sql) {
        if ($sql && mysqli_num_rows($sql) > 0) {
            $ambil = mysqli_fetch_assoc($sql);
            if ($ambil['2021152_password'] == $pass) {
                if ($ambil['2021152_hakakses'] == 'admin') {
                    $_SESSION['2021152_username'] = $user;
                    $_SESSION['2021152_hakakses'] = 'admin';
                    //session jika belum login
                    $_SESSION['admin'] = 'true';
                    $_SESSION['plg'] = 'true';
                    $_SESSION['brg'] = 'true';
                    $_SESSION['tsk'] = 'true';
                    $_SESSION['lpr'] = 'true';
                    echo "<script>
                    alert('Login Berhasil');
                    </script>";
                    header('location:../2021152_raihansastrawibyanto/Admin');
                } else
                if ($ambil['2021152_hakakses'] == 'staff') {
                    $_SESSION['2021152_username'] = $user;
                    $_SESSION['2021152_hakakses'] = 'staff';
                    //session jika belum login
                    $_SESSION['staff'] = 'true';
                    echo "<script>
                    alert('Login Berhasil');
                    </script>";
                    header("location:../2021152_raihansastrawibyanto/Staff");
                } else {
                    echo "<script>
                    alert('Username/Password Salah!');
                    </script>";
                }
            }
        }
    }
}


if (isset($_POST['tambah'])) {
    header('location:../2021152_raihansastrawibyanto/Admin/SignUp.php');
}

?>

<html>

    <head>
        <link rel="shortcut icon" type="image/jpg" href="/img/favicon.ico">
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
                        width: 300px;
                        height: 300px;
                        border: 2px solid;
                        border-radius: 10px;
                        box-shadow: 7px 7px;
                    }

                    img
                    {
                        margin-top: 10%;
                    }

                    p
                    {
                        margin: 10px 0 0 10px;
                    }

                    input,select
                    {
                        margin: 10px 10px 0 0;
                        width: 100px;
                    }

                    table.form-login
                    {
                        margin-top: 10%;
                    }

                   
                </style>
    </head>

<body>
    <form action="" method="post">
        <div class="container">
          <div class="box">
            <center>
            <table class="form-login">
                <tr>
                    <img src="img/metik.png" alt="smkmediainformatika" style="width: 50px;">
                </tr>
                <tr>
                    <td>
                        <p>Username</p>
                    </td>
                    <td>
                        <select name="username" id="username">
                            <?php
                                $sql = mysqli_query($con,"select * from 2021152_user");
                                if($sql && mysqli_num_rows($sql)){
                                    while($ambil = mysqli_fetch_assoc($sql)){
                                        $user = $ambil['2021152_username'];
                                        if(isset($_GET['username']) && $_GET['username'] == $user){
                                            echo"<option selected>$user</option>";
                                        }else{
                                            echo"<option>$user</option>";
                                        }
                                    }
                                }
                            ?>
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
                        <p>Hak Akses</p>
                    </td>
                    <td>
                        <input readonly type="text" name="hak" id="hakakses" value=<?php echo $hak?>>
                    </td>
                </tr>
            </table>
            <table class="button">
                <tr>
                    <td>
                        <input type="submit" name="tambah" id="adduser" value="add user">
                        <input type="submit" name="login" id="login" value="login">
                    </td>
                </tr>
            </table>
          </div>  
        </div>
        </center>
    </form>
</body>
</html>

<script>
    document.getElementById('username').addEventListener('change', () =>{
        let username = document.getElementById('username').value 
        window.location.href="index.php?username=" + username;
    })
</script>