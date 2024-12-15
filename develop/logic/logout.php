<?php
    session_start();
    unset($_SESSION["loggedin_user_data"]);

    header('Location: ../index.php');

?>