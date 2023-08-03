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
    <link rel="stylesheet" href="css/perfil.css">
    <link rel="stylesheet" href="css/lista.css">
    <link rel="shortcut icon" href="img/icons/owl-ico.ico" type="image/x-icon">
    <title>Civitas</title>

    <style>
        
    </style>
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

    <section id="cad">
        <div id="form_cad">
            <?php
                $idUsr=$_GET["id"];
                 
                require_once "../modelo/conexaoBD.php";

                $conexao = conectarBD();

                require_once "../modelo/usuariosDAO.php";


                $pesq=pesquisarUsrporID ($conexao, $idUsr);

                $registroUsr = mysqli_fetch_assoc( $pesq );

                $usuario = $registroUsr["usuario"];
                $email = $registroUsr["email"];
                $cpf = $registroUsr["cpf"];
                $dtNasc = $registroUsr["dataNasc"];

                require_once "../controlador/funcoes.php";
                $dataConvertida = converterDataBD ($dtNasc);

                $bytes = $registroUsr["imgPerfil"];

                $imgPerfil = base64_encode($bytes);

                echo "<div>";
                    echo "<DIV id='nome'><img style='object-position: center; object-fit: cover; clip-path: circle();' src='data:image/jpeg;base64,$imgPerfil' width='150px' height='150px'><h2 class='margin'>$usuario</h2></DIV>"; 

                    echo "<p>Email: $email</p>";
                    echo "<p>Anivesário: $dataConvertida</p>";
                    echo "<p>CPF: $cpf</p>";
                    echo "<div id='editar'> 
                    <a href='../controlador/excluirUsr.php?id=$idUsr&&coman=true'><button><img width='15px' src='img/fechada.png'></button></a>
                    </div>";
                echo "</div>";


            ?>
        </div>
            <div id="comunidade">
                <div style="display: flex; justify-content: center; align-items: center;"><h2 style="margin-left: 30px; font-size: 16pt; margin-top: 20px;">Publicações:</h2></div>
                <?php
                    require_once "../modelo/publicacaoDAO.php";
                    $pesqPubliAval = pesquisarPublicacaoPorIDUsr($conexao, $idUsr);


                    require_once "../modelo/obrasDAO.php";
                    while ($registroPubliAval = mysqli_fetch_assoc($pesqPubliAval)){
                        $idPubli = $registroPubliAval["idpublicacao"];
                        $idObra = $registroPubliAval["produtoCultural_idproduto"];
                        $temaPubli = $registroPubliAval["tema"];
                        $comentario = $registroPubliAval["comentario"];
                        $avaliacao = $registroPubliAval["avaliacao"];
                        $data = $registroPubliAval["dataPublicacao"];
                        $idUsr = $registroPubliAval["Usuario_idusuario"];


                        $dataConvertidaPubli = converterDataBD ($data);


                        $pesqObraIdAval=pesquisarObraPorID($conexao, $idObra);
                        while ($registroObraAval = mysqli_fetch_assoc($pesqObraIdAval)){
                            $idLivroPubli = $registroObraAval["idproduto"];
                            $titulo = $registroObraAval["titulo"];
                            $bytes = $registroObraAval["capa"];
                            $capa = base64_encode($bytes);
                            echo "<div id='estruturaPubli'>";
                                echo "<div id='avaliacao'> <a style='display: flex; flex-direction: column; align-items: center; text-decoration: none;' href='obras.php'><img style='object-position: center; object-fit: cover;' id='capa' src='data:image/jpeg;base64,$capa'><p style = 'color: black; max-width: 170px;'>$titulo</p></a>";


                                echo "<div id='textos'>
                                    <div id='headerPubli'>
                                        <h4 id='temaPubli' style='margin-right: 10px;'>$temaPubli</h4>

                                        <div style='align-items: center;'>";
                                            $result = montarAvalComem ($avaliacao);
                                            echo "$result";
                                    echo "</div>
                                    </div>
                                    <div>
                                        <p id='textoPubli'>$comentario</p>
                                        <p style='font-size: 8pt;'>$dataConvertidaPubli</p>
                                    </div>
                                </div>";
                            echo "</div>";

                            echo "<a href='../controlador/excluirPubli.php?idpublicacao=$idPubli&&idproduto=$idObra&&coman=true&&idUsr=$idUsr'><button id='btnExcluir' type='submit'><img style='width: 15px;' src='img/fechada.png' alt='Comentar'></button></a> ";
                            echo "</div>";
                        }

                    }
                ?>
            </div>
        </div>
    </section>
</body>
</html>