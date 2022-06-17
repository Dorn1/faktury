<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Faktury</title>
</head>
<body>
    <form action="panel.php" method="post">
        Login:<input type="text" name="login"><br>
        Hasło:<input type="password" name="haslo"><br>
        <input type="submit" value="Zaluguj się">
    </form>
</body>
</html>