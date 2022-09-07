<?php
session_start();
require_once "connect.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
<script type="text/javascript">
    function Wartosc(){
    var NETTO= document.getElementById("NETTO").value;
    var VAT= document.getElementById("VAT").value;
    var wartosc = document.getElementById("wartoscC");
    var ilosc = document.getElementById("ilosc").value;
    wartosc.value = NETTO*(1+(VAT/100))*ilosc;
    setTimeout("Wartosc()",200);
    }
</script>
    <link rel="stylesheet" href="styl.css">
    <meta charset="UTF-8">
    <title>Faktury</title>
</head>
<body onload="Wartosc();">
    <header style="margin-bottom:20px"><img src='logo.png'></header>
    <div id="login"><?php echo "Jesteś zalogowany jako: $login"?></div>
    <main style = "clear:both;">

    <?php
    echo '<form action="afaktura.php" method="POST" style ="float: right; margin-top: 2px"><input type="hidden" value="'.$_POST['numerF'].'" name="numerF" ><input class="edit" type="submit" value="powrót"></form>';
    ?>
    <br><br>
    <table rules=rows >
        <tr><th>Produkt</th><th>Cena jednostkowa</th><th>%VAT</th><th>ilość</th><th>projekt</th><th>Wartość całkowita</th></tr>
    <form action="afaktura.php" method="POST">
    <?php
    echo '<input type="hidden" name="numerF" value="'.$_POST['numerF'].'">';
        if(isset($_POST['numerP'])){
            $sql ='SELECT * FROM pozycje inner join faktury on pozycje.nr_Faktury = faktury.nr_Faktury inner join projekty on projekty.id_projektu = pozycje.projekt_id inner join kontrahenci on kontrahenci.nip = projekty.klient_nip WHERE pozycje.id ='.$_POST['numerP'];
            $r = mysqli_query($con,$sql);
            while($x = mysqli_fetch_array($r)){
                echo '<tr><td><input type="text" name ="nazwaP" value="'.$x['nazwaProduktu'].'" required></td>';
                echo '<td><input type="number" name="NETTO" value="'.$x['NETTO'].'" id="NETTO" required></td>';
                echo '<td><input type="number" name="VAT" value="'.$x['VAT'].'" id="VAT" required></td>';
                echo '<td><input type="number" name="ilosc" value="'.$x['ilosc'].'" id="ilosc" required></td>';
                echo'<td><input list="projekt" name = "projekt" value="'.$_POST['projekt'].'" required>';
                $sql2 = 'SELECT * FROM projekty inner join kontrahenci on kontrahenci.nip = projekty.klient_nip';
                $r3 =mysqli_query($con, $sql2);
                echo'<datalist id="projekt" >';
                while($y = mysqli_fetch_array($r3)){
                    echo'<option value='.$y['id_projektu'].'>'.$y['nazwa'].'('.$y['Data_rozpoczecia'].', '.$y['kontrahent'].')</option>';
                }
                echo'</datalist></td>';
                echo '<td><input type="number" name="wartoscC" value="'.$x['wartosc'].'" id="wartoscC" readonly></td>';
                echo '<input type="hidden" name="editP" value="'.$_POST['numerP'].'">';
                echo '</tr>';
            }
        }
        else{
            echo '<tr><td><input type="text" name ="nazwaP"></td>';
                echo '<td><input type="number" name="NETTO" id="NETTO" required></td>';
                echo '<td><input type="number" name="VAT" id="VAT" required></td>';
                echo '<td><input type="number" name="ilosc" id= ilosc required></td>';
                echo'<td><input list="projekt" name = "projekt">';
                $sql2 = 'SELECT * FROM projekty inner join kontrahenci on kontrahenci.nip = projekty.klient_nip';
                $r3 =mysqli_query($con, $sql2);
                echo'<datalist id="projekt" >';
                while($y = mysqli_fetch_array($r3)){
                    echo'<option value='.$y['id_projektu'].'>'.$y['nazwa'].'('.$y['Data_rozpoczecia'].', '.$y['kontrahent'].')</option>';
                }
                echo'</datalist></td>';
                echo '<td><input type="number" name="wartoscC" id="wartoscC" readonly></td>';
                echo '<input type="hidden" name="addP" value="1">';
                echo '</tr>';
        }
    ?>
    
    </table>
    <br>
    <br>
    
    <input type="submit" class="edit" value="zapisz" style="float: right">
    </form>



    </main>
    
</body>
</html>
<?php
?>