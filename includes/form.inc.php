<?php
global $conn;
include 'dbh.inc.php';
session_start();
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // Get the form data and validate it
    $type = trim($_POST['type']);
    $startDate = trim($_POST['startDate']);
    $endDate = trim($_POST['endDate']);
    $currentDate = date('Y-m-d');

    //leave days
    $leaveTypes = array(
        'Earned Leave' => 20, // Maximum 20 days of annual leave allowed
        'Sick Leave' => 10, // Maximum 10 days of sick leave allowed
        "Paternity Leave" => 20,
        'Maternity Leave' => 90, // Maximum 90 days of maternity leave allowed
        'Study Leave' => 5, // Maximum 90 days of maternity leave allowed
        // ... add other leave types here
    );

    // Calculate the number of days between the start and end dates
    $daysRequested = (strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24);

    // Check if the number of days requested is greater than the maximum allowed for this type of leave
    if($daysRequested > $leaveTypes[$type]) {
        
        // If the number of days requested exceeds the maximum, display an error message
        //$_SESSION['error-days'] = 'You can only take a maximum of' .$leaveTypes[$type] .' days of' .$type .' leave.';
        echo "<script>alert('You can only take a maximum of " . $leaveTypes[$type] . " days of " . $type . " leave.');</script>";
       
        //header('Location: ../ClientDashboard.php');
        echo "<script>window.location.replace('../ClientDashboard.php');</script>";
        exit;
    } elseif($startDate < $currentDate || $endDate < $currentDate) {
        // If the start or end date is in the past, display an error message
        //$_SESSION['error-date'] = 'Start and end date must be in the future.';
        echo "<script>alert('Start and end date must be in the future.');</script>";
        //header('Location: ../ClientDashboard.php');
        echo "<script>window.location.replace('../ClientDashboard.php');</script>";
        exit;
    } else {
      $userId = $_SESSION['userid'];
      $userName = $_SESSION['username'];
      /*The query checks the leave_application table to see if there are any rows where the employee_id,
       type_of_leave, start_date, and end_date match the values provided.

      If there is a match, it means that the user has already applied for leave for those dates,
       and the script sets an error message accordingly.

      The code binds the values of the variables $userId, $type, $startDate, and $endDate to the
       corresponding placeholders in the SQL query using the bind_param method. The method then executes
        the query using execute().

      Finally, the code fetches the results of the query using the get_result() method, which returns a mysqli_result object that can be used to retrieve the data returned by the query. */
            // Prepare the query to check if a leave application already exists for the same user and dates
      $query = 'SELECT COUNT(*) AS count FROM leave_application WHERE employee_name = ? AND type_of_leave = ? AND start_date >= ? AND end_date = ?';
      $stmt = $conn->prepare($query);
      $stmt->bind_param('isss', $userName, $type, $startDate, $endDate);
      $stmt->execute();
      $result = $stmt->get_result();

      // If the count is greater than 0, a leave application already exists for the same user and dates, display an error message
      if ($result->fetch_assoc()['count'] > 0) {
          //$_SESSION['error-duplicate'] = 'You have already submitted a leave application for the selected dates.';
          echo "<script>alert('You have already submitted a leave application for the selected dates.');</script>";
          //header('Location: ../ClientDashboard.php');
          echo "<script>window.location.replace('../ClientDashboard.php');</script>";
          exit;
      } else {

          try {
            
            // Prepare and execute the query to insert the leave application data into the database
            $query = 'INSERT INTO leave_application (employee_id,employee_name, type_of_leave, start_date, end_date) VALUES (?,?, ?, ?, ?)';
            $stmt = $conn->prepare($query);
            $stmt->bind_param('issss', $userId,$userName, $type, $startDate, $endDate);
            $stmt->execute();
    
            // If the query was successful, display a success message
            //$_SESSION['success'] = 'Your leave application has been submitted successfully.';
            echo "<script>alert('Your leave application has been submitted successfully.');</script>";
            //header('Location: ../ClientDashboard.php');
            echo "<script>window.location.replace('../ClientDashboard.php');</script>";
            exit;
          } catch (Exception $e) {
              // If the query fails, display an error message
              //$_SESSION['error'] = 'There was an error submitting your leave application.';
              echo '<script>alert("There was an error submitting - your leave application.")</script>';
              //header('Location: ../ClientDashboard.php');
              echo "<script>window.location.replace('../ClientDashboard.php');</script>";
              exit;
          }
      }
    

    }
  }

  
?>
