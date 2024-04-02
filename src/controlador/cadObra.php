<?php
require_once 'funcoes.php';

//Campos de texto do cadastro de sugestão de obra

$nome =  trim($_POST["txtNomeObra"]);
$autor = trim($_POST["txtAutor"]);
$tipoobra = $_POST["cbObra"];
$genero = $_POST["cbGenero"];

require_once '../modelo/conexaoBD.php';

   
$msgErro= ValidarCamposObras($nome, $autor, $tipoobra, $genero); //Verifica se os campos não estão vazios

require_once '../modelo/obrasDAO.php';
$conexao = conectarBD(); //Chama a conexão com o banco de dados

if (empty($msgErro)){ //Insere a obra no banco de dados
    $msgErro = cadastrarObra($conexao, $nome, $autor, $tipoobra, $genero);
    header("Location:../visao/formObra.php?msg=$msgErro");
}

else {
    header("Location:../visao/formObra.php?msg=$msgErro");
}
?>