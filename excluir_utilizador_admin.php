<?php
session_start();

// Verificar se o usuário está autenticado como administrador
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirecionar para a página de login se não estiver autenticado
    exit();
}

// Verificar se o ID do usuário a ser excluído foi especificado na URL
if (!isset($_GET['user_id'])) {
    die("ID do usuário não especificado.");
}

// Recuperar o ID do usuário da URL
$user_id = $_GET['user_id'];

// Conexão com o banco de dados (substitua com suas configurações)
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "phpprojetofinal";

$conn = new mysqli($servername, $username, $password_db, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o usuário tem consultas marcadas
$sql_verificar_consultas = "SELECT * FROM consultas WHERE user_id = $user_id";
$result_verificar_consultas = $conn->query($sql_verificar_consultas);

if ($result_verificar_consultas->num_rows > 0) {
    echo "Este usuário não pode ser excluído porque tem consultas marcadas.";
    echo "<br><a href='perfil_admin.php'>Voltar para a página de administrador</a>";
    exit();
}

// Consulta para excluir o usuário
$sql_excluir_usuario = "DELETE FROM utilizadores WHERE user_id = $user_id";

if ($conn->query($sql_excluir_usuario) === TRUE) {
    echo "Usuário excluído com sucesso.<br>";
    echo "<a href='perfil_admin.php'>Voltar para a página de administrador</a>";
} else {
    echo "Erro ao excluir o usuário: " . $conn->error;
}

$conn->close();
?>
