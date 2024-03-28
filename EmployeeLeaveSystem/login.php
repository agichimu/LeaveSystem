<?php
include_once 'header.php';
?>
<body>

    <main class="container">
        <header class="Banner">
            <nav class="navbar">
                <div class="navparent">
                    <img class="logo" src="images/logo/ITech.png">
                    <h1>Apply for Your Leave</h1>
                    <a href="adminLogin.php">Admin login</a>
                </div>
            </nav>
        </header>
        <!--Login form-->       
        <form method="post" action="includes/login.inc.php">
                <div class="loginForm" >
                    <h2>Login</h2>

                    <input type="text" name="uid" placeholder="Enter username here" id="username" required>

                    <input type="password" name="pwd" placeholder="Enter password here" id="password" required>
                    <span>

                        <ion-icon name="eye-off" id="eye" style="font-size: 23px;" onclick="showPassword()"></ion-icon>
                    </span>
                    <button class="btn" type="submit" name="submit">Log in</button>
                    
                    <button class="btn" onclick="goToPage('signup.php')" type="">Sign Up</button>
                    <?php
                        if(isset($_GET["error"]))
                        {           
                            if($_GET["error"] == "emptyinput"){
                                echo "<p>Fill in all fields!<p>";
                            }else if($_GET["error"] == "checkpassword"){
                                echo "<p>Wrong Password or username !</p>";
                            }
                            
                        }
                    ?>
                </div>
            </form>
    </main>

</body>
</html>               
            
       