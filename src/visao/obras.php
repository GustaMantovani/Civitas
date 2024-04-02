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

    #aside_cabecalho {
        position: relative;
        display: flex;
        flex-direction: row;
        margin-right: 15px;
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

        <aside id="aside_cabecalho">
            <a style="margin-right: 2px;" href="../visao/formAlterarObras.php?tipoAlteracao=2"><img width="20px"
                    src="img/cadObra.png"></a>
            <a href="admin.php"><img src="img/icone-globe-violet.png" width="25px"></a>
        </aside>
    </header>

    <section>
        <?php
            require_once '../modelo/conexaoBD.php';
            require_once '../modelo/obrasDAO.php';

            $conexao = conectarBD();
            $resultado = exibirObrasSugeridas($conexao);

            echo "<H2> Obras Sugeridas </H2>";
            echo "<TABLE border=1>";
                echo "<TR><TH>ID</TH><TH>TITULO</TH><TH>AUTOR</TH><TH>GENERO</TH><TH>TIPO</TH></TR>";
                while ( $registro = mysqli_fetch_assoc( $resultado )  ) {
                    // Pegar os campos desse registro
                    $id = $registro["idproduto"];
                    $titulo = $registro["titulo"];
                    $autor = $registro["autor"];
                    $idGenero = $registro["idGenero"];
                    $idTipo = $registro["idTipo"];

                    echo "<TR id='tabelaObras'>";
                    echo "<TD>$id</TD>";
                    echo "<TD>$titulo</TD>";
                    echo "<TD>$autor</TD>";
                    echo "<TD>$idGenero</TD>";
                    echo "<TD>$idTipo</TD>"; 
                    echo "<TD>
                            <A href='formAlterarObras.php?id=$id&&tipo=$idTipo&&tipoAlteracao=1'><button>Alterar</button></A>
                            <A href='../controlador/excluirProduto.php?id=$id&&tipo=$idTipo'> <button>Excluir</button> </A>
                        </TD>";                                                                 
                    echo "</TR>";
                }
                echo "</TABLE>";

                $resultado = exibirObrasAprovadas($conexao);
    
                echo "<H2> Obras Aprovadas </H2>";
                echo "<TABLE border=1>";
                    echo "<TR><TH>ID</TH><TH>TITULO</TH><TH>AUTOR</TH><TH>DESCRIÇÃO</TH><TH>CAPA</TH><TH>GENERO</TH><TH>TIPO</TH></TR>";
                    while ( $registro = mysqli_fetch_assoc( $resultado )  ) {
                        // Pegar os campos desse registro
                        $id = $registro["idproduto"];
                        $titulo = $registro["titulo"];
                        $autor = $registro["autor"];
                        $descricao = $registro["descricao"];
                        $idGenero = $registro["idGenero"];
                        $idTipo = $registro["idTipo"];

                        $bytes = $registro["capa"];
                        $capa = base64_encode($bytes);
    
                        echo "<TR id='tabelaObras'>";
                        echo "<TD>$id</TD>";
                        echo "<TD>$titulo</TD>";
                        echo "<TD>$autor</TD>";
                        echo "<TD>$descricao</TD>";
                        echo "<TD><img src='data:image/jpeg;base64,$capa' width='100'></TD>";
                        echo "<TD>$idGenero</TD>";
                        echo "<TD>$idTipo</TD>";
                        echo "<TD id='menuObras'>
                                <A href='formAlterarObras.php?id=$id&&tipo=$idTipo&&tipoAlteracao=0'><button>Alterar</button></A>
                                <A href='../controlador/excluirProduto.php?id=$id&&tipo=$idTipo'><button>Excluir</button></A>
                            </TD>";                                 
                        echo "</TR>";
                    }
                echo "</TABLE>";
            ?>
    </section>

</body>

</html>