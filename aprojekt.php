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
    <a href="projekty.php" style ="float: right">powrót</a>
    <form action="projekty.php" method="POST">
    <table rules=rows>
    <tr>
        <th>nazwa</th><th>kontrahent</th><th>początek</th><th>koniec</th>
    </tr>
    <?php
    $sql2='SELECT * FROM kontrahenci';
    $r2=mysqli_query($con, $sql2);
    if(isset($_POST['id'])){
    $sql='SELECT id , nazwa ,kontrahenci.kontrahent AS kont , Data_rozpoczecia , Data_zakonczenia FROM projekty inner join kontrahenci on kontrahenci.nip=projekty.klient_nip WHERE id='.$_POST['id'];
    $r1=mysqli_query($con, $sql);
    $res= mysqli_fetch_array($r1);
    echo'<tr><td><input type="hidden" name="edit" value="'.$res['id'].'"><input type="text" name="nazwa" value='.$res['nazwa'].'></td>';
    echo'<td><select name="kont">';
    while($x = mysqli_fetch_array($r2)){
            echo'<option value='.$x['nip'].'>'.$x['kontrahent'].'</option>';
        }
    echo'</select></td>';
    echo '<td><input type="date" name="start" value="'.$res['Data_rozpoczecia'].'"></td>';
    echo '<td><input type="date" name="koniec" value="'.$res['Data_zakonczenia'].'"></td>';
    echo'</tr>';
    }
    else{
        echo'<tr><td><input type="hidden" name="add" value="dodaj"><input type="text" name="nazwa" value=></td>';
        echo'<td><select name="kont">';
    while($x = mysqli_fetch_array($r2)){
            echo'<option value='.$x['nip'].'>'.$x['kontrahent'].'</option>';
        }
    echo'</select></td>';
    echo '<td><input type="date" name="start" value=""></td>';
    echo '<td><input type="date" name="koniec" value=""></td>';
    echo'</tr>';
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
if(isset($r1)){
$r1->free();
}
if(isset($r2)){
$r2->free();}
mysqli_close($con);
?>