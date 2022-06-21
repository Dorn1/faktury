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
    <header><img src='logo.png'></header>
    <div id="login"><?php echo "Jesteś zalogowany jako: $login"?></div>
    <nav>
        <table id="nav">
            <tr>
                <td><a href="panel.php">OCR</a></td><td><a href="kont.php">kontrahenci</a></td><td><a href="projekty.php">projekty</a></td><td><a href="faktury.php">faktury</a></td><td style="border-right:2px solid black"><a href="index.php">wyloguj się</a></td>
            </tr>
        </table>
    </nav>
    <main>
        <h1>Lista kontrahentów</h1>
    <table rules=rows>
        <tr>
        <th>NIP</th><th>kontrahent</th>
    </tr>
    <?php
        $res = mysqli_query($con,"Select * FROM kontrahenci");
        while($r = mysqli_fetch_array($res)){
            echo"<tr>";
            echo '<td>'.$r['nip'].'</td><td>'.$r['kontrahent'].'</td>';
            echo"</tr>";
        }

    ?>
    <tr>
        <td colspan="2"><button>Dodaj kontrachenta</button></td>
    </tr>
    </table>
    </main>

</body>
</html>
<?php
$res->free();
mysqli_close($con);
?>