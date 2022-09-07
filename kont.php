<?php
session_start();
require_once "connect.php";

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <script src="skrypty.js">
        
    </script>
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
                <td><a href="panel.php">OCR</a></td><td><a href="kont.php">kontrahenci</a></td><td><a href="projekty.php">projekty</a></td><td><a href="faktury.php">faktury</a></td><td style="border-right:2px solid black"><a href="index.php" style="color:red">wyloguj się</a></td>
            </tr>
        </table>
    </nav>
    <main>
        <h1>Lista kontrahentów</h1>

        <form action="kont.php" method="post" id="data">
        <?php
        // wybór danych do filtrowania
        if(!isset($_POST['nipC']) && !isset($_POST['nazwaC'])){
            echo 'nip:<input type="text" name="nipC">    ';
            echo 'nazwa:<input type="text" name="nazwaC"> ';
            echo 'miasto:<input type="text" name="miastoC"> ';
            echo 'ulica:<input type="text" name="ulicaC">';
            echo' <input type=submit value= "zatwierdź" class="edit">';
        }
        else{
            echo 'nip:<input type="text" name="nipC" value='.$_POST['nipC'].'> ';
            echo'nazwa:<input type="text" name="nazwaC" value='.$_POST['nazwaC'].'> ';
            echo 'miasto:<input type="text" name="miastoC" value='.$_POST['miastoC'].'> ';
            echo 'ulica:<input type="text" name="ulicaC" value='.$_POST['ulicaC'].'>';
            echo' <input type=submit value= "zatwierdź" class="edit">';
        }
        ?>
        </form>

    <table rules=rows>
        <tr>
        <th>NIP</th><th>kontrahent</th><th>Miasto,kod pocztowy</th><th>Ulica,numer</th><th></th><th></th>
    </tr>
    <?php
        // mechanizm edycji danych
        if(isset($_POST['nip_old'])){
        $sql = 'UPDATE kontrahenci SET kontrahent = "'.$_POST['kontrahent'].'", miasto ="'.$_POST['miasto'].'", ulica="'.$_POST['ulica'].'" WHERE nip="'.$_POST['nip_old'].'"';
        
        if ($con->query($sql) === TRUE) {
            echo "Pomyślnie zaktualizowano dane";
            header('Refresh: 10; URL=kont.php');
          } else {
            echo "Error updating record: " . $con->error;
          }
          unset($_POST['nip_old']);
          unset($sql);
        }
        // mechanizm dodawania
        if(isset($_POST['check'])){
            $sql = 'INSERT INTO kontrahenci (nip, kontrahent,miasto,ulica) VALUES ("'.$_POST['nip_new'].'","'.$_POST['kontrahent'].'","'.$_POST['miasto'].'","'.$_POST['ulica'].'")';
            unset($_POST['check']);
            if ($con->query($sql) === TRUE) {
                echo "Pomyślnie dodane dane";
                header('Refresh: 10; URL=kont.php');
              } else {
                echo "Error adding record: " . $con->error;
              }
              unset($sql);
        }
        // mechanizm usuwania
        if(isset($_GET['nip'])){
            $sql = 'SELECT count(*) AS ilosc FROM faktury WHERE nip_kontrahenta ="'.$_GET['nip'].'"';
            $sql2 = 'SELECT count(*) AS ilosc FROM projekty WHERE klient_nip ="'.$_GET['nip'].'"';
            $res1 =$con->query($sql);
            $res2=$con->query($sql2);
            $ilosc=0;
            if($x = mysqli_fetch_array($res1) AND $x2 = mysqli_fetch_array($res2)){
                $ilosc = $x['ilosc']+$x2['ilosc'];
            }
            if($ilosc===0){
                $sql='DELETE FROM kontrahenci WHERE nip="'.$_GET['nip'].'"';
                if ($con->query($sql) === TRUE) {
                    echo "Pomyślnie usunięto dane";
                } else {
                    echo "Error adding record: " . $con->error;
                }
            }
            else{
                echo 'nie można usunąć kontrahenta ponieważ jest powiązany z następującą ilością projektów lub faktur w bazie: '.$ilosc;
            }
            unset($sql);
            unset($_GET['nip']);
            
            header('Refresh: 2; URL=kont.php');
        }
   
        // mechanizm filtrowania
        if(isset($_POST['nipC']) && isset($_POST['nazwaC'])){
            $res = mysqli_query($con,'Select * FROM kontrahenci WHERE nip LIKE "%'.$_POST['nipC'].'%" AND kontrahent LIKE "%'.$_POST['nazwaC'].'%" AND ulica LIKE "%'.$_POST['ulicaC'].'%" AND miasto LIKE "%'.$_POST['miastoC'].'%"');
        
        }
        else{   
        $res = mysqli_query($con,"Select * FROM kontrahenci");
        }
        // tablica danych
        while($r = mysqli_fetch_array($res)){
            echo '<tr><form action="akont.php" method="POST"><input type="hidden" name ="nip" value='.$r['nip'].'><input type="hidden" name ="kontrahent" value='.$r['kontrahent'].'>';
            echo '<td>'.$r['nip'].'</td><td>'.$r['kontrahent'].'</td>';
            echo '<td>'.$r['miasto'].'<input type="hidden" name ="miasto" value='.$r['miasto'].'></td>';
            echo '<td>'.$r['ulica'].'<input type="hidden" name ="ulica" value='.$r['ulica'].'></td>';
            echo '<td><input type ="submit" class="edit" value="edytuj"></td></form>';
            echo '<td><button type="button" onclick="usunk('.$r['nip'].')" class="edit">usuń</button></td></tr>';
        }

    ?>
    <tr>
        <td colspan="6"><form action="akont.php" method="POST"><input type="hidden" name ="nip" value=''><input type="hidden" name ="kontrahent" value=''><input type ="submit" class="edit" value="dodaj kontrahenta"></form></td>
    </tr>
    </table>
    </main>

</body>
</html>
<?php
unset($_POST['nipC']);
unset($_POST['nazwaC']);
$res->free();
mysqli_close($con);
?>