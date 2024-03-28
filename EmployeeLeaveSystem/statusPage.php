<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="Banner">
        <div class="page">
            <div class="container">
                <div class="content">
                    <div class="card">
                    
                    <br><br><br>
                    
                    <?php
                    // If the application was successful, show a success message and redirect after 5 seconds
                    if (isset($_GET['status']) && $_GET['status'] === 'success') {
                
                        echo "<script>
                                if (confirm('Leave request submitted successfully. Click OK to be redirected.')) {
                                    window.location.href = 'ClientDashboard.php';
                                }
                            </script>";
                        exit;
                    }
                    
                    // If the application was unsuccessful, show an error message and redirect after 5 seconds
                    else if (isset($_GET['status']) && $_GET['status'] === 'failed') {
                        
                        echo "<script>
                                if (confirm('Something went wrong. Click OK to go back.')) {
                                    window.location.href = 'ClientDashboard.php';
                                }
                            </script>";
                        exit;
                    }
                    ?>


                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</body>