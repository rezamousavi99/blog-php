<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/nav.css">
    <link rel="stylesheet" href="../styles/posts.css">
    <link rel="stylesheet" href="../styles/all_blogs.css">

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



<section id="all-posts">
        <h2>All Blogs</h2>

        <ul>
            <?php
                include_once("../logic/file_handling.php");
                $file = new File("../csv");

                if(!$file->is_file_exist("blogs.csv")){
                    $all_blogs = $file->create_file("blogs.csv");
                }

                $all_blogs = $file->read_file("blogs.csv");


                if(count($all_blogs) > 0){
                    //out put all data
                    foreach($all_blogs as $blog){
                        echo <<< TEXT
                        <li>
                            <article class="post">
                                <div class="post__content">
                                    <h3>$blog[1]</h3>
                                    <p>$blog[2]</p>
                                    <p>Author: $blog[3]</p>
                                </div>
                                
                        TEXT;
                        

                        if(isset($_SESSION["loggedin_user_data"])){
                            if($_SESSION["loggedin_user_data"][0] == $blog[3]){

                                echo "<div class="."post_mutating".">
                                <a href="."./update_post.php?id="."$blog[0]".">update</a>
                                <a href="."../logic/delete_post.php?id="."$blog[0]".">delete</a></div>";
                            }
                        }
                        
                        echo "</article></li>";
                    }
                
                }else{
                    echo "<h2>There is no blog...</h2>";
                }
                

            ?>

            
        </ul>

</body>
</html>