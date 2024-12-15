
<section id="main-navigation">
    <h1><a href="<?= URLROOT ?>">TheBlog</a></h1>

    <nav>

        <?php

        // array_key_exists("loggedin_user_data", $_SESSION)
        if(isset($_SESSION["loggedin_user_data"])){
            echo "<p>".$_SESSION["loggedin_user_data"]["user_name"]."</p>";
            echo "<a href=".URLROOT."/users/logout".">Logout</a>";

        }else{
            echo "<a href=".URLROOT."/users/register".">Register</a>";
            echo "<a href=".URLROOT."/users/login".">Login</a>";
        }
        ?>



        <a href="<?= URLROOT ?>/posts/all_posts">All posts</a>
        <a href="<?= URLROOT ?>/posts/add_post">add post</a>

        <a href="<?= URLROOT ?>/pages/about">about</a>
    </nav>

</section>
  