<?php
include 'dbh.inc.php';


  // Get the leave ID from the POST parameters
  $id = $_POST['id'];
  
  $user_id = $_SESSION['userid'];
  $status = 'Reported';
  // Update the leave record to set it as reported
  $sql = "UPDATE leave_application SET status = ? WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $status, $id);
  if ($stmt->execute()) {
    $reported = true;
  } else {
    $reported = false;
    var_dump($reported);
    // Handle the error here
  }


?>
