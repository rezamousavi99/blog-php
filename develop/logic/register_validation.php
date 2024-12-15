<?php

    class Validation{

        function is_empty($var){
            return empty($var);
        }

        function test($var){
            $data = trim($var);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        function is_username_valid($username){
            return (bool) preg_match("/^[a-zA-Z-' @.-_]*$/",$username);
        }

        function is_email_valid($email){
            return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
        }

        function is_input_passwords_same($pass1, $pass2){
            if($pass1 != $pass2){
                return false;
            }
            return true;
        }

        function is_password_valid($pass1){
            $uppercase = preg_match('@[A-Z]@', $pass1);
            $lowercase = preg_match('@[a-z]@', $pass1);
            $number    = preg_match('@[0-9]@', $pass1);
            $specialChars = preg_match('@[^\w]@', $pass1);

            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pass1) < 8){
                return false;
            }
            return true;
        }

    }

    
    $is_valid = false;
    $usernameErr = $emailErr = $passwordErr = "";
    $username = $firstname = $lastname = $email = $password = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $val = new Validation();
        
        include_once("../logic/authentication.php");
        $user_auth = new Authentication("../csv", "users.csv");

        // Username Validation
        if ($val->is_empty($_POST["username"])){
            $usernameErr = "Name is required";

            // check if there is no same Username or Email
        } elseif($user_auth->is_UandE_existed($_POST["username"], $_POST["email"])){
            $usernameErr = "Username or Email is already Exist!";
            $emailErr = "Username or Email is already Exist!";
        }else {
            $username = $val->test($_POST["username"]);
            // check if name only contains letters and whitespace
            if (!$val->is_username_valid($username)) {
            $usernameErr = "Only letters and white space and .-_ allowed";
            
            }
        }

        // Firstname and Lastname Validation
        if (!$val->is_empty($_POST["first_name"] or !$val->is_empty($_POST["last_name"]))){
            $firstname = $_POST["first_name"];
            $lastname = $_POST["last_name"];
        }


        // Email Validation
        if ($val->is_empty($_POST["email"])) {
            $emailErr = "Email is required";
            
        } else {
            $email = $val->test($_POST["email"]);
            // check if e-mail address is well-formed
            if (!$val->is_email_valid($email)){
            $emailErr = "Invalid email format";
            
            }
        }

        // Password Validation
        if (!$val->is_empty($_POST["password1"]) && !$val->is_empty($_POST["password2"])) {
            $password = $_POST["password1"];
            $confirmPassword = $_POST["password2"];

            if (!$val->is_input_passwords_same($password, $confirmPassword)) {
                $passwordErr = "Passwords are not same.\n";
            }
            elseif(!$val->is_password_valid($password)) {
                $passwordErr = "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";  
            }
        } else {
            $passwordErr = "Enter password and confirm.\n";
            
        }


        
        if(!$usernameErr and !$emailErr and !$passwordErr){
            $is_valid = true;
        }
    }

?>