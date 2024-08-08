<?php
// Configurações do banco de dados
$servername = "localhost"; // Nome do host
$username = "root"; // Nome de usuário
$password = ""; // Senha
$dbname = "phpprojetofinal"; // Nome do banco de dados

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}
?>