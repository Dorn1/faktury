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
    <a href="kont.php" style ="float: right">powrót</a>
    <form action=kont.php method="POST">
    <table rules=rows>
    <tr>
        <th>NIP</th><th>kontrahent</th><th>Miasto,kod pocztowy</th><th>Ulica,numer</th>
    </tr>
    <?php
    if($_POST['nip']!=""){
    echo '<tr><input type="hidden" name="nip_old" value='.$_POST['nip'].'><td>'.$_POST['nip'].'</td><td><input type="text" name="kontrahent" value='.$_POST['kontrahent'].'></td><td><input type="text" name="miasto" value="'.$_POST['miasto'].'"></td><td><input type="text" name="ulica" value="'.$_POST['ulica'].'"></td></tr>';
    }
    else{
        echo '<tr><input type="hidden" name="check" value="check"><td><input type="text" name="nip_new" maxlength="10"></td><td><input type="text" name="kontrahent" ></td><td><input type="text" name="miasto"></td><td><input type="text" name="ulica"></td></tr>';
    
    }
    ?>
    </table>
    <br><br>
    <input type="submit" value="zapisz" class="edit" style="float: right">
    </form>
    </main>

</body>
</html>
<?php
mysqli_close($con);
?>