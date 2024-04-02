<?php
require_once '../controlador/validarAdm.php';
require_once 'funcoes.php';
require_once '../modelo/conexaoBD.php';
require_once '../modelo/obrasDAO.php';

$id = $_POST["id"];
$tipoOriginal=$_POST["tipoOriginal"];
$nome =  $_POST["txtNomeObra"];
$autor = $_POST["txtAutor"];
$descricao = $_POST["txtDescricao"];
$tipoobra = $_POST["cbObra"];
$genero = $_POST["cbGenero"];
$imgCapa = $_FILES["capa"];
$tipoAlteracao = $_POST["tipoAlteracao"];

$conexaoBD = conectarBD(); 
$msgErro= ValidarCamposObrasAdm($nome, $autor, $descricao, $tipoobra, $genero, $imgCapa, $id, $tipoAlteracao); 

if ($id!=0){
    if (empty($msgErro)){ 
        if ( ( $imgCapa["type"] != "image/gif" ) && 
        ( $imgCapa["type"] != "image/jpeg" ) &&
        ( $imgCapa["type"] != "image/pjpeg" ) &&
        ( $imgCapa["type"] != "image/png" ) &&
        ( $imgCapa["type"] != "image/x-png" ) &&
        ( $imgCapa["type"] != "image/jfiif" ) &&
        ( $imgCapa["type"] != "image/bmp" ) ) {
            $msgErro = alterarObrasSemImg($conexaoBD, $id, $nome, $autor, $descricao, $tipoOriginal, $tipoobra, $genero);
        }else{
            $msgErro = alterarObras($conexaoBD, $id, $nome, $autor, $descricao, $tipoOriginal, $tipoobra, $genero, $imgCapa);        
        }
        header("Location:../visao/obras.php");
    }
    
    else {
        if ($tipoAlteracao==2){
            header("Location:../visao/formAlterarObras.php?tipoAlteracao=$tipoAlteracao&&msg=$msgErro");
        }
        elseif ($tipoAlteracao==1 || $tipoAlteracao==0){
            header("Location:../visao/formAlterarObras.php?id=$id&&tipo=$tipoobra&&tipoAlteracao=$tipoAlteracao&&msg=$msgErro");
        }
        
    }
}else{
    if (empty($msgErro)){ 
        $msgErro = cadObrasAdm($conexaoBD, $nome, $autor, $descricao, $tipoobra, $genero, $imgCapa);
        header("Location:../visao/obras.php");
    }
    
    else {
        if ($tipoAlteracao==2){
            header("Location:../visao/formAlterarObras.php?tipoAlteracao=$tipoAlteracao&&msg=$msgErro");
        }
        elseif ($tipoAlteracao==1 || $tipoAlteracao==0){
            header("Location:../visao/formAlterarObras.php?id=$id&&tipo=$tipoobra&&tipoAlteracao=$tipoAlteracao&&msg=$msgErro");
        }
    }
}
?>