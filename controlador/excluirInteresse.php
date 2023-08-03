<?php
    require_once "../modelo/conexaoBD.php";
    require_once "../modelo/interesseDAO.php";

    $conexao = conectarBD();
    $idInteresse = $_GET["idInteresse"];
    session_start();
    $idPerfil = $_SESSION["idSessao"];

    excluirInteresseId ($conexao, $idInteresse);

    if(isset($_GET["coman"])){
        $idLivro = $_GET["idproduto"];
        header("Location:../visao/publicacao.php?idproduto=$idLivro");
    }else{
        header("Location:../visao/perfil.php?id=$idPerfil");
    }
    
?>