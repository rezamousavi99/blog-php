<?php require APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/nav.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/login.css">


<title><?php echo SITENAME; ?></title>
</head>
<body>

<?php require APPROOT . '/views/inc/navbar.php'; ?>




<?php
//    session_start();
//
//    if(isset($_SESSION["loggedin_user_data"])){
//        header('Location: ../index.php');
//
//    }
?>

    <section id="login-form">
    <?php
//    include_once('../logic/login_validation.php');
    ?>

        <h2>Log in</h2>
        <form action="<?= URLROOT ?>/users/login" method="POST">

                <div class="form-control <?= $data["usernameErr"] ? "error" : ""; ?>">
                    <label for="id_user_name">Email or User name: <sup>*</sup></label>
                    <input type="text" name="user_name" maxlength="20" required id="id_user_name">
                    <?= "<p class="."err".">". $data["usernameErr"] ."</p>" ?>

                </div>

                <div class="form-control <?= $data["passwordErr"] ? "error" : "" ?>">
                    <label for="id_password">Password: <sup>*</sup></label>
                    <input type="password" name="password" maxlength="32" required id="id_password">
                    <?= "<p class="."err".">".$data["passwordErr"] ."</p>" ?>


                </div>


            <div class="button-form">
                <button>Log In</button>
            </div>
        </form>



    </section>
</body>
</html>