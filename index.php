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
    <header></header>
    <main>
        <h1>Witamy w systemie archiwizacji faktur firmy efektor!</h1>
        <form action="panel.php" method="post">
        Login:<input type="text" name="login"><br>
        Hasło:<input type="password" name="haslo"><br>
        <input type="submit" value="Zaluguj się">
        </form>
    </main>
</body>
</html>