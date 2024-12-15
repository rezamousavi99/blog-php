<?php require APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/index.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/posts.css">

<title><?php echo SITENAME; ?></title>
</head>
<body>

<?php require APPROOT . '/views/inc/navbar.php'; ?>


<section id="welcome">
    <header>
        <h2>Welcome to Blog website</h2>
    </header>
    <p>this is the website you are looking for and you can make your own blog</p>
</section>

<section id="latest-posts">

    <h2>Last Posts</h2>

    <ul>
        <?php

    //    include_once(APPROOT."/libraries/Database.php");
    //    //fetch last 4 blogs
       $db = new Database();


       if(count($data['blogs']) > 0){
           foreach($data['blogs'] as $blog){
               $likes_count = count($db->select("select * from likes where blog_id =". $blog["id"]));
               echo <<< TEXT
                       <li>
                           <article class="post">
                               <div class="post__content">
                                   <h3>$blog[title]</h3>
                                   <p>$blog[excerpt]</p>
                                   <p>Author: $blog[user_name]</p>
                                   <p>$likes_count Likes</p>
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



<?php require APPROOT . '/views/inc/footer.php'; ?>
