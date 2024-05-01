<?php
function sessionUpdate($conexao)
{
  session_start();
  $id = $_SESSION["idSessao"];

  $usr = pesquisarUsrporID($conexao, $id);
  $registro = mysqli_fetch_assoc($usr);

  $usuario = $registro["usuario"];

  $bytes = $registro["imgPerfil"];
  $imgPerfil = base64_encode($bytes);

  $_SESSION["imgSessao"] = $imgPerfil;
  $_SESSION["usrSessao"] = $usuario;
}

