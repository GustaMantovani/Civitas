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
    <link rel="stylesheet" href="css/cadObra.css">
    <link rel="shortcut icon" href="img/icons/owl-ico.ico" type="image/x-icon">
    <title>Civitas</title>
</head>

<body>
    <header id="header">

        <div id="position_title">
            <img src="img/title.png" alt="Civias" width="200px">
        </div>

    </header>

    <?php

        if (isset($_GET["id"])){
            require_once '../modelo/conexaoBD.php';
            require_once '../modelo/obrasDAO.php';
            require_once '../controlador/funcoes.php';

            $id = $_GET["id"];
            $tipoOriginal = $_GET["tipo"];

            $conexao = conectarBD();
                
            $res = pesquisarObraPorID($conexao, $id);
            if ( $registro = mysqli_fetch_assoc($res) ) {
                $nome =  $registro["titulo"];
                $autor = $registro["autor"];
                $descricao = $registro["descricao"];
                $tipoobra = $registro["idTipo"];
                $genero = $registro["idGenero"];

                if(!empty($registro["capa"])){
                    $bytes  = $registro["capa"];
                    $imgCapa = base64_encode($bytes);
                    $caminhoImg = "data:image/jpeg;base64,$imgCapa";
                }else{
                    $caminhoImg = "img/capa.png";
                }

            }


        }else{
            $id = 0;
            $nome =  "";
            $autor = "";
            $descricao = "";
            $tipoobra = "";
            $genero = "";
            $imgCapa = "";
            $caminhoImg = "img/capa.png";
        }

        if(isset($_GET["tipoAlteracao"])){
            $tipoAlteracao = $_GET["tipoAlteracao"];
        }
    ?>

    <section id="cad">
        <div id="form_cad">
            <h1>Cadastro de Obra</h1>
            <form action="../controlador/alterarObra.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="tipoAlteracao" value="<?php echo $tipoAlteracao; ?>">
                <input type="hidden" name="tipoOriginal" value="<?php echo $tipoOriginal; ?>">
                <table>
                    <tr>
                        <td><input class="txtCad" type="text" name="txtNomeObra" size="40" placeholder="Nome da Obra"
                                value="<?php echo $nome; ?>"></td>
                    </tr>

                    <tr>
                        <td><input class="txtCad" type="text" name="txtAutor" size="40" placeholder=" Autor/Diretor"
                                value="<?php echo $autor; ?>"></td>
                    </tr>

                    <tr>
                        <td><textarea class="txtCad" name="txtDescricao" cols="30" rows="4" placeholder="Descrição"
                                style="max-width:380px;"><?php echo $descricao; ?></textarea></td>
                    </tr>

                    <tr>
                        <td> Tipo de Obra
                            <select name="cbObra">
                                <?php //Combobox do tipo da obra
                                    require_once '../modelo/conexaoBD.php';
                                    require_once '../modelo/tipoDAO.php';
                                    $conexao =  conectarBD();

                                    $resposta = comboTipo($conexao, $tipoobra);

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
                                <?php //Combobox do gênero da obra
                                    require_once '../modelo/conexaoBD.php';
                                    require_once '../modelo/generoDAO.php';
                                    $conexao =  conectarBD();

                                    $resposta = comboGenero($conexao, $genero);

                                    if(isset($resposta)){
                                        echo $resposta;
                                    }
                            
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td id="imagem">
                            <h3>Capa: </h3>
                            <?php
                            echo <<<html
                                <img for="flImage" width="90px" src="$caminhoImg" id="imgUp">
                            html;
                            ?>
                            <input type="file" name="capa" id="flImage" accept="image/*"><img id="imgFoto"
                                name="imgFoto" src="">
                            <script src="js/scripts.js"></script>
                        </td>
                    </tr>

                    <tr>
                        <td><input class="btn" type="submit" name="btnEnviar" value=" SALVAR "></td>
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