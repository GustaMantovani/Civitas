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
  <link rel="stylesheet" href="css/explorar.css">
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
        <a href="lista.php" alt="livros com interesse"><img src="img/livros.png" width="16.5px"></a>
      </div>

      <form action="pesquisa.php">

        <div id="divBusca">
          <input type="text" id="txtBusca" name="txtpesq" placeholder="PESQUISA" class="espacamento" />
          <button id="btnBusca" type="submit"><img src="img/search1.png" alt="Buscar" class="espacamento" /></button>
        </div>
      </form>
    </aside>

  </header>

  <section id="obras">
    <div>
      <div id="topo">
        <a href="explorar.php" id="tituloExplorar">
          <H2>Explore</H2>
        </a>
        <a href="formObra.php"><button class="btn" style="font-size: 10pt;">Sugerir uma Obra</button></a>
      </div>
      <hr style="margin-top: 5px; margin-bottom: 5px; color: blueviolet;">
      <TABLE>
        <TR>
          <?php
          require_once '../modelo/conexaoBD.php';
          require_once '../modelo/tipoDAO.php';
          require_once '../controlador/funcoes.php';
          require_once '../modelo/publicacaoDAO.php';
          $conexao =  conectarBD();

          if (isset($_GET["idTipo"])) {
            $idTipo = $_GET["idTipo"];
            $respostaCb = exibirTipo($conexao, $idTipo);
          } else {
            $respostaCb = exibirTipo($conexao, null);
          }



          echo "<div id='ecolhaTipos'>$respostaCb</div>";

          require_once '../modelo/obrasDAO.php';

          if (empty($_GET["idTipo"])) {
            $resultado = exibirObrasAprovadasPorAdicao($conexao);

            while ($registro = mysqli_fetch_assoc($resultado)) {
              $idproduto = $registro["idproduto"];
              $titulo = $registro["titulo"];
              $descricao = $registro["descricao"];
              $bytes = $registro["capa"];
              $capa = base64_encode($bytes);

              if (calcularMediaAvalObra($conexao, $idproduto) != -1) {
                $mediaAval = montarAvalComem(calcularMediaAvalObra($conexao, $idproduto));
              } else {
                $mediaAval = "";
              }

              echo "<TD>
                                    <div id='linkObra'>
                                        <a  href='publicacao.php?idproduto=$idproduto'>
                                            <img style='object-position: center; object-fit: cover;' src='data:image/jpeg;base64,$capa' height='255' width='170'>
                                        </a>
                                        <div id='infos'>
                                            <div style='display: flex; flex-direction: row;'>
                                                <h4>$titulo</h4>
                                                <p style='margin-left: 5px;'>$mediaAval</p>
                                            </div>
                                            <p id='descricao'>$descricao</p>
                                        </div>
                                    </div>
                                </TD>";
            }
          } else {
            $resultado = exibirObrasAprovadasPorTipo($conexao, $idTipo);

            while ($registro = mysqli_fetch_assoc($resultado)) {
              $idproduto = $registro["idproduto"];
              $titulo = $registro["titulo"];
              $descricao = $registro["descricao"];
              $bytes = $registro["capa"];
              $capa = base64_encode($bytes);

              if (calcularMediaAvalObra($conexao, $idproduto) != -1) {
                $mediaAval = montarAvalComem(calcularMediaAvalObra($conexao, $idproduto));
              } else {
                $mediaAval = "";
              }

              echo "<TD>
                                    <div id='linkObra'>
                                        <a  href='publicacao.php?idproduto=$idproduto'>
                                            <img style='object-position: center; object-fit: cover;' src='data:image/jpeg;base64,$capa' height='255' width='170'>
                                        </a>
                                        <div id='infos'>
                                            <div style='display: flex; flex-direction: row;'>
                                                <h4>$titulo</h4>
                                                <p style='margin-left: 5px;'>$mediaAval</p>
                                            </div>
                                            <p id='descricao'>$descricao</p>
                                        </div>
                                    </div>
                                </TD>";
            }
          }
          ?>
        </TR>
      </TABLE>
    </div>
  </section>

</body>

</html>
