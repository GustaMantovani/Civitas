<?php
//Conexão com o banco de dados
function conectarBD(){
    // Dados de conexão com o banco de dados
    $servername = "endereco_do_servidor_de_banco_de_dados"; // Endereço do servidor do banco de dados
    $username = "seu_usuario"; // Nome de usuário do banco de dados
    $password = "sua_senha";   // Senha do banco de dados
    $dbname = "seu_banco_de_dados"; // Nome do banco de dados que você deseja conectar
    // Estabelecer a conexão com o banco de dados
    $conexao = mysqli_connect($servername, $username, $password, $dbname);
    //Setando padrão de codificação utf8
    mysqli_query($conexao, "SET NAMES 'utf8'");
    mysqli_query($conexao, "SET character_set_connection=utf8");
    mysqli_query($conexao, "SET character_set_client=utf8");
    mysqli_query($conexao, "SET character_set_results=utf8");
    return $conexao;
}
?>