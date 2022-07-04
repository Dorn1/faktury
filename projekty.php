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
        <h1>Lista projektów</h1>
        
        <form action="projekty.php" method="post" id="projekt_data">
        <?php
        if(!isset($_POST['start']) && !isset($_POST['koniec'])){
            echo 'od:<input type="date" name="start" value="1.02.2020">';
            echo'do:<input type="date" name="koniec" value="1.06.2022">';
            echo'<input type=submit value= "zatwierdź" class="edit">';
        }
        else{
            echo 'od:<input type="date" name="start" value='.$_POST['start'].'>';
            echo'do:<input type="date" name="koniec" value='.$_POST['koniec'].'>';
            echo'<input type=submit value= "zatwierdź" class="edit">';
        }
        ?>
        </form>


    <table rules=rows>
        <tr>
            <th>nazwa</th><th>kontrahent</th><th>stan</th>
        </tr>

        <?php
        if(isset($_POST['start']) && isset($_POST['koniec']) ){
            $sql='SELECT id , nazwa ,kontrahenci.kontrahent AS kont , Data_rozpoczecia , Data_zakonczenia FROM projekty inner join kontrahenci on kontrahenci.nip=projekty.klient_nip WHERE Data_rozpoczecia >= STR_TO_DATE("'.$_POST['start'].'","%Y-%m-%d") AND '.'Data_zakonczenia <= STR_TO_DATE("'.$_POST['koniec'].'","%Y-%m-%d")';
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
                echo '</tr>';
            }
        }
        ?>
    </table>
    </main>
  
</body>
</html>
<?php

mysqli_close($con);
?>