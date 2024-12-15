<?php require APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/nav.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/detail_blog.css">


<title><?php echo SITENAME; ?></title>
</head>
<body>

<?php require APPROOT . '/views/inc/navbar.php'; ?>



<section id="summary">
    <?php

    $blog = $data["post"][0];
    $tags = $data["tags"];
    $likes = $data["likes"];
//    var_dump($tags);
//    die();

    ?>

    <h2><?= $blog["title"] ?></h2>
    <div>
        <?php foreach ($tags as $tag){ ?>
            <span class="tag"><?= $tag["caption"]?> </span>
        <?php } ?>
    </div>

    <article>
        <address>By <a href="mailto:"<?= $blog["email"] ?>> <?= $blog["user_name"]?></a></address>
        <div>
            Last updated on <time><?= $blog["update_date"]?></time>
        </div>
    </article>

</section>

<main>

    <?= $blog["content"]?>

    <?= "<hr>" ?>

    <!--like form-->
<!--    return same page with post request-->
    <form class="like" action="<?= URLROOT . "/" .$_GET["url"] ?>" method="POST">
        <input type="hidden" value="<?= $blog["id"]?>" name='blog_id_onlike'>
        <button type = "submit">Like</button>
    </form>

    <p>
        <?php
        echo count($likes) . " Likes";
        ?>

    </p>
    <br>
    <a class="users_liked" href="<?= URLROOT."/api/users_liked_post/". $blog["id"] ?>">See which users have liked this post</a>
    <a class="users_liked" href="<?= URLROOT."/api/tags_post_count" ?>">See all tags with their number of specific posts</a>



</main>

<?php
//if user is logged and logged user id is equal to blog user id
if(isset($_SESSION["loggedin_user_data"])){
    if($_SESSION["loggedin_user_data"]["id"] == $blog["user_id"]){

        // assign fetched blog to session
        $_SESSION["edit_blog"] = $blog;


        $_SESSION["blog_tags"] = array();
        foreach ($tags as $tag) {
            $_SESSION["blog_tags"][] = $tag["caption"];
        }

        echo "<div class="."post_mutating".">
                    <a href=".URLROOT."/posts/edit_post".">update</a>
                    <a href=".URLROOT."/posts/delete_post".">delete</a></div>";
    }
}
?>

</section>



</body>