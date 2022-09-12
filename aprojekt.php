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
        <th>nazwa</th><th>kontrahent</th><th>początek</th><th>planowane zakończenie</th>
    <?php
    $sql2='SELECT * FROM kontrahenci';
    $r2=mysqli_query($con, $sql2);
    if(isset($_POST['id'])){
        echo'<th>zakończony</th></tr>';
    $sql='SELECT id_projektu , nazwa ,kontrahenci.kontrahent AS kont ,kontrahenci.nip AS nip, Data_rozpoczecia , Data_zakonczenia, planowane_zakonczenie FROM projekty inner join kontrahenci on kontrahenci.nip=projekty.klient_nip WHERE id_projektu='.$_POST['id'];
    $r1=mysqli_query($con, $sql);
    $res= mysqli_fetch_array($r1);
    echo'<tr><td><input type="hidden" name="edit" value="'.$res['id_projektu'].'">';
    echo'<input type="text" name="nazwa" value='.$res['nazwa'].' required></td>';
    echo'<td><input list="kont" name = "kont" value="'.$res['nip'].'" required>';
    echo'<datalist id="kont" >';
    while($x = mysqli_fetch_array($r2)){
            echo'<option value='.$x['nip'].'>'.$x['kontrahent'].'</option>';
        }
    echo'</datalist></td>';
    echo '<td><input type="date" name="startA" value="'.$res['Data_rozpoczecia'].'" required></td>';
    echo '<td><input type="date" name="planowaneA" value="'.$res['planowane_zakonczenie'].'" required></td>';
    
    if($res['Data_zakonczenia'] == NULL){
    echo '<td><input type="checkbox" name="koniecA"></td>';
    }
    else{
    echo '<td><input type="checkbox" name="koniecA"checked></td>';
    }
    echo'</tr>';
    }
    else{
        echo'<tr><td><input type="hidden" name="add" value="dodaj" required>';
        echo '<input type="text" name="nazwa"  required></td>';
        echo'<td><input list="kont" name = "kont">';
        echo'<datalist id="kont" >';
        while($x = mysqli_fetch_array($r2)){
                echo'<option value='.$x['nip'].'>'.$x['kontrahent'].'</option>';
            }
        echo'</datalist></td>';
    echo '<td><input type="date" name="startA" required></td>';
    echo '<td><input type="date" name="planowaneA" required></td>';
    
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