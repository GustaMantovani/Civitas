<?php
    require_once '../controlador/validar.php';
    require_once 'funcoes.php';
    

    require_once '../modelo/conexaoBD.php';
    $conexao = conectarBD();//Chama a conexão com o banco de dados

    //Campos de texto
    $nome = trim($_POST["txtNome"]); //'trim' remove os espaços no começo e no fim do campo
    $usuario = mysqli_real_escape_string($conexao, htmlspecialchars(trim($_POST["txtUsuario"]), ENT_QUOTES, 'UTF-8'));
    $email = mysqli_real_escape_string($conexao, htmlspecialchars(trim($_POST["txtEmail"]), ENT_QUOTES, 'UTF-8'));    
    $data = trim($_POST["txtData"]);
    $cpf = trim($_POST["txtCPF"]); 
    $cpfConvertido = preg_replace( '/[^0-9]/is', '', $cpf ); //Recebe somente os números do cpf     
    $senha1 = $_POST["txtSenha1"];
    $senha2 = $_POST["txtSenha2"];
    $imgPerfil = $_FILES["imgPerfil"];
    $id = $_POST ["id"];

    //CheckBox
    $termo=0;

    if (isset($_POST["cbTermo"])){
        $termo=1;
    }

    //Converte a data
    $dtConvertida = converterData($data);

    $msgErro=validarCampos($conexao, $id, $nome, $usuario, $email, $data, $cpfConvertido, $senha1, $senha2, $termo, $imgPerfil, ); //Mensagem de erro referente aos campos do formulário

    require_once '../modelo/usuariosDAO.php';

    if (empty($id)){
        if (empty($msgErro)){
            $msgErro = cadastrarUsuario($conexao, $nome, $usuario, $email, $dtConvertida, $cpfConvertido, $senha1, $imgPerfil);
            header("Location:../visao/login.php?msg=$msgErro");
        }
        
        else {
            header("Location:../visao/formCadastro.php?msg=$msgErro");
        }
    }else{

        if (empty($msgErro)){
            if ( ( $imgPerfil["type"] != "image/gif" ) && 
            ( $imgPerfil["type"] != "image/jpeg" ) &&
            ( $imgPerfil["type"] != "image/pjpeg" ) &&
            ( $imgPerfil["type"] != "image/png" ) &&
            ( $imgPerfil["type"] != "image/x-png" ) &&
            ( $imgPerfil["type"] != "image/jfiif" ) &&
            ( $imgPerfil["type"] != "image/bmp" ) ) {
                $msgErro = alterarUsrSemImg ($conexao, $id, $nome, $usuario, $email, $dtConvertida, $senha1);
            }else{
                $msgErro = alterarUsr ($conexao, $id, $nome, $usuario, $email, $dtConvertida, $senha1, $imgPerfil);
            }
            require_once "session.php";
            sessionUpdate($conexao);
            header("Location:../visao/perfil.php?id=$id");
        }else{
            header("Location:../visao/formCadastro.php?id=$idLogado&&msg=$msgErro");
        }
    }


    
?>