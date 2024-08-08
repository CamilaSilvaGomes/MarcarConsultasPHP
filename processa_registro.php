<?php
session_start();

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpprojetofinal";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpar dados de entrada
    $nome = $_POST["nome"];
    $apelido = $_POST["apelido"];
    $user_name = $_POST["user_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Consulta para verificar se o email já está em uso
    $check_email_query = "SELECT * FROM utilizadores WHERE email=?";
    $stmt = $conn->prepare($check_email_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Se houver resultados, significa que o email já está em uso
        echo "Erro: O endereço de e-mail já está em uso. Por favor, escolha outro.";
    } else {
        // Preparar e executar a inserção de dados
        $sql = "INSERT INTO utilizadores (nome, apelido, user_name, email, password, user_type) VALUES (?, ?, ?, ?, ?, 'utilizador')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $nome, $apelido, $user_name, $email, $password);
        
        if ($stmt->execute()) {
            // Registro bem-sucedido, redireciona para a página de login
            header("Location: login.php");
            exit(); // Certifica-se de que o script seja encerrado após o redirecionamento
        } else {
            echo "Erro ao registar: " . $stmt->error;
        }
    }

    $stmt->close(); // Fechar declaração preparada
}

$conn->close(); // Fechar conexão com o banco de dados
?>
