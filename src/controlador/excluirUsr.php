<?php
    require_once '../controlador/validar.php';

    if ( isset( $_GET["id"])) {
        $id = $_GET["id"];
    }else {
        header("Location:../visao/pesquisa.php?msg=ERRO! ID do usuário não encontrado.");
    }

    if($idLogado==$id || $tipo==1){
        require_once '../modelo/conexaoBD.php';
        require_once '../modelo/usuariosDAO.php';
        require_once '../modelo/publicacaoDAO.php';
        require_once '../modelo/interesseDAO.php';
        
        $conexao = conectarBD();
    
        excluirInteresseIdUsr ($conexao, $id);
        excluirPubliPorIDUsr ($conexao, $id);
        excluirUsr($conexao, $id);
    
        if ( isset( $_GET["coman"])){
            header("Location:../visao/usuarios.php");
        }else{
            header("Location:../visao/login.php?msg=Usuário excluído com sucesso.");
            session_destroy();
        }
    }
?>