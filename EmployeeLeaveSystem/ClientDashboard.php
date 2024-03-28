<?php
include 'header.php';

/*
// Check for error messages and display alerts if they exist
if(isset($_SESSION['error-days'])) {
    echo '<script>alert("'.$_SESSION['error-days'].'");</script>';
    unset($_SESSION['error-days']);
}
if(isset($_SESSION['error-date'])) {
    echo '<script>alert("'.$_SESSION['error-date'].'");</script>';
    unset($_SESSION['error-date']);
}
if(isset($_SESSION['error-duplicate'])) {
    echo '<script>alert("'.$_SESSION['error-duplicate'].'");</script>';
    unset($_SESSION['error-duplicate']);
}
*/
// Rest of the code for the ClientDashboard.php file
?>

<body>
    <main class="container">
        <header class="Banner">
            <nav class="navbar">
                <div class="navparent">
                    <img class="logo" src="images/logo/ITech.png">
                    <?php
                    // check if user is logged in
                    if(isset($_SESSION['userid'])) {
                        $username = $_SESSION['username'];
                        echo "<a href='#'>Welcome back,  $username!</a>";
                    }
                    ?>
                    <nav>
                        <span class="vertical-line"></span>
                        <a href="includes/logout.inc.php"> log out</a>
                    </nav>
                    
                    
                </div>
            </nav>
        </header>
        <div class="sidebar">
            <div class="brand-name">
                <h2>My Dashboard</h2>
                
            </div>
            <ul>
                <!--script.js(change the menu tabs)-->
                <li>
                    <button class="btn1" onclick="changeContent('dashboard')"><ion-icon name="albums"></ion-icon>Overview</button>
                </li>
                
                <li><button class="btn1" onclick="changeContent('applyLeave')"><ion-icon name="calendar-clear"></ion-icon>
                    ApplyLeave</button>
                </li>
                
                <li>
                    <button class="btn1" onclick="changeContent('leaveStatus')"><ion-icon name="calendar-clear"></ion-icon>
                    LeaveStatus</button>
                </li>
                
            </ul>        

        </div>
        <div class="content" id="dashboard">
                
            <div class="dashboard-wrapper">
                    
                <?php
                
                    $MaxleaveDay = 30;
                    // Retrieve the current leave balance for the user
                    $leave_balance = include 'includes/get_current_leave.inc.php';
                    if (!empty($leave_balance)) {
                        $leave_balance_days = getLeaveBalanceDays($leave_balance);
                        $MaxleaveDay = $MaxleaveDay -$leave_balance_days;
                        if($MaxleaveDay < 0){
                            $MaxleaveDay = 0;
                        }
                        $leave_type = $leave_balance[0]['type_of_leave'];
                    } else {
                        $leave_balance_days = 0;
                        $leave_type = '';
                    }


                ?>
                    <div class="card">
                    
                    <?php if (!empty($leave_type)) { ?>
                        <h2>Type of leave: <?php echo $leave_type; ?></h2>
                    <?php } ?>
                    <h2>Maximum Days: <?php
                    
                     echo $MaxleaveDay; ?></h2>
                    <h2>Days left: <?php echo $leave_balance_days; ?></h2>
                    <!--<button class="btn btn-primary" onclick="reportBack('<?php echo $leave_balance[0]['id']; ?>')" id="report-btn">Report back</button>
                    -->
                    </div>
                
            </div>
        </div>
        <div class="content" id="applyLeave">
                
            <div class="content-2">
                <!--Below we use the form.inc.php to submit the form Refer to it-->
                <form method="post" action="includes/form.inc.php" class="leave-form">
                    
                    <h1>Apply Leave</h1>
                    <br><br>
                    
                    <div class="input-field">
                        <label>Type of leave</label>

                        <select name="type">

                            <option value="Earned Leave" >Earned Leave with full pay</option>
                            <option value="Sick Leave" >Medical Leave</option>
                            <?php $gender = getGender($conn, $username);
                            print $gender?>
                            <?php if ($gender == 'Female'): ?>
                                <option value="Maternity Leave" >Maternity Leave</option>
                            <?php endif; ?>

                            <?php if ($gender == 'Male'): ?>
                                <option value="Paternity Leave">Paternity Leave</option>
                            <?php endif; ?>
                            <option value="Study Leave" >Study Leave</option>
                        
                        </select>

                    </div>
                    
                    <div class="input-field">
                        <label>Start Date</label>
                        <input type="date" name= "startDate" placeholder="enter leave date" required> 
                    </div>

                    <div class="input-field">
                        <label>Return Date</label>
                        <input type="date" name="endDate"placeholder="Enter your return date" required>
                    </div>

                    <div class="input-field">

                        <button class="btn" type="submit">Submit
                        </button>
                    </div>
                    
                    <br>

                </form>
            </div>
        </div>
        <div class="content" id="leaveStatus">
            <table class="table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // read leave applications from database using status.inc.php
                    $leave = include 'includes/get_personal_leave.inc.php';
                    if (count($leave) > 0) {
                        // iterate through all leave applications and display them in the table
                        foreach ($leave as $application) {
                            ?>
                            <tr>
                                <td><?php echo $application['type_of_leave']; ?></td>
                                <td><?php echo $application['start_date']; ?></td>
                                <td><?php echo $application['end_date']; ?></td>
                                <td><?php echo $application['status']; ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        // display message if no leave applications found
                        ?>
                        <tr>
                            <td colspan="3">No leave requested!</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

       
    </main>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>