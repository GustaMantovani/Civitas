<?php
    require_once "../modelo/conexaoBD.php";
    require_once "../modelo/interesseDAO.php";
    require_once "../controlador/trocaLivro.php";

    session_start();

    $conexao = conectarBD();
    $idUsr = $_SESSION["idSessao"];
    $lista = $_SESSION["lista"];

    foreach ( $lista as $idLivro => $livro ) {

        $resultado = verificaIdTabela($conexao, $idLivro, $idUsr);

        if($resultado){
            inserirLista ($conexao, $idUsr, $idLivro);
        } 
        removerLista($idLivro);

    }

    if(isset($_POST["idproduto"])){
        $idproduto = $_POST["idproduto"];
        header("Location:../visao/publicacao.php?idproduto=$idproduto");
    }else{
        header("Location:../visao/explorar.php");
    }
?>