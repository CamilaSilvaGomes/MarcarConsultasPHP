<?php
session_start();

// Verificar se o usuário está autenticado como administrador (você pode adicionar verificação aqui)

// Conexão com o banco de dados (substitua com suas configurações)
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "phpprojetofinal";

$conn = new mysqli($servername, $username, $password_db, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os dados do formulário
    $consulta_id = $_POST['consulta_id'];
    $data = $_POST['data'];
    $horario = $_POST['horario'];

    // Atualize os dados da consulta na base de dados
    $sql_update = "UPDATE consultas SET data = '$data', horario = '$horario' WHERE id = $consulta_id";

    if ($conn->query($sql_update) === TRUE) {
        echo "Consulta atualizada com sucesso.";
    } else {
        echo "Erro na atualização: " . $conn->error;
    }
}

// Recupere as informações da consulta com base no ID
if (isset($_GET['consulta_id'])) {
    $consulta_id = $_GET['consulta_id'];

    $sql = "SELECT * FROM consultas WHERE id = $consulta_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $data = $row['data'];
        $horario = $row['horario'];
    } else {
        echo "Consulta não encontrada.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Editar Consulta</title>
</head>
<body>
    <h2>Editar Consulta</h2>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="consulta_id" value="<?php echo $consulta_id; ?>">

        <label for="data">Data:</label>
        <input type="date" id="data" name="data" value="<?php echo $data; ?>" required><br><br>

        <label for="horario">Horário:</label>
        <input type="time" id="horario" name="horario" value="<?php echo $horario; ?>" required><br><br>

        <input type="submit" value="Salvar Alterações">
    </form>

    <p><a href="perfil_admin.php">Voltar para a Página do Administrador</a></p>
</body>
</html>
