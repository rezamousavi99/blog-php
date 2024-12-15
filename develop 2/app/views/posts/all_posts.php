<?php require APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/nav.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/all_posts.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/posts.css">


<title><?php echo SITENAME; ?></title>
</head>
<body>

<?php require APPROOT . '/views/inc/navbar.php'; ?>


    <section id="search-box">
        <form action="<?= URLROOT ?>/posts/all_posts ?>" method="GET">
            <div>
                <input type="search" placeholder="Search Blogs..." name="search_input">
                <button type="submit">Search</button>
            </div>
        </form>
    </section>



<section id="all-posts">
        <?php
            if(isset($_GET["search_input"])) {
                echo "<h1>You Searched for \" ".$_GET["search_input"]." \"</h1>";
            }else {
                echo "<h1>All Blogs</h1>";
            }
        ?>

        <ul>
            <?php
                $db = new Database();

                if(count($data['blogs']) > 0){

                    //out put all data
                    foreach($data['blogs'] as $blog){
                        $likes_count = count($db->select("select * from likes where blog_id =". $blog["id"]));
                        echo "
                        <a href=".URLROOT."/posts/post/".$blog["slug"].">
                            <li>
                                <article class='post'>
                                    <div class='post__content'>
                                        <h2>".$blog["title"]."</h2>
                                        <h3>".$blog["excerpt"]."</h3>
                                        <p>Author: ".$blog["user_name"]."</p>
                                        <p>$likes_count Likes</p>
                                        
                                    </div>
                                </article>
                            </li>
                        </a>";

                    }
                
                }else{
                    echo "<h2>There is no blog...</h2>";
                }
                

            ?>

            
        </ul>

</body>
</html>