<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  require_once '../modelo/conexaoBD.php';
  $conexao = conectarBD();

  require_once '../controlador/funcoes.php';

  $usrLogado = mysqli_real_escape_string($conexao, htmlspecialchars(trim($_POST["txtLogin"]), ENT_QUOTES, 'UTF-8'));
  $senha = mysqli_real_escape_string($conexao, htmlspecialchars(trim($_POST["txtSenha"]), ENT_QUOTES, 'UTF-8'));

  $msgErro = validarCamposLogin($usrLogado, $senha);

  if (empty($msgErro)) {
    require_once '../modelo/usuariosDAO.php';

    $resgistro = validarLogin($conexao, $usrLogado, $senha);

    if (isset($resgistro)) {
      $id = $resgistro["idusuario"];
      $nome = $resgistro["nome"];
      $email = $resgistro["email"];
      $cpf = $resgistro["cpf"];
      $tipo = $resgistro["tipo"];

      $dataBD = $resgistro["dataNasc"];
      $dataNasc = converterDataBD($dataBD);

      $imgBin = $resgistro["imgPerfil"];
      $imgPerfil = base64_encode($imgBin);

      session_start();
      $_SESSION["idSessao"] = $id;
      $_SESSION["nomeSessao"] = $nome;
      $_SESSION["usrSessao"] = $usrLogado;
      $_SESSION["emailSessao"] = $email;
      $_SESSION["dtSessao"] = $dataNasc;
      $_SESSION["cpfSessao"] = $cpf;
      $_SESSION["imgSessao"] = $imgPerfil;
      $_SESSION["tipoSessao"] = $tipo;
      $_SESSION["lista"] = array();

      switch ($tipo) {
        case 1:
          header("Location:../visao/admin.php");
          break;
        case 2:
          header("Location:../visao/explorar.php");
          break;
      }
    } else {
      header("Location:../visao/login.php?msg=Login e/ou senha inválidos.");
    }
  } else {
    header("Location:../visao/login.php?msg=$msgErro");
  }
}

