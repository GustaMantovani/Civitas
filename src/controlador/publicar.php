<?php
require_once '../controlador/validar.php';
require_once 'funcoes.php';
$temaPubli = $_POST["txtTemaPubli"];
$comentario =  $_POST["txtComentario"];
$avaliacao = $_POST["avaliacao"];

if ($avaliacao == null) {
  $avaliacao = 0;
}

$dataPubli = $_POST["dataPubli"];
$idproduto = $_POST["idproduto"];

require_once '../modelo/conexaoBD.php';

$conexao = conectarBD();

require_once '../modelo/publicacaoDAO.php';

if ($comentario != "" && $temaPubli != "") {
  $msgErro = cadPublicacao($conexao, $dataPubli, $temaPubli, $comentario, $avaliacao, $idproduto, $idLogado);
  header("Location:../visao/publicacao.php?idproduto=$idproduto&&msgErro='Comentário adicionado!");
} else {
  header("Location:../visao/publicacao.php?idproduto=$idproduto");
}

