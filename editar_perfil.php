<?php
session_start();

// Verificar a autenticação do usuário
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redireciona para a página de login se o usuário não estiver autenticado
    exit();
}

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpprojetofinal";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Supondo que você tenha uma maneira de identificar o usuário logado (por exemplo, usando uma sessão)
$user_id = $_SESSION['user_id']; // Certifique-se de configurar a sessão corretamente

// Consulta para obter os dados atuais do usuário
$sql = "SELECT * FROM utilizadores WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    $row = null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receba os dados do formulário de edição
    $novo_nome = $_POST['novo_nome'];
    $novo_password = $_POST['novo_password'];

    // Consulta para atualizar os dados do usuário
    $sql_update = "UPDATE utilizadores SET nome = '$novo_nome', password = '$novo_password' WHERE user_id = $user_id";
    
    if ($conn->query($sql_update) === TRUE) {
        echo "Dados atualizados com sucesso.";
        // Você pode redirecionar o usuário de volta para a página de perfil aqui
        echo '<a href="perfil_utilizador.php">Voltar ao Perfil</a>';
    } else {
        echo "Erro ao atualizar os dados: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Perfil</title>
</head>
<body>
    <h2>Editar Perfil</h2>
    
    <?php
    // Exibir o formulário de edição aqui
    ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="novo_nome">Novo Nome:</label>
        <input type="text" id="novo_nome" name="novo_nome" value="<?php echo $row['nome']; ?>" required><br><br>

        <label for="novo_password">Novo password:</label>
        <input type="password" id="novo_password" name="novo_password" value="<?php echo $row['password']; ?>" required><br><br>

       
        <input type="submit" value="Salvar Alterações">
    </form>
</body>
</html>
