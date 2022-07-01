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
                <td><a href="panel.php">OCR</a></td><td><a href="kont.php">kontrahenci</a></td><td><a href="projekty.php">projekty</a></td><td><a href="faktury.php">faktury</a></td><td style="border-right:2px solid black"><a href="index.php">wyloguj się</a></td>
            </tr>
        </table>
    </nav>
    <main>
        <h1>Lista kontrahentów</h1>
    <table rules=rows>
        <tr>
        <th>NIP</th><th>kontrahent</th><th></th><th></th>
    </tr>
    <?php
        if(isset($_POST['nip_old'])){
        $sql = 'UPDATE kontrahenci SET nip="'.$_POST['nip_new'].'" , kontrahent = "'.$_POST['kontrahent'].'" WHERE kontrahenci.nip="'.$_POST['nip_old'].'"';
        unset($_POST['nip_old']);
        if ($con->query($sql) === TRUE) {
            echo "Pomyślnie zaktualizowano dane";
            header('Refresh: 2; URL=kont.php');
          } else {
            echo "Error updating record: " . $con->error;
          }
          unset($sql);
        }
        if(isset($_POST['check'])){
            $sql = 'INSERT INTO kontrahenci (nip, kontrahent) VALUES ("'.$_POST['nip_new'].'","'.$_POST['kontrahent'].'")';
            unset($_POST['check']);
            if ($con->query($sql) === TRUE) {
                echo "Pomyślnie dodane dane";
                header('Refresh: 2; URL=kont.php');
              } else {
                echo "Error adding record: " . $con->error;
              }
              unset($sql);
        }
        if(isset($_GET['nip'])){
            $sql="DELETE FROM kontrahenci WHERE nip=".$_GET['nip'];
            if ($con->query($sql) === TRUE) {
                echo "Pomyślnie usunięto dane";
                header('Refresh: 2; URL=kont.php');
              } else {
                echo "Error adding record: " . $con->error;
              }
              unset($sql);
            unset($_GET['nip']);
        }
   
        $res = mysqli_query($con,"Select * FROM kontrahenci");
        while($r = mysqli_fetch_array($res)){
            echo'<tr><form action="akont.php" method="POST"><input type="hidden" name ="nip" value='.$r['nip'].'><input type="hidden" name ="kontrahent" value='.$r['kontrahent'].'>';
            echo '<td>'.$r['nip'].'</td><td>'.$r['kontrahent'].'</td><td><input type ="submit" class="edit" value="edytuj"></td>';
            echo'</form><td><button type="button" onclick="usunk('.$r['nip'].')">usuń</button></td></tr>';
        }

    ?>
    <tr>
        <td colspan="4"><form action="akont.php" method="POST"><input type="hidden" name ="nip" value=''><input type="hidden" name ="kontrahent" value=''><input type ="submit" class="edit" value="dodaj kontrahenta"></form></td>
    </tr>
    </table>
    </main>

</body>
</html>
<?php
$res->free();
mysqli_close($con);
?>