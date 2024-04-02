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
    <link rel="stylesheet" href="css/lista.css">
    <link rel="shortcut icon" href="img/icons/owl-ico.ico" type="image/x-icon">
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
                <a href="explorar.php"><img src="img/icone-globe-violet.png" width="25px"></a>
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

        <form action="../controlador/salvarInteresse.php" method="POST">
            <?php
                if (isset($_GET["coman"])){
                    $idproduto = $_GET["idproduto"];
                    echo "
                        <input type='hidden' name='idproduto' value='$idproduto'>
                    ";
                }

            ?>
            <div id="form_cad">
                <h1>Lista de Livros</h1>
                <table>
                    <?php

                        //MOSTRAR
                        $lista = $_SESSION["lista"];
                        foreach ( $lista as $idLivro => $livro ) {

                            $nome = $livro["nome"];
                            $autor = $livro["autor"];

                            require_once '../modelo/conexaoBD.php';
                            require_once '../modelo/obrasDAO.php';
                            require_once '../controlador/funcoes.php';

                            $conexao = conectarBD();
                                
                            $res = pesquisarObraPorID($conexao, $idLivro);
                            if ( $registro = mysqli_fetch_assoc($res) ) {
                                $bytes = $registro["capa"];
                                $capa = base64_encode($bytes);
                            }

                            echo "<tr>";
                            echo "<td><img id='capa' style='object-position: center; object-fit: cover;' src='data:image/jpeg;base64,$capa'></td>";
                            echo "<td>$nome</td>";
                            echo "<td>$autor</td>";
                            echo "<td><a href='../controlador/listarLivro.php?delIdLivro=$idLivro'><img width='18px' src='img/fechada.png' alt='Comentar'></a></td>";
                            echo "</tr>";
                        }

                        if (sizeof($_SESSION["lista"])>0){

                            echo"<tr id='enviar'>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><input class='btn' type='submit' name='btnEnviar' value='Salvar'></td>
                                    </tr>";
                        }else{
                            echo "<p>Sua lista de livros está vazia</p>";
                        }
                    ?>
                </table>
            </div>
        </form>
    </section>

</body>

</html>