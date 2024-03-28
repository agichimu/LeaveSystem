<?php

function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat){
    $result = false;
    if(empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}
function invalidUid($username){
    $result = false;
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}
function invalidEmail($email){
    $result = false;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}
function pwdMatch($pwd,$pwdRepeat){
    $result = false;
    if($pwd != $pwdRepeat){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}
function uidExists($conn,$username, $email){
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}
function createUser($conn, $name, $email, $username, $pwd, $gender) {
    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd, gender) VALUES (?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $username, $hashedPwd, $gender);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../signup.php?error=none");

    exit();
}
function emptyInputLogin($username, $pwd){
    $result = false;
    if(empty($username) || empty($pwd)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}
function loginUser($conn, $username, $pwd){
    $uidExists = uidExists($conn, $username, $username);

    if($uidExists == false){
        header("location: ../login.php?error=wrong login");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if($checkPwd == false){
        header("location: ../login.php?error=checkpassword");
    }else if ($checkPwd == true){
        session_start();
        $_SESSION["userid"] = $uidExists["usersId"];
        $_SESSION["username"] = $uidExists["usersUid"];
        header("location: ../ClientDashboard.php");
        exit();

    }
}
//admin side
function adminUidExists($conn,$username){
    $sql = "SELECT * FROM admin_users WHERE username = ? OR username = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../adminLogin.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt,  "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}
function adminlogin($conn, $username, $pwd){
    $uidExists = adminUidExists($conn, $username, $username);

    if($uidExists == false){
        header("location: ../adminlogin.php?error=wrong login");
        exit();
    }

    
    $checkPwd = '6245';

    if($pwd !== $checkPwd){
        header("location: ../adminLogin.php?error=wrong-pass");
    }else if ($pwd == $checkPwd){
        session_start();
        $_SESSION["userid"] = $uidExists["id"];
        $_SESSION["userid"] = $uidExists["username"];
        header("location: ../AdminDashboard.php");
        exit();

    }
}

function getCurrentLeaves($conn){

    session_start();
    // Retrieve products for current user from database
    $user_id = $_SESSION['username']; // Replace with your session variable name
    $sql = "SELECT * FROM leave_application WHERE employee_id = '$user_id'";
    $result = mysqli_query($conn, $sql);

    // Convert result set to array
    $products = array();
    while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
    }

    // Return products as JSON
    header('Content-Type: application/json');
    echo json_encode($products);
}
//we take all the leaves in the users name
function getMyLeaves($conn, $user_id){
    // replace "your_table_name" with the name of your table
    
    $sql = "SELECT * FROM leave_application WHERE employee_id = ? ORDER BY start_date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $user_id);
    $stmt->execute();

    $leave = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    return $leave;
}
//get on current leave
function getLatestLeave($conn, $user_id){
    // Retrieve the latest leave for the user
    $sql = "SELECT * FROM leave_application WHERE employee_id = ? ORDER BY end_date DESC LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $leave = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    
    return $leave;
    
    
}
function getLeaveBalanceDays($leave_balance){
    $days_left = 0;
    $today = date('Y-m-d'); // Get the current date

    foreach ($leave_balance as $leave) {
        $end_date = $leave['end_date'];
        $diff = strtotime($end_date) - strtotime($today);
        $days_left += max(0, floor($diff / (60 * 60 * 24))); // Calculate the number of days left for this leave record
    }

    return $days_left;
}

function getGender($conn, $user_id) {
    $sql = "SELECT gender FROM users WHERE usersUid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    var_dump($row);
    return $row['gender'];
}


