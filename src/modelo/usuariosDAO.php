<?php

//Funções de verificação de dados na tabela do banco de dados
function verificaUsuarioTabela($conexao, $id, $usuario)
{
  $selectUsuario = "SELECT * FROM usuarios WHERE idusuario!=$id";


  $acesso = mysqli_query($conexao, $selectUsuario) or die(mysqli_error($conexao));

  $resposta = null;
  while ($registro = mysqli_fetch_assoc($acesso)) { //Seleciona uma linha da tabela e retorna uma matriz associativa. Retorna null se a linha estiver vazia

    $usuarioTabela = $registro["usuario"]; //Recebe o dado da linha da tabela apontada pelo  mysqli_fetch_assoc 

    if ($usuario == $usuarioTabela) { //Compara o dado inserido pelo usuário com os dados da tabela
      $resposta = $resposta . "Esse nome de usuário já existe.<BR>";
    }
  }

  return $resposta;
}

function verificaCpfTabela($conexao, $id, $cpf)
{
  $selectUsuario = "SELECT * FROM usuarios WHERE idusuario!=$id";


  $acesso = mysqli_query($conexao, $selectUsuario) or die(mysqli_error($conexao));

  $resposta = null;
  while ($registro = mysqli_fetch_assoc($acesso)) {


    $cpfTabela = $registro["cpf"];

    if ($cpf == $cpfTabela) {
      $resposta = $resposta . "Já há um usuário cadastrado com esse CPF.<BR>";
    }
  }

  return $resposta;
}

function verificaEmailTabela($conexao, $id, $email)
{
  $selectUsuario = "SELECT * FROM usuarios WHERE idusuario!=$id";


  $acesso = mysqli_query($conexao, $selectUsuario) or die(mysqli_error($conexao));

  $resposta = null;
  while ($registro = mysqli_fetch_assoc($acesso)) {


    $emailTabela = $registro["email"];

    if ($email == $emailTabela) {
      $resposta = $resposta . "Já há um usuário cadastrado com esse email.<BR>";
    }
  }

  return $resposta;
}


//Inserção no Banco de Dados
function cadastrarUsuario($conexao, $nome, $usuario, $email, $dtConvertida, $cpf, $senha1, $imgPerfil)
{

  $tamanhoImg = $imgPerfil["size"];
  $arqAberto = fopen($imgPerfil["tmp_name"], "r");
  $imgBin = addslashes(fread($arqAberto, $tamanhoImg));

  $insertUsuario = "INSERT INTO usuarios "
    . "(nome, usuario, email, dataNasc, cpf, senha, imgPerfil) VALUES "
    . "('$nome', '$usuario', '$email', '$dtConvertida', "
    . "'$cpf', '$senha1', '$imgBin') ";

  mysqli_query($conexao, $insertUsuario) or die(mysqli_error($conexao));

  $resposta = ("Usuário cadastrado.");


  return $resposta;
}

function alterarUsr($conexao, $id, $nome, $usuario, $email, $dtConvertida, $senha1, $imgPerfil)
{

  $tamanhoImg = $imgPerfil["size"];
  $arqAberto = fopen($imgPerfil["tmp_name"], "r");
  $imgBin = addslashes(fread($arqAberto, $tamanhoImg));

  $update = "UPDATE usuarios SET nome='$nome', usuario='$usuario', email='$email', dataNasc='$dtConvertida', senha='$senha1', imgPerfil='$imgBin' WHERE idusuario=$id";

  mysqli_query($conexao, $update) or die(mysqli_error($conexao));

  $resposta = ("Dados alterados.");
  return $resposta;
}

function alterarUsrSemImg($conexao, $id, $nome, $usuario, $email, $dtConvertida, $senha1)
{

  $update = "UPDATE usuarios SET nome='$nome', usuario='$usuario', email='$email', dataNasc='$dtConvertida', senha='$senha1' WHERE idusuario=$id";

  mysqli_query($conexao, $update) or die(mysqli_error($conexao));

  $resposta = ("Dados alterados.");
  return $resposta;
}

function pesquisarUsr($conexaoBD, $txtPesq)
{
  $sql = "SELECT * FROM usuarios WHERE usuario LIKE '$txtPesq%' AND idusuario!='1'";

  $sql = $sql . "ORDER BY usuario";

  $resultado = mysqli_query($conexaoBD, $sql) or die(mysqli_error($conexaoBD));
  return $resultado;
}

function excluirUsr($conexao, $id)
{
  $sql = "DELETE FROM usuarios WHERE idUsuario = $id";
  mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
}

function pesquisarUsrporID($conexaoBD, $id)
{
  $sql = "SELECT * FROM usuarios WHERE "
    . "idUsuario = $id";

  $resultado = mysqli_query($conexaoBD, $sql) or die(mysqli_error($conexaoBD));
  return $resultado;
}

function validarLogin($conexao, $usrLogado, $senha)
{
  $sql = "SELECT * FROM usuarios WHERE "
    . "usuario='$usrLogado' AND senha='$senha'";

  $resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
  $registro = mysqli_fetch_assoc($resultado);
  return $registro;
}

