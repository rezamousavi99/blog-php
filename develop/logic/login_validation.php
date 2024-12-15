<?php

    // define variables and set to empty values
    $usernameErr = $passwordErr = "";
    $username = $password = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        include_once("../logic/authentication.php");

        $login_auth = new Authentication("../csv", "users.csv");
        

        if (empty($_POST["user_name"])) {
            $usernameErr = "This field is required";

        } elseif(empty($_POST["password"])) {
            $passwordErr = "password is required";

        } else {
            $username = test_input($_POST["user_name"]);
            $password = $_POST["password"];

            $login_result = $login_auth->login_authentication($username, $password);
            switch ($login_result) {
                case "password_err":
                    $passwordErr = "Password Incorrect!";
                    break;
                case "UorE_err":
                    $usernameErr = "User name or Email Not Found!";
                    break;
                default:
                    $_SESSION["loggedin_user_data"] = $login_result;
              }

            
        }
        

        if(isset($_SESSION["loggedin_user_data"])){
            header('Location: ../index.php');
        }

    }

    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }

?>