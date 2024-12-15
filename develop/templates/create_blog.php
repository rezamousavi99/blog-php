<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/nav.css">
    <link rel="stylesheet" href="../styles/create_blog.css">

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
    
    <section id="blog-form">

        <?php
        if(isset($_SESSION["loggedin_user_data"])){

            include_once("../logic/file_handling.php");
            // making auto increment id for each blog
            $file = new File("../csv");
            if(!$file->is_file_exist("blogs.csv")){
                $file->create_file("blogs.csv");
                $id = 0;
            }elseif(count($file->read_file("blogs.csv")) <= 0){
                $id = 0;
            }else{
                $data_value = $file->read_file("blogs.csv");
                $id = end($data_value)[0];
                ++$id;
            }



            $user_name = $_SESSION["loggedin_user_data"][0];

            echo <<< TEXT
            <h1>Add Blog</h1>
            <form action="../logic/createblog_logic.php" method="post">
                <input type="hidden" id="custId" name="postId" value="$id">

                <div class="form-control">
                    <label for="blog_name">Blog Name:</label>
                    <input type="text" name="blogname" maxlength="150" autofocus required id="blog_name"><br>
                </div>
                <div class="form-control">
                    <label for="id_description">Description:</label>
                    <textarea name="description" cols="40" rows="10" required id="id_description"></textarea><br>
                </div>
                <div class="form-control">
                    <input type="hidden" id="author_name" name="authorname" value="$user_name">
                </div>
                <div class="button-form">
                    <button>Submit</button>
                </div>
            </form>
            TEXT;
        }else{
            echo "<h2>you are not logged in...</h2>";
        }
        ?>
    </section>
</body>
</html>