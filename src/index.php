<?php
  session_start();
  if(empty($_SESSION["idSessao"])){
    header("Location:./visao/login.php");
  }else{
    header("Location:./visao/explorar.php");
  }
  
?>
