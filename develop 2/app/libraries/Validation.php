<?php


trait Validation{
    public function test($var){
        $data = trim($var);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function is_empty($var){
        return empty($var);
    }


    public function is_username_valid($username){
        return (bool) preg_match("/^[a-zA-Z-' @.-_]*$/",$username);
    }

    public function is_email_valid($email){
        return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function is_input_passwords_same($pass1, $pass2){
        if($pass1 != $pass2){
            return false;
        }
        return true;
    }

    public function is_password_valid($pass1){
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