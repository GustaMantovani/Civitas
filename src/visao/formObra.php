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
    <link rel="stylesheet" href="css/cadObra.css">
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
            <h1>Solicitar Cadastro de Obra</h1>
            <form action="../controlador/cadObra.php" method="POST">
                <table>
                    <tr>
                        <td><input class="txtCad" type="text" name="txtNomeObra" size="40" placeholder="Nome da Obra">
                        </td>
                    </tr>

                    <tr>
                        <td><input class="txtCad" type="text" name="txtAutor" size="40" placeholder=" Autor/Diretor">
                        </td>
                    </tr>

                    <tr>
                        <td> Tipo de Obra
                            <select name="cbObra">
                                <option value="">Escolha</option>
                                <?php //Combobox do tipo da obra
                                
                                    require_once '../modelo/conexaoBD.php';
                                    require_once '../modelo/tipoDAO.php';
                                    $conexao =  conectarBD();

                                    $resposta = comboTipo($conexao,null);

                                    if(isset($resposta)){
                                        echo $resposta;
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td> Gênero
                            <select name="cbGenero">
                                <option value="">Escolha</option>
                                <?php //Combobox do gênero da obra
                                
                                require_once '../modelo/conexaoBD.php';
                                require_once '../modelo/generoDAO.php';
                                $conexao =  conectarBD();

                                $resposta = comboGenero($conexao,null);

                                if(isset($resposta)){
                                    echo $resposta;
                                }
                                
                            
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><input class="btn" type="submit" name="btnEnviar" value=" SOLICITAR CADASTRO "></td>

                    </tr>
                </table>
                <?php
                    // Exibir a mensagem de ERRO caso OCORRA
                    if (isset($_GET["msg"])) {  // Verifica se tem mensagem de ERRO
                        $mensagem = $_GET["msg"];
                        echo "<FONT color=red>$mensagem</FONT>";
                    }
                ?>
            </form>
        </div>

    </section>
</body>

</html>