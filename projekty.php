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
                <td><a href="panel.php">OCR</a></td><td><a href="kont.php">kontrahenci</a></td><td><a href="projekty.php">projekty</a></td><td><a href="faktury.php">faktury</a></td><td style="border-right:2px solid black"><a href="index.php"  style="color:red">wyloguj się</a></td>
            </tr>
        </table>
    </nav>
    <main>
        <h1>Lista projektów</h1>
        
        <form action="projekty.php" method="post" id="data">
        <?php
        if(isset($_POST['start']) && isset($_POST['koniec'])){
            $_SESSION['koniec'] = $_POST['koniec'];
            $_SESSION['start'] = $_POST['start'];
        }
        
        echo 'od:<input type="date" name="start" value='.$_SESSION['start'].'>';
        echo'do:<input type="date" name="koniec" value='.$_SESSION['koniec'].'>';
        
        ?>
        <input type=submit value= "zatwierdź" class="edit">
        </form>


    <table rules=rows>
        <tr>
            <th>nazwa</th><th>kontrahent</th><th>stan</th><th>Planowane zakończenie</th><th>Wartość Całkowita</th><th></th><th></th>
        </tr>

        <?php
        //usuwanie danych
        if(isset($_POST['del'])){
            $sql ='DELETE FROM projekty WHERE id_projektu ='.$_POST['id'];
            if ($con->query($sql) === TRUE) {
                echo "Pomyślnie zaktualizowano dane";
              } else {
                echo "Error updating record: " . $con->error;
              }
            unset($_POST['id']);
            unset($_POST['del']);
        }
        //edycja danych
        if(isset($_POST['edit'])){
            if(isset($_POST['koniecA'])){
            $sql = 'UPDATE projekty SET nazwa="'.$_POST['nazwa'].'", klient_nip="'.$_POST['kont'].'", Data_rozpoczecia=STR_TO_DATE("'.$_POST['startA'].'","%Y-%m-%d"), Data_zakonczenia=STR_TO_DATE("'.date("Y-m-d").'","%Y-%m-%d"), planowane_zakonczenie=STR_TO_DATE("'.$_POST['planowaneA'].'","%Y-%m-%d") WHERE id_projektu='.$_POST['edit'];
            }else{
            $sql = 'UPDATE projekty SET nazwa="'.$_POST['nazwa'].'", klient_nip="'.$_POST['kont'].'", Data_rozpoczecia=STR_TO_DATE("'.$_POST['startA'].'","%Y-%m-%d"), Data_zakonczenia=NULL, planowane_zakonczenie=STR_TO_DATE("'.$_POST['planowaneA'].'","%Y-%m-%d")  WHERE id_projektu='.$_POST['edit'];
            }
            if ($con->query($sql) === TRUE) {
                echo "Pomyślnie zaktualizowano dane";
              } else {
                echo "Error updating record: " . $con->error;
              }
            unset($_POST['edit']);
        }
        //wstawianie danych
        if(isset($_POST['add'])){
            if($_POST['koniecA']!= NULL){
            $sql = 'INSERT INTO projekty(nazwa , klient_nip, Data_rozpoczecia, Data_zakonczenia) VALUES("'.$_POST['nazwa'].'", "'.$_POST['kont'].'", STR_TO_DATE("'.$_POST['startA'].'","%Y-%m-%d"), STR_TO_DATE("'.$_POST['koniec'].'","%Y-%m-%d"))';
            }else{
            $sql = 'INSERT INTO projekty(nazwa , klient_nip, Data_rozpoczecia) VALUES( "'.$_POST['nazwa'].'", "'.$_POST['kont'].'", STR_TO_DATE("'.$_POST['startA'].'","%Y-%m-%d") )';
            }
            if ($con->query($sql) === TRUE) {
                echo "Pomyślnie zaktualizowano dane";
              } else {
                echo "Error updating record: " . $con->error;
              }
            unset($_POST['add']);
        }
        //filtrowanie danych
        if(isset($_SESSION['start']) && isset($_SESSION['koniec']) ){
            $sql='SELECT id_projektu , nazwa ,kontrahenci.kontrahent AS kont , Data_rozpoczecia , Data_zakonczenia,planowane_zakonczenie FROM projekty inner join kontrahenci on kontrahenci.nip=projekty.klient_nip WHERE Data_rozpoczecia >= STR_TO_DATE("'.$_SESSION['start'].'","%Y-%m-%d") AND '.'Data_rozpoczecia <= STR_TO_DATE("'.$_SESSION['koniec'].'","%Y-%m-%d")';
            $res = mysqli_query($con,$sql);
            while($r = mysqli_fetch_array($res)){
                echo '<tr>';
                echo '<td>'.$r['nazwa'].'</td><td>'.$r['kont'].'</td>';
                if($r['Data_zakonczenia']!= NULL){
                    echo '<td>zakończony</td>';
                }
                else{
                    echo '<td>w trakcie</td>';
                }
                echo '<td>'.$r['planowane_zakonczenie'].'</td>';
                $sql2 = 'SELECT SUM(wartosc) AS wartoscC FROM pozycje WHERE projekt_id ='.$r['id_projektu'];
                $res2= mysqli_query($con,$sql2);
                if($x=mysqli_fetch_array($res2)){
                    echo '<td>';
                    if($x['wartoscC']===NULL){
                        echo '0';
                    }
                    echo $x['wartoscC'].' zł</td>';
                }
                echo '<td><form action="aprojekt.php" method="POST"> <input type="hidden" name="id" value="'.$r['id_projektu'].'"><input type="submit" class="edit" value="edytuj"></td></form>';
                echo '<td><form action="projekty.php" method="POST"> <input type="hidden" name="id" value="'.$r['id_projektu'].'"><input type="submit" name="del" class="edit" value="usuń"></td></form>';
                echo '</tr>';
            }
            
        }
        ?>
        <tr><form action="aprojekt.php" method="POST"><td colspan="7"><input type="submit" class="edit" value="dodaj"></td></form></tr>
    </table>
    </main>
  
</body>
</html>
<?php
unset($_POST['start']);
unset($_POST['koniec']);
mysqli_close($con);
?>