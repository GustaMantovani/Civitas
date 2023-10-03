<?php
    require_once '../controlador/validar.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/mainHeader.css">
    <link rel="stylesheet" href="css/publicacao.css">
    <link rel="shortcut icon" href="img/icons/owl-ico.ico" type="image/x-icon">
    <script src="js/funcoes.js"></script>
    <title>Civitas</title>
</head>

<body>
    <header id="header">

        <div id="position_title">
            <img src="img/title.png" alt="Civias" width="200px">
        </div>

        <div style="position: relative;">
            <?php
                echo "<a href='perfil.php?id=$idLogado' style='color: white; display: flex; flex-direction: row;text-decoration: none; align-items: center;'><img style='object-position: center; object-fit: cover; clip-path: circle();' src='data:image/jpeg;base64,$imgPerfilSessao' width='40px' height='40px'><p style='padding-left: 3px;'>$usrLogado</p></a>";
            ?>
        </div>

        <aside id="aside_cabecalho">
            <div id="explorar">

                <?php
                    $idproduto = $_GET["idproduto"];
                    echo "
                        <a href='lista.php?idproduto=$idproduto&&coman=true'><img src='img/livros.png' width='16.5px'></a>
                    ";
                ?>
                <a href="explorar.php" alt="livros com interesse"><img src="img/icone-globe-violet.png"
                        width="25px"></a>
            </div>
            <form action="pesquisa.php">

                <div id="divBusca">
                    <input type="text" id="txtBusca" name="txtpesq" placeholder="PESQUISA" class="espacamento" />
                    <button id="btnBusca" type="submit"><img src="img/search1.png" alt="Buscar"
                            class="espacamento" /></button>
                </div>
            </form>
        </aside>

    </header>

    <section id="obras">

        <div>
            <?php
                require_once '../modelo/conexaoBD.php';
                require_once '../modelo/obrasDAO.php';
                require_once '../modelo/publicacaoDAO.php';
                require_once '../modelo/tipoDAO.php';
                require_once '../modelo/generoDAO.php';
                require_once "../modelo/interesseDAO.php";
                require_once "../modelo/usuariosDAO.php";
                require_once "../controlador/funcoes.php";
                $conexao = conectarBD();
                
                $resultadoObraID = pesquisarObraPorID($conexao, $idproduto);
                if ( $registro = mysqli_fetch_assoc($resultadoObraID) ) {
                    $nome =  $registro["titulo"];
                    $autor = $registro["autor"];
                    $descricao = $registro["descricao"];
                    $idTipo = $registro["idTipo"];
                    $idGenero = $registro["idGenero"];

                    $resultadoTipoID = pesquisarTipoPorID($conexao, $idTipo);
                    if ( $registroTipo = mysqli_fetch_assoc($resultadoTipoID) ) {
                        $tipoObra = $registroTipo["tipo"];
                    }

                    $resultadoGeneroID = pesquisarGeneroPorID($conexao, $idGenero);
                    if ( $registroGenero = mysqli_fetch_assoc($resultadoGeneroID) ) {
                        $genero = $registroGenero["genero"];
                    }

                    $bytes = $registro["capa"];
                    $capa = base64_encode($bytes); 

                    if (calcularMediaAvalObra ($conexao, $idproduto)!=-1){
                        $mediaAval = montarAvalComem (calcularMediaAvalObra ($conexao, $idproduto));
                    }else{
                        $mediaAval = "";
                    }
                    
                    echo "<div id='conteudo'>
                    <div id='apresentacao'>
                        <div id='divCapa'> 
                            <a href=data:image/jpeg;base64,$capa><img id='capa' src='data:image/jpeg;base64,$capa'></a>
                        </div>
                        <div id='infos'>
                            <div style='display: flex; flex-direction: row;'>
                                <h4>$nome</h4>
                                <p style='margin-left: 5px;'>$mediaAval</p>
                            </div>
                            <div class='espacamento'>
                                <p>Tipo: $tipoObra</p>
                                <p>Autor: $autor</p>
                                <p>Gênero: $genero</p>
                            </div>
                            <p id='descricao' class='espacamento'>$descricao</p>
                        </div>
                    </div>";
                    
                    if ($idTipo==1){
                        
                        $idListaUsuario = pesquisaInteresse ($conexao, $idLogado, $idproduto);
                        while ($registro = mysqli_fetch_assoc($idListaUsuario)){
                            $idInteresse = $registro["idInteresse"];
                        }


                        $lista = $_SESSION["lista"];
                        $pesqSessao = false;
                        foreach ( $lista as $idLivro => $livro ) {
                            if ($idLivro == $idproduto){
                                $pesqSessao = true;
                            }
                        }

                        if ($pesqSessao){
                            echo"<div id='linkTrocar'>
                                <a id='btnTrocarLivro' href='lista.php?coman=true&&idproduto=$idproduto'><button style='width=200px;' id='btn_lista'>Na sua Lista de Livros</button></a>
                            </div>";
                        }

                        elseif(mysqli_num_rows($idListaUsuario) > 0){
                            echo"<div id='linkTrocar'>
                                <a id='btnTrocarLivro' href='../controlador/excluirInteresse.php?idInteresse=$idInteresse&&coman=true&&idproduto=$idproduto'><button style='width=200px;' id='btn_excInteresse'>Deixar de doar</button></a>
                            </div>";
                        }else{
                            echo"<div id='linkTrocar'>
                                <a id='btnTrocarLivro' href='../controlador/listarLivro.php?addIdLivro=$idproduto&&nome=$nome&&autor=$autor'><button style='width=200px;' class='btn_interesse'>Quero doar</button></a>
                            </div>";
                        }
                    } 
                }
            ?>
        </div>

        <h1 id="tituloComunidade">Comunidade</h1>
        <hr>
        <div id="painel">
            <div id="publicacoes">
                <form id="formComem" autocomplete="off" action="../controlador/publicar.php" method="POST">


                    <div id="headerForm">
                        <input id="tema" type="text" name="txtTemaPubli" placeholder="Tema">
                        <div id="avaliacao">
                            <a href="javascript:void(0)" onclick="Avaliar(1)">
                                <img src="img/star0.png" id="s1"></a>

                            <a href="javascript:void(0)" onclick="Avaliar(2)">
                                <img src="img/star0.png" id="s2"></a>

                            <a href="javascript:void(0)" onclick="Avaliar(3)">
                                <img src="img/star0.png" id="s3"></a>

                            <a href="javascript:void(0)" onclick="Avaliar(4)">
                                <img src="img/star0.png" id="s4"></a>

                            <a href="javascript:void(0)" onclick="Avaliar(5)">
                                <img src="img/star0.png" id="s5"></a>
                        </div>
                    </div>
                    <hr>
                    <div id="footerForm">
                        <textarea id="txtComentario" name="txtComentario" style="resize: none" cols="30" rows="4"
                            placeholder="Comentário"></textarea>
                        <button id="btnComentar" type="submit"><img src="img/send.png" alt="Comentar"></button>
                    </div>
                    <input type="hidden" name="avaliacao" id="rating">
                    <input type="hidden" name="dataPubli" value=<?php echo date('Y-m-d'); ?>>
                    <input type="hidden" name="idproduto" value=<?php echo $idproduto; ?>>
                </form>
                <div>
                    <?php
                        $resultadoPublicacaoID = pesquisarPublicacaoPorIDProduto($conexao, $idproduto);
                        while ( $registro = mysqli_fetch_assoc($resultadoPublicacaoID) ) {
                            $id = $registro["idpublicacao"];
                            $temaPubli = $registro["tema"];
                            $comentario = $registro["comentario"];
                            $avaliacao = $registro["avaliacao"];
                            $data = $registro["dataPublicacao"];
                            $idUsr = $registro["Usuario_idusuario"];

                            $dataConvertida = converterDataBD ($data);

                            $resultadoUsrID = pesquisarUsrporID ($conexao, $idUsr);
                            $registroUsr = mysqli_fetch_assoc($resultadoUsrID);
                            
                            $usuario = $registroUsr["usuario"];
                            $bytes = $registroUsr["imgPerfil"];
                            $imgPerfil = base64_encode($bytes);

                            echo "<div id='comunidade'>";  
                                echo " <div id='comentario'>
                                    <div id='perfil'>
                                        <a href='perfil.php?id=$idUsr'><img id='imgPerfil' src='data:image/jpeg;base64,$imgPerfil'  width='50px'></a>
                                        <p style='font-size: 8pt;'>$usuario</p>
                                    </div>

                                    <div id='textos'>
                                        <div id='headerPubli'>
                                            <h4 id='temaPubli' style='margin-right: 10px;'>$temaPubli</h4>

                                            <div style='align-items: center;'>";
                                                $result = montarAvalComem ($avaliacao);
                                                echo "$result";
                                        echo "</div>
                                        </div>
                                        <p id='textoPubli'>$comentario</p>
                                        <p style='font-size: 8pt;'>$dataConvertida</p>
                                    </div>
                                </div>";
                                

                                if ($idLogado==$idUsr){
                                    echo "<form action='../controlador/excluirPubli.php' method='post'>
                                        <input type='hidden' name='idpublicacao' value='$id'>
                                        <input type='hidden' name='idproduto' value='$idproduto'>
                                        <button id='btnExcluir' type='submit' ><img src='img/fechada.png' alt='Comentar'></button> 
                                    </form>";
                                }
                            echo "</div>";
                        }
                    ?>
                </div>
            </div>

            <?php
                $resultadoInteresseID = exibirInteressesPorIdObra ($conexao, $idproduto);

                if (mysqli_num_rows($resultadoInteresseID) > 0){
                    echo "<div id='lista'>";
                        echo "<div id='tituloLista'><h2 style='font-size: 16pt;'>Dispostos a doar este livro:</h2></div>";
                        while ( $registro = mysqli_fetch_assoc($resultadoInteresseID) ) {
                            $doador = $registro["Usuario_idusuario"];

                            $resultadoUsrID = pesquisarUsrporID ($conexao, $doador);
                            $registroUsr = mysqli_fetch_assoc($resultadoUsrID);
                            
                            $usuario = $registroUsr["usuario"];
                            $email = $registroUsr["email"];
                            $bytes = $registroUsr["imgPerfil"];
                            $imgPerfil = base64_encode($bytes);

                            echo "<div id='perfilLista'>
                                <a href='perfil.php?id=$doador'><img id='imgPerfil' src='data:image/jpeg;base64,$imgPerfil'  width='50px'></a>
                                <p style='font-size: 12pt; margin-left: 5px'>$usuario</p>
                            </div>";
                        }

                    echo "</div>";

                }
            ?>
        </div>
    </section>

</body>

</html>