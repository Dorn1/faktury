<?php
session_start();
require_once "connect.php";
$_SESSION['koniec'] = date('Y-m-d') ;
$_SESSION['start'] = date('2022-01-01') ;
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="styl.css">
    <meta charset="UTF-8">
    <title>Faktury</title>
</head>
<body>
    <header><img src='logo.png'></header>
    <div id="login"><?php echo "Jesteś zalogowany jako: $login"?></div>
    <nav>
        <table id="nav">
            <tr>
                <td><a href="panel.php">OCR</a></td><td><a href="kont.php">kontrahenci</a></td><td><a href="projekty.php">projekty</a></td><td><a href="faktury.php">faktury</a></td><td style="border-right:2px solid black"><a href="index.php"  style="color:red">wyloguj się</a></td>
            </tr>
        </table>
    </nav>
    <main>
        SYSTEM OCR już w krótce
    </main>

</body>
</html>
<?php
mysqli_close($con);
?>