<?php
    require_once '../controlador/validar.php';
    require_once "../modelo/conexaoBD.php";
    require_once "../modelo/interesseDAO.php";
    require_once "../controlador/trocaLivro.php";

    $conexao = conectarBD();

    foreach ( $lista as $idLivro => $livro ) {

        $resultado = verificaIdTabela($conexao, $idLivro, $idLogado);

        if($resultado){
            inserirLista ($conexao, $idLogado, $idLivro);
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