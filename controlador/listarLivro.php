<?php
    require_once '../controlador/trocaLivro.php';

    // ADICIONAR
    if ( isset($_GET["addIdLivro"]) ) {
        $idLivro = $_GET["addIdLivro"];
        $nome = $_GET["nome"];
        $autor = $_GET["autor"];
        
        addLista($idLivro, $nome, $autor);
    }

    // REMOVER
    if ( isset($_GET["delIdLivro"]) ) {
        $idLivro = $_GET["delIdLivro"];
        
        removerLista($idLivro);
    }

?>