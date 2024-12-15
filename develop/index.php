<?php
    //create csv directory if it is not existed
    $dh = opendir("./");
    if($dh){
        while($file = readdir($dh)){
            $files_array[] = $file;
        }
        if (!in_array("csv", $files_array)){
            mkdir("csv");
        }
        closedir($dh);
    }


    include_once("./logic/file_handling.php");

    $c = new File("./csv");
    
    if(!$c->is_file_exist("blogs.csv")){
        $c->create_file("blogs.csv");
    }

    $all_blogs = $c->read_file("blogs.csv");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLOG</title>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/posts.css">
</head>
<body>
    <section id="main-navigation">
        <h1><a href="">TheBlog</a></h1>

        <nav>

            <?php
                session_start();
                // array_key_exists("loggedin_user_data", $_SESSION)
                if(isset($_SESSION["loggedin_user_data"])){
                    echo "<p>".$_SESSION["loggedin_user_data"][0]."</p>";
                    echo "<a href="."logic/logout.php".">Logout</a>";

                }else{
                    echo "<a href="."templates/register.php".">Register</a>";
                    echo "<a href="."templates/login.php".">Login</a>";
                }
            ?>

            <a href="templates/all_blogs.php">All blogs</a>
            <a href="templates/create_blog.php">create blog</a>
        </nav>

    </section>
    
    <section id="welcome">
        <header>
            <h2>Welcome to Blog website</h2>
        </header>
        <p>this is the website you are looking for and you can make your own blog</p>
    </section>

    <section id="latest-posts">
        
        <h2>Last Blogs</h2>

        <ul>
            <?php                
                if($c->is_file_exist("blogs.csv") and count($all_blogs) > 0){
                    //out put last 4 blogs
                    foreach(array_slice($all_blogs, -4) as $item){
                        echo <<< TEXT
                        <li>
                            <article class="post">
                                <div class="post__content">
                                    <h3>$item[1]</h3>
                                    <p>$item[2]</p>
                                    <p>Author: $item[3]</p>
                                </div>
                            </article>
                        </li>
                        TEXT;}
                }else{
                    echo "<h2>There is no blog...</h2>";
                }
            ?>

            
        </ul>



    </section>

    <section id="about">
        <h2>What I Do</h2>
        <p>I love programming, I love to help others and I enjoy exploring new thchnologies in general!</p>
        <p>My goal is to keep on growing as a developer - and if I could help tou do the same, I'd be very happy!</p>
    </section>

    
</body>
</html>