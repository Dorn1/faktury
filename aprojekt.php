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
        <th>NIP</th><th>kontrahent</th>
    </tr>
    <?php
    if($_POST['nip']!="" && $_POST['kontrahent']!=""){
    echo '<tr><input type="hidden" name="nip_old" value='.$_POST['nip'].'><td><input type="text" name="nip_new" maxlength="10" value='.$_POST['nip'].'></td><td><input type="text" name="kontrahent" value='.$_POST['kontrahent'].'></td></tr>';
    }
    else{
        echo '<tr><input type="hidden" name="check" value="check"><td><input type="text" name="nip_new" maxlength="10" value='.$_POST['nip'].'></td><td><input type="text" name="kontrahent" value='.$_POST['kontrahent'].'></td></tr>';
    
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