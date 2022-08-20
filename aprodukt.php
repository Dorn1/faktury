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

    <?php
    echo '<form action="afaktura.php" method="POST" style ="float: right; margin-top: 2px"><input type="hidden" value="'.$_POST['numerF'].'" name="numerF" ><input class="edit" type="submit" value="powrót"></form>';
    ?>
    <br><br>
    <table rules=rows >
        <tr><th>Produkt</th><th>Wartość NETTO</th><th>%VAT</th><th>ilość</th><th>projekt</th><th></th><th></th></tr>
    
    
    </table>
    



    </main>
    
</body>
</html>
<?php
?>