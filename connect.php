<?php
   if(!isset($_POST['login']) && !isset($_SESSION['login'])){
       header('Location: index.php');
   }
   elseif(!isset($_POST['haslo'])&& !isset($_SESSION['haslo'])){
       header('Location: index.php');
   }
   elseif(!isset($_SESSION['login']) && !isset($_SESSION['haslo'])){
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['haslo'] = $_POST['haslo'];
   }

   $login = $_SESSION['login'];
   $haslo=$_SESSION['haslo'];
   $host="localhost";
   $db ="faktury";
   $con = @new mysqli($host,$login,$haslo,$db);
   if($con->connect_errno!=0){
       header('Location: index.php');
   }
   echo "$login<br>$haslo";
?>