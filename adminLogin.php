<?php
include_once 'header.php';
?>
<body>

    <main class="container">
        <header class="Banner">
            <nav class="navbar">
                <div class="navparent">
                    <img class="logo" src="images/logo/ITech.png">
                    
                    <h1>Monitor your staff leaves</h1>
                    <a href="login.php">Client Login</a>
                </div>
            </nav>
        </header>
        <!--Login form-->       
        <form method="post" action="includes/adminlogin.inc.php">
                <div class="loginForm" >
                    <h2>Login</h2>

                    <input type="text" name="uid" placeholder="Enter username here" id="username" required>

                    <input type="password" name="pwd" placeholder="Enter password here" id="password" required>

                    <button class="btn" type="submit" name="submit">Log in</button>
                    
                    <?php
                        if(isset($_GET["error"]))
                        {           
                            if($_GET["error"] == "emptyinput"){
                                echo "<p>Fill in all fields!</p>";
                            }else if($_GET["error"] == "wronglogin"){
                                echo "<p>incorrect username</p>";
                            }
                            else if($_GET["error"] == "wrong-pass"){
                                echo "<p>incorrect password</p>";
                            }     
                    }
                    ?>
                </div>
            </form>
    </main>

</body>
</html>  //ALEXANDER