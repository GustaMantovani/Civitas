<?php
    session_start();
    if (isset($_SESSION["idSessao"])){
        $idLogado = $_SESSION["idSessao"];
        $tipo = $_SESSION["tipoSessao"];
        $usrLogado = $_SESSION["usrSessao"];
        $imgPerfilSessao = $_SESSION["imgSessao"];
    
        if ($tipo==1){
            header("Location:../visao/admin.php");
        }

    }else{
        header("Location:../visao/login.php");
    }
?>