<?php require APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/nav.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/about.css">


<title><?php echo SITENAME; ?></title>
</head>
<body>

<?php require APPROOT . '/views/inc/navbar.php'; ?>

    <div class="about">
        <h1><?php echo $data['title']; ?></h1>
        <p><?php echo $data['description']; ?></p>
        <p>Version: <?php echo APPVERSION ?></p>
    </div>
