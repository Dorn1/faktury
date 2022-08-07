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
        <h1>Lista faktur</h1>

        <form action="faktury.php" method="post" id="data">
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
            <th>numer</th><th>kontrahent</th><th>Data wystawienia</th><th></th><th></th>
        </tr>

        <?php
            if(isset($_POST['del'])){
                $sql = 'DELETE FROM faktury WHERE nr_Faktury ="'.$_POST['numerF'].'"';
                if ($con->query($sql) === TRUE) {
                    echo "Pomyślnie zaktualizowano dane";
                  } else {
                    echo "Error updating record: " . $con->error;
                  }
                unset($_POST['numerF']);
                unset($_POST['del']);
            }


            $sql='SELECT faktury.nr_faktury AS numerF, kontrahenci.kontrahent AS kont, dataWystawienia AS dataW FROM faktury INNER JOIN kontrahenci ON faktury.nip_kontrahenta = kontrahenci.nip';
            $res = mysqli_query($con,$sql);
            while($r=mysqli_fetch_array($res)){
                echo '<tr>';
                echo '<td>'.$r['numerF'].'</td><td>'.$r['kont'].'</td><td>'.$r['dataW'].'</td>';
                echo '<td><form action="afaktura.php" method="POST"> <input type="hidden" name="numerF" value="'.$r['numerF'].'"><input type="submit" class="edit" value="edytuj"></td></form>';
                echo '<td><form action="faktury.php" method="POST"> <input type="hidden" name="numerF" value="'.$r['numerF'].'"><input type="submit" name="del" class="edit" value="usuń"></td></form>';
                
                echo '</tr>';
            }
        
        ?>
        <tr><form action="afaktura.php" method="POST"><td colspan="5"><input type="submit" class="edit" value="dodaj"></td></form></tr>
        </table>


    </main>

</body>
</html>
<?php

mysqli_close($con);
?>