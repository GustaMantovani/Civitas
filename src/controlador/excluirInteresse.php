<?php
require_once "../controlador/validar.php";
require_once "../modelo/conexaoBD.php";
require_once "../modelo/interesseDAO.php";

$conexao = conectarBD();
$idInteresse = $_GET["idInteresse"];
$idPerfil = $_SESSION["idSessao"];

$idUsr = obterIdUsrInteresse($conexao, $idInteresse);

if ($idUsr == $idPerfil) {
  excluirInteresseId($conexao, $idInteresse);

  if (isset($_GET["coman"])) {
    $idLivro = $_GET["idproduto"];
    header("Location:../visao/publicacao.php?idproduto=$idLivro");
  } else {
    header("Location:../visao/perfil.php?id=$idPerfil");
  }
}

