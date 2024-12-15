<?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        

        include_once("../logic/file_handling.php");
        // write data at the end of csv file each time
        $file = new File("../csv");

        // write headers into csv file at first line
        if(count($file->read_file("blogs.csv")) <= 0){
            $file->write_data("blogs.csv", array_keys($_POST));

        }

        // write data in csv
        $file->write_data("blogs.csv", $_POST);

    }

    header('Location: ../index.php');


?>