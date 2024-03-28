<?php

global $conn;
if(isset($_POST["submit"])){
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(emptyInputLogin($username, $pwd) !== false){
        header("location: ../adminLogin.php?error=emptyinput");
        exit();
    }

    adminlogin($conn, $username, $pwd);
}
else{
    header("location: ../adminLogin.php");
    exit;
}