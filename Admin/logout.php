<?php


 if (isset($_POST['keluar'])) {
    session_start();
    session_destroy();
    header('location:../index.php');
}