<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receba os dados do formulário de login (substitua com os dados reais do formulário)
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    // Conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "phpprojetofinal";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Verifique a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Consulta para verificar as credenciais do usuário
    $sql = "SELECT user_id, user_type FROM utilizadores WHERE user_name = '$user_name' AND password = '$password'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Erro na consulta SQL: " . $conn->error);
    }

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id']; // Defina a variável de sessão após a autenticação bem-sucedida

        if ($row['user_type'] === 'utilizador') {
            header("Location: perfil_utilizador.php"); // Redireciona para o perfil do utilizador
        } elseif ($row['user_type'] === 'administrador' && $user_name === 'admin' && $password === 'admin1234') {
            header("Location: perfil_admin.php"); // Redireciona para o perfil do administrador
        } else {
            $login_error = "Papel desconhecido.";
        }

        exit();
    } else {
        $login_error = "Nome de usuário ou senha incorretos.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Página de Login</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    text-align: center;
}

h2 {
    color: #333;
}

.error-message {
    color: red;
}

label {
    font-weight: bold;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 3px;
}

input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}
input[type="submit"]:hover {
    background-color: #0056b3;
}

</style>
</head>
<body>
   
    <h2>Login</h2>
<?php
if (isset($login_error)) {
    echo '<p class="error-message">' . $login_error . '</p>';
}
?>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="user_name">Nome de Utilizador:</label>
    <input type="text" id="user_name" name="user_name" required><br><br>

    <label for="password">Senha:</label>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Entrar">
</form>


    <p>Não está registado? <a href="pagina_de_registro.html">Registe-se aqui</a></p>
</body>
</html>
