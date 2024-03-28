<?php

// Retrieve the user ID from the session
$user_id = $_SESSION['userid'];
include 'dbh.inc.php';
include 'functions.inc.php';

$leave = getLatestLeave($conn, $user_id);
return $leave;