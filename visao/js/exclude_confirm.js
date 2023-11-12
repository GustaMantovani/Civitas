function confirmarExclusao(idUsuario) {
  var resposta = confirm("Tem certeza que deseja excluir este usuário?");

  if (resposta) {
    window.location.href = "../controlador/excluirUsr.php?id=" + idUsuario;
  } else {
    return false;
  }
}

