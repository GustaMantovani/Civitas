<?php
    require_once '../controlador/validar.php';
    require_once "../modelo/conexaoBD.php";

    $conexao = conectarBD();

    if(isset( $_GET["coman"])){
        $id =  $_GET["idpublicacao"];
        $idproduto =  $_GET["idproduto"];
        $idUsr =  $_GET["idUsr"];
    }else{
        $id =  $_POST["idpublicacao"];
        $idproduto =  $_POST["idproduto"];
    }

    require_once "../modelo/publicacaoDAO.php";
    excluirPubli ($conexao, $id);


    if (isset( $_GET["coman"])){
        header("Location:../visao/publicacoes.php?id=$idUsr");
    }
    elseif (isset ($_POST["fromPefil"])){
        $idLogadoPerfil = $_POST["idUsr"];
        header("Location:../visao/perfil.php?id=$idLogadoPerfil");
    }
    
    else{
        header("Location:../visao/publicacao.php?idproduto=$idproduto");
    }

?>