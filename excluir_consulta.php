<?php
session_start();

// Verifique se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirecione para a página de login se não estiver autenticado
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Recupere o ID da consulta da URL
    $consulta_id = $_GET['id'];

    // Conecte-se ao banco de dados
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "phpprojetofinal";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Verifique se a consulta pertence a este usuário antes de excluí-la
    $user_id = $_SESSION['user_id'];
    $sql = "DELETE FROM consultas WHERE id = $consulta_id AND user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Consulta excluída com sucesso.";
    } else {
        echo "Erro ao excluir a consulta: " . $conn->error;
    }

    $conn->close();
} else {
    echo "ID de consulta não especificado.";
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Excluir Consulta</title>
</head>
<body>
    <h2>Excluir Consulta</h2>

    <p>Esta consulta foi excluída.</p>

    <p><a href="perfil_utilizador.php">Voltar para o Perfil</a></p>
</body>
</html>
