<?php
class Users extends Controller{

    use Validation;
    public function __construct(){
        $this->userModel = $this->model('User');
    }

    public function register(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Process form
            $usernameErr = $emailErr = $passwordErr = "";
            $username = $firstname = $lastname = $email = $password = "";

            // Username Validation
            if ($this->is_empty($_POST["username"])){
                $usernameErr = "Name is required";

                // check if there is no same Username or Email
            } elseif($this->userModel->is_UandE_existed($_POST["username"], $_POST["email"])){
                $usernameErr = "Username or Email is already Exist!";
                $emailErr = "Username or Email is already Exist!";
            }else {
                $username = $this->test($_POST["username"]);
                // check if name only contains letters and whitespace
                if (!$this->is_username_valid($username)) {
                    $usernameErr = "Only letters and white space and .-_ allowed";

                }
            }

            // Firstname and Lastname Validation
            if (!$this->is_empty($_POST["first_name"] or !$this->is_empty($_POST["last_name"]))){
                $firstname = $_POST["first_name"];
                $lastname = $_POST["last_name"];
            }


            // Email Validation
            if ($this->is_empty($_POST["email"])) {
                $emailErr = "Email is required";

            } else {
                $email = $this->test($_POST["email"]);
                // check if e-mail address is well-formed
                if (!$this->is_email_valid($email)){
                    $emailErr = "Invalid email format";

                }
            }

            // Password Validation
            if (!$this->is_empty($_POST["password1"]) && !$this->is_empty($_POST["password2"])) {
                $password = $_POST["password1"];
                $confirmPassword = $_POST["password2"];

                if (!$this->is_input_passwords_same($password, $confirmPassword)) {
                    $passwordErr = "Passwords are not same.\n";
                }
                elseif(!$this->is_password_valid($password)) {
                    $passwordErr = "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
                }
            } else {
                $passwordErr = "Enter password and confirm.\n";

            }



            if(!$usernameErr and !$emailErr and !$passwordErr){
                //create hash from password
                $password = $_POST['password1'];
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                //insert hashed password and other data
                $this->userModel->register($_POST["username"], $_POST["first_name"], $_POST["last_name"], $_POST["email"], $hashed_password);

                // Login user
                $user = $this->userModel->login_authentication($_POST["username"], $_POST["password1"]);

                switch ($user) {
                    case "password_err":
                        $passwordErr = "Password Incorrect!";
                        break;
                    case "UorE_err":
                        $usernameErr = "User name or Email Not Found!";
                        break;
                    default:
                        session_start();
                        $_SESSION["loggedin_user_data"] = $user;
                }

//                header('Location: '. URLROOT);
            }

            $data = [
                "username" => $username,
                "firstname" => $firstname,
                "lastname" => $lastname,
                "email" => $email,
                "password" => $password,
                "usernameErr" => $usernameErr,
                "emailErr" => $emailErr,
                "passwordErr" => $passwordErr,
            ];

            $this->view("users/register", $data);



        }else{
            // Init data
            $data = [
                "username" => "",
                "firstname" => "",
                "lastname" => "",
                "email" => "",
                "password" => "",
                "usernameErr" => "",
                "emailErr" => "",
                "passwordErr" => "",
                "is_valid" => false,
            ];

            $this->view("users/register", $data);
        }
    }

    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Process form
            $usernameErr = $passwordErr = "";
            $username = $password = "";

            if (empty($_POST["user_name"])) {
                $usernameErr = "This field is required";

            } elseif(empty($_POST["password"])) {
                $passwordErr = "password is required";

            } else {
                $username = $this->test($_POST["user_name"]);
                $password = $_POST["password"];


                $login_result = $this->userModel->login_authentication($username, $password);
                switch ($login_result) {
                    case "password_err":
                        $passwordErr = "Password Incorrect!";
                        break;
                    case "UorE_err":
                        $usernameErr = "User name or Email Not Found!";
                        break;
                    default:
                        session_start();
                        $_SESSION["loggedin_user_data"] = $login_result;
                }


            }


            if(isset($_SESSION["loggedin_user_data"])){
                header('Location: ../index.php');
            }

            $data = [
                "username" => $username,
                "password" => $password,
                "usernameErr" => $usernameErr,
                "passwordErr" => $passwordErr,
            ];
            $this->view("users/login", $data);


        }else{
            $data = [
                "username" => "",
                "password" => "",
                "usernameErr" => "",
                "passwordErr" => "",
            ];

            $this->view("users/login", $data);
        }
    }

    public function logout(){
        session_start();
        if(isset($_SESSION["loggedin_user_data"])){
            unset($_SESSION["loggedin_user_data"]);
            
        }
    
        header('Location: '.URLROOT);
    }

}



