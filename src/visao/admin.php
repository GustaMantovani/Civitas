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
  <link rel="stylesheet" href="css/admin.css">
  <link rel="shortcut icon" href="img/icons/owl-ico.ico" type="image/x-icon">
  <title>Civitas</title>

  <style>
    #aside_cabecalho {
      position: relative;
      display: flex;
      flex-direction: row;
      margin-right: 15px;
    }
  </style>
</head>

<body>

  <header id="header">
    <div id="position_title">
      <img src="img/title.png" alt="Civias" width="200px">
    </div>

    <di></di>

    <aside id="aside_cabecalho">
      <a href="../controlador/logout.php"><img width="20px" src="img/sairAdm.png"></a>
    </aside>
  </header>

  <section id="escolha">
    <a href="obras.php" class="opcao">
      <img height="72px" src="img/livrosIcone.png">
      <h2>Obras</h2>
    </a>

    <a href="usuarios.php" class="opcao">
      <img heigth="72px" width="50px" src="img/iconePerfil.png">
      <h2>Usuários</h2>
    </a>
  </section>

</body>

</html>
