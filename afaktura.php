<?php
session_start();
require_once "connect.php";
if(isset($_POST['numerF'])){
    $control=2115;
}
if(isset($_POST['edit'])){
    $sql ='SELECT * FROM faktury WHERE nr_FAKTURY ="'.$_POST['numerF'].'"';
        if($con->query($sql)!=NULL){
            $sql='UPDATE faktury SET nr_Faktury ="'.$_POST['numerF'].'", nip_kontrahenta="'.$_POST['kont'].'", dataWystawienia=STR_TO_DATE("'.$_POST['data'].'","%Y-%m-%d") WHERE nr_Faktury ="'.$_POST['numer_old'].'"';
        }
        else{
            $sql='INSERT INTO faktury(nr_Faktury,nip_kontrahenta,dataWystawienia) VALUES("'.$_POST['numerF'].'","'.$_POST['kont'].'",STR_TO_DATE("'.$_POST['data'].'"","%Y-%m-%d"))';
        }
        
        $con->query($sql);
        unset($_POST['edit']);
}
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
    <table rules=rows>
        <tr><th>numer</th><th>kontrahent</th><th>Data wystawienia</th></tr>
        <tr>
        <form action='afaktura.php' method="POST">
            <input type="hidden" name="edit" value="2077">
        <?php
        if(isset($_POST['numerF'])){
            $sql = 'SELECT faktury.nr_faktury AS numerF, kontrahenci.kontrahent AS kont, dataWystawienia AS dataW, faktury.nip_kontrahenta AS nip FROM faktury INNER JOIN kontrahenci ON faktury.nip_kontrahenta = kontrahenci.nip WHERE faktury.nr_faktury = "'.$_POST['numerF'].'"';
            $r1=mysqli_query($con, $sql);
            $res= mysqli_fetch_array($r1);
            $sql = 'SELECT * FROM kontrahenci';
            $r2=mysqli_query($con, $sql);
            echo '<input type="hidden" name="numer_old" value="'.$res['numerF'].'">';
            echo '<td><input type="text" name = "numerF" value="'.$res['numerF'].'"></td>';
            echo'<td><input list="kont" name = "kont" value="'.$res['nip'].'">';
            echo'<datalist id="kont" >';
            while($x = mysqli_fetch_array($r2)){
                echo'<option value='.$x['nip'].'>'.$x['kontrahent'].'</option>';
            }
            echo'</datalist></td>';
            echo '<td><input type="date" name="data" value='.$res['dataW'].'></td>';


        }
        else{
            $sql = 'SELECT * FROM kontrahenci';
            $r2=mysqli_query($con, $sql);
            echo '<td><input type="text" name = "numerF"></td>';
            echo'<td><input list="kont" name = "kont">';
            echo'<datalist id="kont" >';
            while($x = mysqli_fetch_array($r2)){
                echo'<option value='.$x['nip'].'>'.$x['kontrahent'].'</option>';
            }
            echo'</datalist></td>';
            echo '<td><input type="date" name="data"></td>';
        }
    
    ?>
    <tr>
    </table>
    
    <br><br><br>
    <input type="submit" value="zapisz" class="edit" style="float: right">
    </form>
    <?php
    if(isset($control)){
        echo'<br><br>';

        echo'<table rules=rows>';
        echo'<tr><th>Produkt</th><th>Wartość NETTO</th><th>%VAT</th><th>ilość</th><th>projekt</th><th></th><th></th></tr>';
        echo'<tr><form action="aprodukt.php" method="POST"><td colspan="7"><input type="submit" class="edit" value="dodaj"></td><input type="hidden" name="numerF" value="'.$_POST['numerF'].'"></tr>';
        
        echo'</form></table>';
}

    ?>


    </main>
    
</body>
</html>
<?php
unset($control);
?>