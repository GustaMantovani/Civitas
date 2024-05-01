<?php

function cadLivro($conexao, $idProduto)
{ //Insere os livros na tabela 'livro'
  $insertTipo = "INSERT INTO livro "
    . "(produtocultural_idproduto) VALUES "
    . "('$idProduto')";
  mysqli_query($conexao, $insertTipo) or die(mysqli_error($conexao));
}

function excluirLivros($conexao, $idProduto)
{
  $deletLivro = "DELETE FROM livro WHERE produtocultural_idproduto = $idProduto";
  mysqli_query($conexao, $deletLivro) or die(mysqli_error($conexao));
}

