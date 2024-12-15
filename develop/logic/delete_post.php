<?php

    include_once("./file_handling.php");
    $file = new File("../csv");
    $file->delete_data($_GET["id"], "blogs.csv");

    header('Location: ../templates/all_blogs.php');


?>