<?php
session_start();
require_once "connect.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="styl.css">
    <meta charset="UTF-8">
    <title>Faktury</title>
</head>
<body>
    <a href="panel.php">strona główna</a><a href="kont.php">kontrachenci</a><a href="projekty.php">projekty</a><a href="faktury.php">faktury</a><a href="index.php">wyloguj się</a>
    <?php

 
    mysqli_close($con);
    ?>
</body>
</html>