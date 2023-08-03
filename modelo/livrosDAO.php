<?php

    function cadLivro ($conexao, $idProduto){ //Insere os livros na tabela 'livro'
        $insertTipo = "INSERT INTO livro "
            . "(produtoCultural_idproduto) VALUES "
            . "('$idProduto')";
        mysqli_query($conexao,$insertTipo) or die ( mysqli_error($conexao) );
    }

    function excluirLivros ($conexao, $idProduto){
        $deletLivro = "DELETE FROM livro WHERE produtoCultural_idproduto = $idProduto";
        mysqli_query($conexao,$deletLivro ) or die ( mysqli_error($conexao) );
    }

?>