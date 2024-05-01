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
  <script src="js/rating.js"></script>
  <title>Civitas</title>
  <script type="text/javascript" src="https://www.google.com/books/jsapi.js"></script>
  <script type="text/javascript">
    google.books.load();


    const urlParams = new URLSearchParams(window.location.search);
    const isbnValue = urlParams.get('isbn');

    function initialize() {
      var viewer = new google.books.DefaultViewer(document.getElementById('viewerCanvas'));
      viewer.load('ISBN:' + isbnValue);
    }

    google.books.setOnLoadCallback(initialize);
  </script>
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
  <section style="height: 91.4vh;">
    <div id="viewerCanvas" style="height: 100%"></div>
  </section>

</body>

</html>
