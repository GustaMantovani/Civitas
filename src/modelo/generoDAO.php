<?php

function comboGenero($conexao, $generoMarcado)
{ //Função de acesso à tabela 'genero'
  $selectGenero = "SELECT * FROM generoproduto";

  $acesso = mysqli_query($conexao, $selectGenero) or die(mysqli_error($conexao));

  $resposta = null;
  while ($registro = mysqli_fetch_assoc($acesso)) { //Acessa cada linha da tabela
    $idGenero  = $registro["idgeneroproduto"];
    $genero  = $registro["genero"];

    if ($idGenero == $generoMarcado) {
      $resposta = $resposta . "<OPTION selected value='$idGenero'>$genero</OPTION>"; //Imprime o gênero acossiado ao seu ID
    } else {
      $resposta = $resposta . "<OPTION value='$idGenero'>$genero</OPTION>";
    }
  }
  return $resposta;
}

function pesquisarGeneroPorID($conexao, $idGenero)
{
  $sql = "SELECT * FROM generoproduto WHERE idgeneroproduto = $idGenero";

  $resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
  return $resultado;
}

