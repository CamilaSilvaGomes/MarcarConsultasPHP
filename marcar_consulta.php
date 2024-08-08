<?php
session_start();

// Verifique se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirecione para a página de login se não estiver autenticado
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os dados da consulta do formulário
    $data = $_POST['data'];
    $horario = $_POST['horario'];

    // Valide os dados da consulta conforme necessário

    // Conecte-se ao banco de dados
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "phpprojetofinal";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Insira os dados da consulta no banco de dados (substitua com sua lógica)
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO consultas (user_id, data, horario) VALUES ('$user_id', '$data', '$horario')";

    if ($conn->query($sql) === TRUE) {
        echo "Consulta marcada com sucesso.";
    } else {
        echo "Erro ao marcar a consulta: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Marcar Consulta</title>
</head>
<body>

 
    <p><a href="perfil_utilizador.php">Voltar para o Perfil</a></p>
</body>
</html>
