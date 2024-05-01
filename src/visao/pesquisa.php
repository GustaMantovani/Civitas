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
  <link rel="stylesheet" href="css/conteudo.css">
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
        <a href="explorar.php" alt="livros com interesse"><img src="img/icone-globe-violet.png" width="25px"></a>
      </div>

      <form action="pesquisa.php">

        <div id="divBusca">
          <input type="text" id="txtBusca" name="txtpesq" placeholder="PESQUISA" class="espacamento" />
          <button id="btnBusca" type="submit"><img src="img/search1.png" alt="Buscar" class="espacamento" /></button>
        </div>
      </form>
    </aside>
  </header>

  <section id="cad">
    <div id="form_cad">
      <?php

      if (isset($_GET["txtpesq"])) {
        require_once '../modelo/conexaoBD.php';
        require_once '../modelo/usuariosDAO.php';
        require_once '../modelo/obrasDAO.php';

        $conexao = conectarBD();

        $txtPesq = mysqli_real_escape_string($conexao, htmlspecialchars(trim($_GET["txtpesq"]), ENT_QUOTES, 'UTF-8'));

        $pesqUsr = pesquisarUsr($conexao, $txtPesq);
        $pesqObras = pesquisarObras($conexao, $txtPesq);

        echo "<H1 style='margin-bottom: 10px;'>Obras</H1>";
        if (mysqli_num_rows($pesqObras) > 0) {
          echo "<TABLE>";
          while ($registroObra = mysqli_fetch_assoc($pesqObras)) {
            $idproduto = $registroObra["idproduto"];
            $titulo = $registroObra["titulo"];
            $bytes = $registroObra["capa"];


            $capa = base64_encode($bytes);


            echo "<TD style='margin: 0px 10px 25px 10px;'><a style='text-decoration: none; color: #502D73;' href='publicacao.php?idproduto=$idproduto'><DIV id='nome'><img style='object-position: center; object-fit: cover;' src='data:image/jpeg;base64,$capa' height='255' width='170'><h4 style='color: black;' class='margin'>$titulo</h4></DIV></a></TD>";
          }
          echo "</TABLE>";
        } else {
          echo "Não encontrado nenhum registro.";
        }

        echo "<H1 style='margin-bottom: 10px; margin-top: 20px;'>Usuários</H1>";
        if (mysqli_num_rows($pesqUsr) > 0) {
          echo "<TABLE>";
          while ($registroUsr = mysqli_fetch_assoc($pesqUsr)) {
            $id = $registroUsr["idusuario"];
            $usuario = $registroUsr["usuario"];
            $bytes = $registroUsr["imgPerfil"];

            $imgPerfil = base64_encode($bytes);


            echo "<TD style='margin: 0px 10px 0px 10px;'><DIV id='nome'><a href='perfil.php?id=$id'><img style='object-position: center; object-fit: cover; clip-path: circle(); width: 150px; height: 150px;' src='data:image/jpeg;base64,$imgPerfil'></a><h4 class='margin'>$usuario</h4></DIV></TD>";
          }
          echo "</TABLE>";
        } else {
          echo "Não encontrado nenhum registro.";
        }
      }
      ?>
    </div>

  </section>
</body>

</html>
