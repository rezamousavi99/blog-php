<?php require APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/nav.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/register.css">


<title><?php echo SITENAME; ?></title>
</head>
<body>

<?php require APPROOT . '/views/inc/navbar.php'; ?>



<?php
//    session_start();

    if(isset($_SESSION["loggedin_user_data"])){
        header('Location: '. URLROOT);

    }
?>

    <section id="register_form">

        <h2>Register</h2>
        <form action="<?= URLROOT ?>/users/register" method="POST">

        	<div class="form-control <?= $data["usernameErr"] ? "error" : "" ?>">
                <label for="id_username">Username: <sup>*</sup></label>
                <input type="text" name="username" maxlength="150" autofocus required aria-describedby="id_username_helptext" id="id_username" value="<?php echo $data["username"];?>">
                <?= "<p class="."err".">". $data["usernameErr"] ."</p>" ?>

            </div>

        	<div class="form-control ">
                <label for="id_first_name">First name: <sup>*</sup></label>
                <input type="text" name="first_name" maxlength="50" required id="id_first_name" value="<?php echo $data["firstname"];?>">
                <p></p>

            </div>

        	<div class="form-control ">
                <label for="id_last_name">Last name: <sup>*</sup></label>
                <input type="text" name="last_name" maxlength="50" required id="id_last_name" value="<?php echo $data["lastname"];?>">
                <p></p>

            </div>

        	<div class="form-control <?= $data["emailErr"] ? "error" : "" ?>">
                <label for="id_email">Email: <sup>*</sup></label>
                <input type="email" name="email" maxlength="320" required id="id_email" value="<?php echo $data["email"] ;?>">
                <?= "<p class="."err".">". $data["emailErr"] ."</p>" ?>

            </div>

        	<div class="form-control <?= $data["passwordErr"] ? "error" : "" ?>">
                <label for="id_password1">Password: <sup>*</sup></label>
                <input type="password" name="password1" autocomplete="new-password" required aria-describedby="id_password1_helptext" id="id_password1">
                <p><ul><li>Your password can’t be too similar to your other personal information.</li><li>Your password must contain at least 8 characters.</li><li>Your password can’t be a commonly used password.</li><li>Your password can’t be entirely numeric.</li></ul></p>

            </div>

        	<div class="form-control <?= $data["passwordErr"] ? "error" : "" ?>">
                <label for="id_password2">Password confirmation: <sup>*</sup></label>
                <input type="password" name="password2" autocomplete="new-password" required aria-describedby="id_password2_helptext" id="id_password2">
                <p>Enter the same password as before, for verification.</p>
                <?= "<p class="."err".">". $data["passwordErr"] ."</p>" ?>

            </div>


        <button>Register</button>
        </form>

    </section>
</body>
</html>