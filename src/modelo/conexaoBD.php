<?php
//Conexão com o banco de dados
function conectarBD()
{
  // Dados de conexão com o banco de dados
  $serverName = getenv('DB_HOSTNAME'); // Endereço do servidor do banco de dados
  $username = getenv('MYSQL_USER'); // Nome de usuário do banco de dados
  $password = getenv('MYSQL_ROOT_PASSWORD');   // Senha do banco de dados
  $dbname = getenv('DB_NAME'); // Nome do banco de dados que você deseja conectar
  // Estabelecer a conexão com o banco de dados
  $connection = mysqli_connect($serverName, $username, $password, $dbname);
  //Setando padrão de codificação utf8
  mysqli_query($connection, "SET NAMES 'utf8'");
  mysqli_query($connection, "SET character_set_connection=utf8");
  mysqli_query($connection, "SET character_set_client=utf8");
  mysqli_query($connection, "SET character_set_results=utf8");
  return $connection;
}
