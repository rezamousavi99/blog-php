<?php
    include_once("../logic/file_handling.php");

    class Authentication{
        public $user_data;

        public function __construct($directory, $file_name) {
            $file = new File($directory);

            if(!$file->is_file_exist("users.csv")){
                $file->create_file("users.csv");
            }
            $this->user_data = $file -> read_file($file_name);
        }



        // User Authenticat (Check Username or Email and password) for login
        function login_authentication(string $username_or_email, $password){
            foreach($this->user_data as $user){
                if(($username_or_email == $user[0]) or ($username_or_email == $user[3])){
                    if($password == $user[4]){
                        return $user;
                    }
                    return "password_err";
                }
            }
            return "UorE_err";
        }

        // is Username and Email Existed for Register
        function is_UandE_existed(string $username, string $email){

            foreach($this->user_data as $user){
                if(($username == $user[0]) or ($email == $user[3])){
                    return true;
                }
            }
            return false;
        }


    }

    // $login_auth = new Authentication("../csv", "users.csv");
    // $login_result = $login_auth->login_authentication($username, $password);
    // // echo $username;
    // // echo $password;
    // echo "<pre>";
    // var_dump($login_auth->user_data);
    // echo "</pre>";

    // $user_auth = new Authentication("../csv", "users.csv");
    // var_dump($user_auth->is_UandE_existed("reza78", "df@gf.com"));
    // var_dump($user_auth->user_data);

    // echo
    // $file = new File("../csv");
    // var_dump($file -> read_file("users.csv"));


?>