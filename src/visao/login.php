<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="shortcut icon" href="img/icons/owl-ico.ico" type="image/x-icon">
    <title>Civitas</title>
</head>

<body>
    <header><img src="img/title.png" width="200px"></header>
    <section>
        <form id="formLogin" action="../controlador/logar.php" method="POST">
            <h2 style="font-size: 20pt;">Login</h2>
            <table>
                <tr>
                    <td><input class="txtCad" type="text" name="txtLogin" placeholder=" Usuário"></td>
                </tr>

                <tr>
                    <td><input class="txtCad" type="password" name="txtSenha" placeholder=" Senha"></td>
                </tr>

                <tr>
                    <td><input id="btnEntrar" type="submit" name="btnEntrar" value="Entrar"></td>
                </tr>

                <tr>
                    <td><a id="btnCad" href="formCadastro.php">Cadastrar</a></td>
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

    </section>
</body>

</html>