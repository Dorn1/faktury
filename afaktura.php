<?php
session_start();
require_once "connect.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <style>
    </style>
    <link rel="stylesheet" href="styl.css">
    <meta charset="UTF-8">
    <title>Faktury</title>
</head>
<body>
    <header style="margin-bottom:20px"><img src='logo.png'></header>
    <div id="login"><?php echo "Jesteś zalogowany jako: $login"?></div>
    <main style = "clear:both;">
    <a href="faktury.php" style ="float: right">powrót</a>
    </main>
    
</body>
</html>
<?php
?>