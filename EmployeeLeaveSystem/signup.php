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
                </div>
            </nav>
        </header>
        <!--signup form-->
        
        <form method="post" action="includes/signup.inc.php">
            <div class="loginForm">
                <h2>Sign up</h2>
                
                <input type="text" name="name" placeholder="Enter Full name here" required>

                <input type="text" name="email" placeholder="Enter your Email here" required>

                <input type="text" name="uid" placeholder="Enter username here" required>

                <select name="gender">
                    <option value="Male" >Male</option>
                    <option value="Female" >Female</option>
                </select>

                <input type="password" name="pwd" placeholder="Enter password here" required>
                <input type="password" name="pwdrepeat" placeholder="Repeat password" required>

                <button class="btn" type="submit" name="submit">Sign Up</button>
                
                
                <?php
                    if(isset($_GET["error"]))
                    {
                        if($_GET["error"] == "emptyinput"){
                            echo "<p>Fill in all fields!</p>";
                        }else if($_GET["error"] == "invaliduid"){
                            echo "<p>username already exists!</p>";
                            echo "<script>alert('username already exists!')</script>";
                        }
                        else if($_GET["error"] == "invalidemail"){
                            echo "<p>choose proper email!</p>";
                            echo "<script>alert('choose proper email!')</script>";
                        }
                        else if($_GET["error"] == "passwordsdontmatch"){
                            echo "<p>passwords doesn't match!</p>";
                        }
                        else if($_GET["error"] == "stmtfailed"){
                            echo "<p>something went wrong, try again!</p>";
                            echo "<script>alert('something went wrong, try again!')</script>";
                        }
                        else if($_GET["error"] == "usernametaken"){
                            echo "<p>username already taken!</p>";
                            echo "<script>alert('username already taken!')</script>";
                        }
                        else if($_GET["error"] == "none"){
                            echo "<p>You have signed up!</p>";
                            echo "<script>alert('You have signed up!')</script>";
                            header("location: login.php");
                        }
                    }
                ?>
            </div>
        </form>
            
    </main>
</body>
</html>