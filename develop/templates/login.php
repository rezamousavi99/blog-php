    <?php
        session_start();

        if(isset($_SESSION["loggedin_user_data"])){
            header('Location: ../index.php');

        }
    ?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/nav.css">
    <link rel="stylesheet" href="../styles/login.css">

</head>
<body>

    <section id="main-navigation">
        <h1><a href="../index.php">TheBlog</a></h1>

        <nav>

            <a href="register.php">Register</a>
            <a href="login.php">Login</a>


            <a href="all_blogs.php">All blogs</a>
            <a href="create_blog.php">create blog</a>
        </nav>


    </section>
    
    
    
    <section id="login-form">
    <?php
            include_once('../logic/login_validation.php');
        ?>



        <h2>Log in</h2>
        <form action="./login.php" method="POST">
            
                <div class="form-control <?= $usernameErr ? "error" : "" ?>">
                    <label for="id_user_name">Email or User name:</label>
                    <input type="text" name="user_name" maxlength="20" required id="id_user_name">
                    <?= "<p class="."err".">$usernameErr</p>" ?>
                    
                </div>
            
                <div class="form-control <?= $passwordErr ? "error" : "" ?>">
                    <label for="id_password">Password:</label>
                    <input type="password" name="password" maxlength="32" required id="id_password">
                    <?= "<p class="."err".">$passwordErr</p>" ?>

                    
                </div>
            

            <div class="button-form">
                <button>Log In</button>
            </div>
        </form>



    </section>
</body>
</html>