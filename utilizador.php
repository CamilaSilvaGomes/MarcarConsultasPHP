<?php
session_start();

// Verifique se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redireciona para a página de login se não estiver autenticado
    exit();
}

// Recupere as informações do usuário a partir do banco de dados (substitua com a sua lógica)
$user_id = $_SESSION['user_id'];
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "phpprojetofinal";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT nome, apelido, user_name, password  FROM utilizadores WHERE user_id = $user_id";
$result = $conn->query($sql);

if (!$result) {
    die("Erro na consulta SQL: " . $conn->error);
}

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $nome = $row['nome'];
    $apelido = $row['apelido'];
    $user_name = $row['user_name'];
    $password = $row['password'];
} else {
    echo "Perfil de usuário não encontrado.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <title>Perfil do Utilizador</title>
    <style>
        /* Reset de estilos */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* Fontes */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
        }

        h1, h2, h3, h4 {
            font-family: Arial, sans-serif;
            color: #333;
        }

        /* Layout */
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #ccc; /* Alteração da cor para cinza */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #999; /* Alteração da cor para um tom mais escuro de cinza */
        }

        .consultation-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .consultation-table th, .consultation-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .consultation-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Perfil do Utilizador</h1><br>

    <?php

    // Verifique se o usuário está autenticado
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php"); // Redireciona para a página de login se não estiver autenticado
        exit();
    }

    // Recupere as informações do usuário a partir do banco de dados (substitua com a sua lógica)
    $user_id = $_SESSION['user_id'];
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "phpprojetofinal";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $sql = "SELECT nome, apelido, user_name, email FROM utilizadores WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if (!$result) {
        die("Erro na consulta SQL: " . $conn->error);
    }

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nome = $row['nome'];
        $apelido = $row['apelido'];
        $user_name = $row['user_name'];
        $email = $row['email'];
    } else {
        echo "Perfil de usuário não encontrado.";
    }

    $conn->close();
    ?>

    <h2>Dados Pessoais</h2><br>
    <form action="editar_perfil.php" method="post">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="apelido">Apelido:</label>
            <input type="text" id="apelido" name="apelido" value="<?php echo $apelido; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="user_name">User Name:</label>
            <input type="text" id="user_name" name="user_name" value="<?php echo $user_name; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" readonly>
        </div>
        <div class="form-group">
            <input type="submit" value="Editar">
        </div>
    </form>

    <h2>Marcar Consulta</h2><br>
    <form action="marcar_consulta.php" method="post">
        <div class="form-group">
            <label for="data">Data da Consulta:</label>
            <input type="date" id="data" name="data" required>
        </div>
        <div class="form-group">
            <label for="horario">Horário da Consulta:</label>
            <input type="time" id="horario" name="horario" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Marcar Consulta">
        </div>
    </form>

    <h2>Consultas Agendadas</h2>
    <table class="consultation-table">
        <thead>
            <tr>
                <th>Data</th>
                <th>Hora</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
        // Conecte-se ao banco de dados
        $servername = "localhost";
        $username = "root";
        $password_db = "";
        $dbname = "phpprojetofinal";

        $conn = new mysqli($servername, $username, $password_db, $dbname);

        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        // Recupere as consultas agendadas do usuário
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT id, data, horario FROM consultas WHERE user_id = '$user_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $consulta_id = $row['id']; // Defina o ID da consulta
                $data = $row['data'];
                $horario = $row['horario'];

                // Exiba cada consulta agendada em uma linha da tabela
                echo "<tr>";
                echo "<td>$data</td>";
                echo "<td>$horario</td>";
                echo "<td>";
                echo "<a href='editar_consulta.php?id=$consulta_id' >Editar</a> | ";
                echo "<a href='excluir_consulta.php?id=$consulta_id'>Excluir</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nenhuma consulta agendada.</td></tr>";
        }

        $conn->close();
        ?>
        </tbody>
    </table><br><br>

    <a href="index.php" id="botaoSair">Logout</a>
</div>

</body>
</html>
