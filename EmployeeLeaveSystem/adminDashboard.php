<?php
include 'header.php';
?>
<body>
    <main class="container">
        <header class="Banner">
                <nav class="navbar">
                    <div class="navparent">
                        <img class="logo" src="images/logo/ITech.png">
                        <nav>
                            <span class="vertical-line"></span>
                            <a href="includes/adminlogout.inc.php"> log out</a>
                        </nav>
                        <h1>Admin Dashboard</h1>
                        <?php
                            // check if user is logged in
                            if(isset($_SESSION['userid'])) {
                                $username = $_SESSION['userid'];
                                echo "<a href='#'>Welcome back $username!</a>";
                            }
                        ?>
                    </div>
                </nav>
        </header>
        <div class="sidebar">
            <div class="brand-name">
                <h1>Admin</h1>
            </div>
            <ul>
                <li>
                    
                    <button class="btn1" onclick="changeContent('dashboard')">

                     Dashboard</button>
                </li>
                <span class="baseline"></span>
                <li>
                    <button class="btn1" onclick="changeContent('leaveRequest')">
                    
                    Leave Requests</button>
                </li>
                <span class="baseline"></span>
                <li>

                    <button class="btn1" onclick="changeContent('employeesOnleave')">
                    
                    Employees On Leave</button>
                </li>
                <span class="baseline"></span>
                
            </ul>        

        </div>
        <div class="content" id="dashboard">
            <div class="dashboard-wrapper">
                <div class="card">
                    <h1>24</h1>
                    <br>
                    <h3>Employees on leave</h3>
                    
                </div>   
            </div>
        </div>
        <div class="content" id="leaveRequest">
                
            
                <table class="table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Employee Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include 'includes/leaveRetriever.inc.php';
                            
                            if (!empty($leaves)) {
                                foreach ($leaves as $leave) {
                                    echo '<tr>';
                                    echo '<td>' . htmlspecialchars($leave['type_of_leave']) . '</td>';
                                    echo '<td>' . htmlspecialchars($leave['employee_name']) . '</td>';
                                    echo '<td>' . htmlspecialchars($leave['start_date']) . '</td>';
                                    echo '<td>' . htmlspecialchars($leave['end_date']) . '</td>';
                                    echo '<td>' . htmlspecialchars($leave['status']) . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="3">No leave requested.</td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
            
        </div> 

        
    </main>
</body>
</html>