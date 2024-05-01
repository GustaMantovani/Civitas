<?php
require_once '../controlador/validarAdm.php';
require_once '../modelo/conexaoBD.php';
require_once '../modelo/obrasDAO.php';

$conexao = conectarBD();

if (isset($_GET["id"])) {
  $id = $_GET["id"];
  $tipo  = $_GET["tipo"];
  excluirObras($conexao, $tipo, $id);
  header("Location:../visao/obras.php?msg=Obra $id excluído com sucesso.");
} else {
  header("Location:../visao/obras.php?msg=ERRO! ID da obra não encontrado.");
}

