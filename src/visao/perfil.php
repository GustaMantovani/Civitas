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
    <link rel="stylesheet" href="css/perfil.css">
    <link rel="stylesheet" href="css/lista.css">
    <link rel="shortcut icon" href="img/icons/owl-ico.ico" type="image/x-icon">
    <script src="js/exclude_confirm.js"></script>
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
                <a href="lista.php"><img src="img/livros.png" width="16.5px"></a>
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

                    if ($idUsr==$idLogado){
                        echo "<p>CPF: $cpf</p>";

                        echo "<div id='editar'> 
                            <a href='../visao/formCadastro.php?id=$idLogado'><button><img width='16px' src='img/edit.png'></button></a>
                            <a href='#' onclick='confirmarExclusao($idUsr)'><button><img width='15px' src='img/fechada.png'></button></a>
                            <a href  ='../controlador/logout.php'><img width='16px' style='padding-top: 1.5px;' heigth=17px src = 'img/sair.png'></a>
                        </div>";
                    }


                echo "</div>";
            ?>
            <script>
            function confirmarExclusao(idUsuario) {
              var resposta = confirm("Tem certeza que deseja excluir este usuário?");

              if (resposta) {
                window.location.href = "../controlador/excluirUsr.php?id=" + idUsuario;
              } else {
                return false;
              }
            }
            </script>
        </div>

        <div id="social">
            <div id="lista">
                <h2 style="font-size: 16pt;">Livros Que Quero Doar:</h2>
                <table>
                    <?php
                        require_once "../modelo/conexaoBD.php";
                        require_once "../modelo/interesseDAO.php";
                        require_once "../modelo/obrasDAO.php";

                        $conexao = conectarBD();
                        $idUsr = $_GET["id"];

                        $resultadoInteresseIdUsr = exibirInteressesPorIdUsr($conexao, $idUsr);

                        while ($registro = mysqli_fetch_assoc($resultadoInteresseIdUsr)){
                            $idInteresse = $registro["idInteresse"];
                            $idLivro = $registro["livro_produtoCultural_idproduto"];

                            $resultadoObraID = pesquisarObraPorID($conexao, $idLivro);


                            if ( $registroLivro = mysqli_fetch_assoc($resultadoObraID) ) {
                                $nome = $registroLivro["titulo"];
                                $autor = $registroLivro["autor"];
                                $bytes = $registroLivro["capa"];
                                $capa = base64_encode($bytes); 

                                echo "<tr>";
                                echo "<td><a href='publicacao.php?idproduto=$idLivro'><img id='capa' style='object-position: center; object-fit: cover;' src='data:image/jpeg;base64,$capa'></a></td>";
                                echo "<td>Título: $nome</td>";
                                echo "<td>Autor: $autor</td>";
                                if ($idUsr==$idLogado){
                                    echo "<td><a href='../controlador/excluirInteresse.php?idInteresse=$idInteresse'><img width='18px' src='img/fechada.png' alt='Comentar'></a></td>";
                                }
                                echo "</tr>";
                            }
                        }
                    ?>
                </table>
            </div>

            <div id="comunidade">
                <div style="display: flex; justify-content: center; align-items: center;">
                    <h2 style="margin-left: 30px; font-size: 16pt;">Minhas Avaliações:</h2>
                </div>
                <?php
                    require_once "../modelo/publicacaoDAO.php";
                    $pesqPubliAval = pesquisarPublicacaoPorIDUsr($conexao, $idUsr);

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
                                echo "<div id='avaliacao'> <a style='display: flex; flex-direction: column; align-items: center; text-decoration: none;' href='publicacao.php?idproduto=$idObra'><img style='object-position: center; object-fit: cover;' id='capa' src='data:image/jpeg;base64,$capa'><p style = 'color: black; max-width: 170px;'>$titulo</p></a>";

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

                            if ($idLogado==$idUsr){
                                echo "<form id='formExc' action='../controlador/excluirPubli.php' method='post'>
                                    <input type='hidden' name='idpublicacao' value='$idPubli'>
                                    <input type='hidden' name='idproduto' value='$idLivroPubli'>
                                    <input type='hidden' name='idUsr' value='$idLogado'>
                                    <input type='hidden' name='fromPefil' value='true'>
                                    <button id='btnExcluir' type='submit'><img style='width: 15px;' src='img/fechada.png' alt='Comentar'></button> 
                                </form>";
                            }
                            echo "</div>";
                        }

                    }
                ?>
                <script>
                    document.getElementById('').addEventListener('click', function() {
                      // Pede confirmação ao usuário
                      var confirmacao = confirm('Você tem certeza que deseja enviar o formulário?');

                      // Se o usuário confirmar, envia o formulário
                      if (confirmacao) {
                        document.getElementById('meuFormulario').submit();
                      } else {
                        // Caso contrário, você pode adicionar alguma lógica aqui ou simplesmente não fazer nada
                        console.log('Envio cancelado pelo usuário.');
                      }
                    });
                </script>
            </div>
        </div>
    </section>
</body>

</html>