<?php
session_start();
require_once "connect.php";
if(isset($_POST['numerP'])){
    $sql='DELETE FROM pozycje WHERE id='.$_POST['numerP'];
    unest($_POST['numerP']);
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
if(isset($_POST['editP'])){
    $sql='UPDATE pozycje SET nr_Faktury="'.$_POST['numerF'].'", nazwaProduktu="'.$_POST['nazwaP'].'", NETTO='.$_POST['NETTO'].', VAT='.$_POST['VAT'].', ilosc='.$_POST['ilosc'].', wartosc='.$_POST['wartoscC'].', projekt_id='.$_POST['projekt'].' WHERE id='.$_POST['editP'];
    if ($con->query($sql) === TRUE) {
        unset($sql);
      } 
}
elseif(isset($_POST['addP'])){
    $sql ='INSERT INTO pozycje(nr_Faktury, nazwaProduktu, NETTO, VAT, ilosc, wartosc, projekt_id) VALUES ("'.$_POST['numerF'].'", "'.$_POST['nazwaP'].'", "'.$_POST['NETTO'].'","'.$_POST['VAT'].'","'.$_POST['ilosc'].'","'.$_POST['wartoscC'].'","'.$_POST['projekt'].'")';
    
    if ($con->query($sql) === TRUE) {
        unset($sql);
      }
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
    if(isset($_POST['numerF'])){
        echo'<br><br>';

        echo'<table rules=rows>';
        echo'<tr><th>Produkt</th><th>Wartość NETTO</th><th>%VAT</th><th>ilość</th><th>projekt</th><th>Wartość całkowita</th><th></th><th></th></tr>';
        $sql ='SELECT * FROM pozycje inner join projekty on projekty.id = pozycje.projekt_id inner join kontrahenci on projekty.klient_nip = kontrahenci.nip WHERE nr_Faktury ="'.$_POST['numerF'].'"';
        $r=mysqli_query($con, $sql);
        while($x = mysqli_fetch_array($r)){
            echo '<tr><td>'.$x['nazwaProduktu'].'</td><td>'.$x['NETTO'].'</td><td>'.$x['VAT'].'</td><td>'.$x['ilosc'].'</td><td>'.$x['nazwa'].'('.$x['Data_rozpoczecia'].', '.$x['kontrahent'].')</td><td>'.$x['wartosc'].'</td><td><form action="aprodukt.php" method="POST"><input type="hidden" name ="projekt" value="'.$x['projekt_id'].'"><input type="hidden" name="numerP" value="'.$x['id'].'"><input type="hidden" name="numerF" value="'.$_POST['numerF'].'"><input type="submit" class="edit" value="edytuj"></form></td><td><form action="afaktura" method="POST"><input type="hidden" name="numerF" value="'.$_POST['numerF'].'"><input type="hidden" name="numerP" value="'.$x['id'].'"><input type="submit" class="edit" value="usuń"></form></td></tr>';    
        }
        echo'<tr><form action="aprodukt.php" method="POST"><td colspan="8"><input type="submit" class="edit" value="dodaj"></td><input type="hidden" name="numerF" value="'.$_POST['numerF'].'"></tr>';
        
        echo'</form></table>';
        unset($_POST['numerF']);
}

    ?>


    </main>
    
</body>
</html>