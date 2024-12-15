<?php

    class User {
        private $db;
        public function __construct() {
            $this->db = new Database();
        }

        public function register($username, $first_name, $last_name, $email, $hashed_password) {
            $this->db->insert("users", array("user_name" => $username,
                "first_name" => $first_name, "last_name" => $last_name,
                "email" => $email, "user_password" => $hashed_password));
        }


        // User Authenticat (Check Username or Email) and password for login
        function login_authentication($username_or_email, $password)
        {

            $select_query = "select id, user_name, email, user_password
                                    from users
                                    where user_name='$username_or_email' or email='$username_or_email'";

            $selected_user = $this->db->select($select_query);
            if ($selected_user) {
                $hashed_pass = $selected_user[0]["user_password"];
//                var_dump(password_verify($password, $hashed_pass));
//                echo "<br>" . $password . "<br>" . $username_or_email . "<br>";
//                echo $hashed_pass;
                if (password_verify($password, $hashed_pass)) {
                    return $selected_user[0];
                }
                return "password_err";
            }
            return "UorE_err";
        }

        // is Username and Email Existed for Register
        function is_UandE_existed(string $username, string $email){
            $select_query = "select id, user_name, email, user_password from users where user_name='$username' or email='$email'";

            $selected_user = $this->db->select($select_query);
            if($selected_user){
                return true;
            }
            return false;
        }


        public function api_get_users($blog_id){
            return $this->db->select("select users.id, users.user_name, users.first_name, users.last_name, users.email, users.user_password from users inner join likes on likes.user_id=users.id where blog_id='$blog_id'");

        }

    }