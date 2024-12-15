<?php
    include_once("./file_handling.php");
    $file = new File("../csv");
    $file->update_data($_POST["postId"], "blogs.csv", $_POST);

    header('Location: ../templates/all_blogs.php');


// $table = fopen('../csv/blogs.csv','r');
// $temp_table = fopen('../csv/blogs_new.csv','w');


// // the name of the column you're looking for
// $post_id = $_POST["postId"];
// // echo $user_id;
//     while (($data = fgetcsv($table, 1000)) !== FALSE){
//         if(reset($data) == $post_id){ // this is if you need the first column in a row
//             fputcsv($temp_table, $_POST);
//             continue;
//         }
//         fputcsv($temp_table,$data);
//     }
//     fclose($table);
//     fclose($temp_table);
//     rename('../csv/blogs_new.csv','../csv/blogs.csv');

//     header('Location: ../templates/all_blogs.php');


?>