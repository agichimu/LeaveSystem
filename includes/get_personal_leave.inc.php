<?php

// Retrieve the user ID from the session
$user_id = $_SESSION['userid'];
include 'dbh.inc.php';
//include 'functions.inc.php'; already included in get current leave.inc.php

$leave = getMyLeaves($conn, $user_id);
return $leave;