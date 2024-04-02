<?php

session_start();

function addLista($idLivro, $nome, $autor) {
    $novo = array( $idLivro => array(
                                    "nome" => $nome,
                                    "autor" => $autor,
                                 )
                 );
    $_SESSION["lista"] = $_SESSION["lista"] + $novo;
    header("Location:../visao/publicacao.php?idproduto=$idLivro");
}

function removerLista($idLivro) {
    unset($_SESSION["lista"][$idLivro]);
    header("Location:../visao/lista.php");
}

?>