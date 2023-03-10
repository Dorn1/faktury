<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="styl.css">
    <meta charset="UTF-8">
    <title>Faktury</title>
</head>
<body>
    <header style="width:100%; margin-bottom:20px"><img src='logo.png'></header>
    <main style = "clear:both;">
        <h1>Witamy w systemie archiwizacji naszej firmy!</h1>
        <form action="panel.php" method="post">
        Login:<input type="text" name="login"><br><br>
        Hasło:<input type="password" name="haslo"><br><br>
        <input type="submit" value="Zaloguj się">
        </form>
    </main>
</body>
</html>