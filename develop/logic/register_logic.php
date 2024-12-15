<?php

    include_once("../logic/file_handling.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $file = new File("../csv");

        // if users.csv file doesn't exist then write  headers into csv file at first line
        echo $file->is_file_exist("users.csv");
        if(!$file->is_file_exist("users.csv")){
            $file->create_file("users.csv");
            $file->write_data("users.csv", array_keys($_POST));
        }

        
        if(!$file->read_file("users.csv")){
            $file->write_data("users.csv", array_keys($_POST));
        }
        // write all data from register form if there is no same Username or Email
        $file->write_data("users.csv", $_POST);

        // Login user
        $all_users = $file->read_file("users.csv");
        foreach($all_users as $user){
            if(($_POST["username"] == $user[0]) or ($_POST["email"] == $user[3])){
                $_SESSION["loggedin_user_data"] = $user;
            }
        }

        header('Location: ../index.php');

    }

?>