<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/cadUsr.css">
    <link rel="shortcut icon" href="img/icons/owl-ico.ico" type="image/x-icon">
    <script src="js/funcoes.js"></script>
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
                require_once '../modelo/usuariosDAO.php';
                require_once '../controlador/funcoes.php';
        
                $id = $_GET["id"];
        
                $conexao = conectarBD();
                    
                $res = pesquisarUsrporID($conexao, $id);
                if ( $registro = mysqli_fetch_assoc($res) ) {
                    $nome =  $registro["nome"];
                    $usuario = $registro["usuario"];
                    $email = $registro["email"];
                    $dtBD = $registro["dataNasc"];
                    $cpf = $registro["cpf"];
                    $bytesBanco = $registro["imgPerfil"];
                    $imgPerfil =  base64_encode($bytesBanco); 
                    $caminhoImg = "data:image/jpeg;base64,$imgPerfil";
                    
                    $dataNasc = converterDataBD ($dtBD);

                    $typeCpf = "hidden";
                }
        
            }
            else{
                $id=0;
                $nome = "";
                $usuario = "";
                $email = "";
                $dataNasc = "";
                $cpf = "";
                $imgPerfil = "";
                $caminhoImg = "img/iconePerfil.png";
                $typeCpf = "text";
            }
    ?>

    <section id="cad">
        <div id="form_cad">
            <h1>Cadastro</h1>
            <form action="../controlador/cadUsuario.php" method="POST" enctype="multipart/form-data">
                <table>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <tr>
                        <td><input class="txtCad" type="text" name="txtNome" size="40" placeholder=" Nome e Sobrenome"
                                value="<?php echo $nome; ?>"></td>
                    </tr>

                    <tr>
                        <td><input class="txtCad" type="text" name="txtUsuario" size="40" placeholder=" Usuário"
                                value="<?php echo $usuario; ?>"></td>
                    </tr>

                    <tr>
                        <td><input class="txtCad" type="text" name="txtEmail" size="40" placeholder=" Email"
                                value="<?php echo $email; ?>"></td>
                    </tr>

                    <tr>
                        <td><input class="txtCad" type="text" name="txtData" size="40" placeholder=" Data de Nascimento"
                                value="<?php echo $dataNasc; ?>"></td>
                    </tr>

                    <tr>
                        <td><input class="txtCad" type="<?php echo $typeCpf; ?>" name="txtCPF" size="40"
                                placeholder=" CPF" value="<?php echo $cpf; ?>"></td>
                    </tr>

                    <tr>
                        <td><input class="txtCad" type="password" name="txtSenha1" size="40" placeholder=" Senha"></td>
                    </tr>

                    <tr>
                        <td><input class="txtCad" type="password" name="txtSenha2" size="40"
                                placeholder=" Confirmar Senha"></td>
                    </tr>

                    <tr>
                        <td id="imagem">
                            <h3>Imagem de Perfil</h3>
                            <?php
                            echo <<<html
                                <img for="flImage" width="90px" src="$caminhoImg" id="imgUp">
                            html;
                            ?>
                            <input type="file" name="imgPerfil" id="flImage" accept="image/*"><img id="imgFoto"
                                name="imgFoto" src="">
                            <script src="js/scripts.js"></script>
                        </td>
                    </tr>

                    <tr>
                        <td>

                            <input id="termoCad" type="checkbox" name="cbTermo">
                            Eu li e concordo com os <a id="termoLink" href="termos.html">Termos de Uso e Serviço</a>
                        </td>
                    </tr>

                    <tr>
                        <td><input class="btn" type="submit" name="btnEnviar" value="Cadastrar"></td>

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