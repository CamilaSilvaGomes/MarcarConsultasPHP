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
    $user_id = $_POST['user_id'];
    $nome = $_POST['nome'];
    $apelido = $_POST['apelido'];
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];

    // Atualize os dados do usuário na base de dados
    $sql_update = "UPDATE utilizadores SET nome = '$nome', apelido = '$apelido', user_name = '$user_name', email = '$email' WHERE user_id = $user_id";

    if ($conn->query($sql_update) === TRUE) {
        echo "Dados do usuário atualizados com sucesso.";
    } else {
        echo "Erro na atualização: " . $conn->error;
    }
}

// Recupere as informações do usuário com base no ID
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $sql = "SELECT * FROM utilizadores WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nome = $row['nome'];
        $apelido = $row['apelido'];
        $user_name = $row['user_name'];
        $email = $row['email'];
    } else {
        echo "Usuário não encontrado.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Editar Perfil do Usuário</title>
</head>
<body>
    <h2>Editar Perfil do Usuário</h2>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>" required><br><br>

        <label for="apelido">Apelido:</label>
        <input type="text" id="apelido" name="apelido" value="<?php echo $apelido; ?>" required><br><br>

        <label for="user_name">Nome de Utilizador:</label>
        <input type="text" id="user_name" name="user_name" value="<?php echo $user_name; ?>" required><br><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br><br>

        <input type="submit" value="Salvar Alterações">
    </form>

    <p><a href="perfil_admin.php">Voltar para a Página do Administrador</a></p>
</body>
</html>
