<?php require APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/nav.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/add_post.css">


<title><?php echo SITENAME; ?></title>
</head>
<body>

<?php require APPROOT . '/views/inc/navbar.php'; ?>



<section id="blog-form">

    <?php

    if(isset($_SESSION["loggedin_user_data"])){

        $blog = $data["blog"];

        ?>
        <h1>Update Blog</h1>
        <form action="<?= URLROOT ?>/posts/edit_post" method="post">

            <div class="form-control">
                <label for="blog_name">Blog Name:</label>
                <input type="text" name="blogname" maxlength="150" autofocus required id="blog_name" value="<?=$blog["title"]?>"><br>
            </div>
            <div class="form-control">
                <label for="blog_excerpt">Excerpt:</label>
                <input type="text" name="blogexcerpt" maxlength="150" required id="blog_excerpt" value="<?=$blog["excerpt"]?>"><br>
            </div>
            <div class="form-control">
                <label for="id_description">Description:</label>
                <textarea name="description" cols="40" rows="10" required id="id_description"><?=$blog["content"]?></textarea><br>
            </div>
            <div class="form-control">
                <input type="hidden" id="userid" name="userid" value="<?= $data["user_id"] ?>">
            </div>
            <div class="form-control ">
                <label for="id_tags">Tags:</label>
                <select name="tags[]" id="id_tags" required multiple="">
                    <?php

                    foreach($data["tags"] as $tag){
                        $selected = "";
                        if(in_array($tag["caption"], $_SESSION["blog_tags"])){
                            $selected = "selected";
                        }
                        echo "<option value=".$tag["id"]." $selected >".$tag["caption"]."</option>";
                    }
                    ?>
                </select>

            </div>
            <div class="button-form">
                <button>Submit</button>
            </div>
        </form>


        <?php
    }else{
        echo "<h2>you are not logged in...</h2>";
    }
    ?>
</section>
</body>
</html>