<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/nav.css">
    <link rel="stylesheet" href="../styles/register.css">

</head>
<body>
    <section id="main-navigation">
        <h1><a href="../index.php">TheBlog</a></h1>

        <nav>

            <?php
                session_start();

                if(isset($_SESSION["loggedin_user_data"])){
                    echo "<p>".$_SESSION["loggedin_user_data"][0]."</p>";
                    echo "<a href="."../logic/logout.php".">Logout</a>";

                }else{
                    echo "<a href="."./register.php".">Register</a>";
                    echo "<a href="."./login.php".">Login</a>";
                }
            ?>

            <a href="all_blogs.php">All blogs</a>
            <a href="create_blog.php">create blog</a>
        </nav>

    </section>


    <section id="register_form">
        <?php 
            include_once('../logic/register_validation.php');
        ?>

        <h2>Register</h2>
        <form action="./register.php" method="POST">
        
        	<div class="form-control <?= $usernameErr ? "error" : "" ?>">
                <label for="id_username">Username:</label>
                <input type="text" name="username" maxlength="150" autofocus required aria-describedby="id_username_helptext" id="id_username" value="<?php echo $username;?>">
                <?= "<p class="."err".">$usernameErr</p>" ?>
                
            </div>
        
        	<div class="form-control ">
                <label for="id_first_name">First name:</label>
                <input type="text" name="first_name" maxlength="50" required id="id_first_name" value="<?php echo $firstname;?>">
                <p></p>
                
            </div>
        
        	<div class="form-control ">
                <label for="id_last_name">Last name:</label>
                <input type="text" name="last_name" maxlength="50" required id="id_last_name" value="<?php echo $lastname;?>">
                <p></p>
                
            </div>
        
        	<div class="form-control <?= $emailErr ? "error" : "" ?>">
                <label for="id_email">Email:</label>
                <input type="email" name="email" maxlength="320" required id="id_email" value="<?php echo $email;?>">
                <?= "<p class="."err".">$emailErr</p>" ?>
                
            </div>
        
        	<div class="form-control <?= $passwordErr ? "error" : "" ?>">
                <label for="id_password1">Password:</label>
                <input type="password" name="password1" autocomplete="new-password" required aria-describedby="id_password1_helptext" id="id_password1">
                <p><ul><li>Your password can’t be too similar to your other personal information.</li><li>Your password must contain at least 8 characters.</li><li>Your password can’t be a commonly used password.</li><li>Your password can’t be entirely numeric.</li></ul></p>
                
            </div>
        
        	<div class="form-control <?= $passwordErr ? "error" : "" ?>">
                <label for="id_password2">Password confirmation:</label>
                <input type="password" name="password2" autocomplete="new-password" required aria-describedby="id_password2_helptext" id="id_password2">
                <p>Enter the same password as before, for verification.</p>
                <?= "<p class="."err".">$passwordErr</p>" ?>
                
            </div>
        

        <button>Register</button>
        </form>

        <?php
            if($is_valid){
                include_once('../logic/register_logic.php');
            }
        ?>
    </section>
</body>
</html>