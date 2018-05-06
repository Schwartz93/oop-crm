<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CMS</title>

    <link rel="stylesheet" href="<?php echo BASE_URL?>/css/main.css">
</head>
<body>
    <div class="wrapper">
    <?php if(basename($_SERVER['PHP_SELF']) === 'page.php'): ?>
        <h1><a href="admin/list.php">My CMS</a></h1>
        <span><a href="../../index.php" class="home">HEIMWÄRTS</a></span>

        <?php elseif(basename($_SERVER['PHP_SELF']) === 'list.php'): ?>
            <h1><a href="">My CMS</a></h1>
            <span><a href="../../index.php" class="home">HEIMWÄRTS</a></span>

        <?php elseif(basename($_SERVER['PHP_SELF']) === 'add.php'): ?>
            <h1><a href="list.php">My CMS</a></h1>
            <span><a href="../../../index.php" class="home">HEIMWÄRTS</a></span>
    <?php endif; ?>