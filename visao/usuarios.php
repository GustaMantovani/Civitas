<?php
    require_once '../controlador/validarAdm.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/mainHeader.css">
    <link rel="shortcut icon" href="img/icons/owl-ico.ico" type="image/x-icon">
    <style>
    #tabelaObras {
        text-align: justify;
    }

    #tabelaObras td {
        padding: 5px;
    }

    #menuObras {
        width: 150px;
    }
    </style>
    <title>Civitas</title>
</head>

<body>

    <header id="header">
        <div id="position_title">
            <img src="img/title.png" alt="Civias" width="200px">
        </div>

        <di></di>

        <aside style="margin-right: 6px;" id="aside_cabecalho">
            <a style="margin-right: 5px;" href="admin.php"><img src="img/icone-globe-violet.png" width="25px"></a>
        </aside>
    </header>

    <section>
        <?php
            require_once '../modelo/conexaoBD.php';
            require_once '../modelo/usuariosDAO.php';

            $conexao = conectarBD();
            $resultado = pesquisarUsr ($conexao, '');

            echo "<H2> Controle de Usuários </H2>";
            echo "<TABLE border=1>";
                echo "<TR><TH>ID</TH><TH>PERFIL</TH><TH>USUARIO</TH><TH>NOME</TH><TH>CPF</TH></TR>";
                
                while ( $registroUsr = mysqli_fetch_assoc($resultado)) {
                    $id = $registroUsr["idusuario"];
                    $usuario = $registroUsr["usuario"];
                    $nome = $registroUsr["nome"];
                    $cpf = $registroUsr["cpf"];

                    $bytes = $registroUsr["imgPerfil"];
                    $imgPerfil = base64_encode($bytes);

                   
                    
                    echo "<TR id='tabelaObras'>";
                    echo "<TD>$id</TD>";
                    echo "<TD><img width=50px src='data:image/jpeg;base64,$imgPerfil'></TD>";
                    echo "<TD>$usuario</TD>";
                    echo "<TD>$nome</TD>";
                    echo "<TD>$cpf</TD>";
                    echo "<TD>
                            <A href='publicacoes.php?id=$id'> <button>Publicações</button> </A>
                            <A href='../controlador/excluirUsr.php?id=$id&&coman=true'> <button>Excluir</button> </A>
                        </TD>";                                                                 
                    echo "</TR>";
                    
                }
                echo "</TABLE>";
                
            ?>
    </section>

</body>

</html>