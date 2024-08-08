<?php
session_start();

// Verificar se o usuário está autenticado como administrador
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirecionar para a página de login se não estiver autenticado
    exit();
}

// Processar o formulário de registro de projeto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexão com o banco de dados (substitua com suas configurações)
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "phpprojetofinal";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Obter dados do formulário
    $user_id = $_POST['user_id'];  // Certifique-se de ter um campo oculto no formulário para armazenar o ID do usuário
    $data_criacao = $_POST['data_criacao'];
    $tecnologia_associada = $_POST['tecnologia_associada'];
    $status = $_POST['status'];

    // Processar a imagem
    $image_name = $_FILES['user_image']['name'];
    $image_tmp = $_FILES['user_image']['tmp_name'];
    $image_path = "images/" . $image_name;

    move_uploaded_file($image_tmp, $image_path);

    // Consulta para inserir um novo projeto na tabela projetos
    $sql_insert_projeto = "INSERT INTO projetos (user_id, data_criacao, tecnologia_associada, status, imagem) 
                           VALUES ('$user_id', '$data_criacao', '$tecnologia_associada', '$status', '$image_path')";

    if ($conn->query($sql_insert_projeto) === TRUE) {
        echo "<p>Projeto registrado com sucesso.</p>";
        // Redirecionar para evitar a reenvio do formulário ao recarregar a página
        header("Location: perfil_admin.php");
        exit();
    } else {
        echo "Erro ao registrar projeto: " . $conn->error;
    }

    $conn->close();
}

// Conexão com o banco de dados (substitua com suas configurações)
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "phpprojetofinal";

$conn = new mysqli($servername, $username, $password_db, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta para recuperar informações de todos os projetos
$sql_projetos = "SELECT * FROM projetos";
$result_projetos = $conn->query($sql_projetos);
?>

<!DOCTYPE html>
<html lang="pt">
 <head>
    <meta charset="utf-8">
    <title>Painel de Administração</title>  
    <script src="https://kit.fontawesome.com/d132031da6.js" crossorigin= "anonymous"></script>  
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
            background-color: #fff;
            color: #333;
            padding: 20px;
        }

        h1, h2, h3, h4 {
            color: #333;
        }

        /* Layout */
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .section {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="email"], input[type="date"], input[type="time"], select, input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #ccc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #999;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        #botaoSair {
            display: block;
            margin-top: 10px;
            background-color: #ccc;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 15px;
            cursor: pointer;
        }

        #botaoSair:hover {
            background-color: #999;
        }

        .degrade-horizontal {
            background: linear-gradient(to right, #87CEFA, #c75fc7);
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            outline: none;
            transition: background 0.3s ease;
        }

        .degrade-horizontal:hover {
            background: linear-gradient(to right, #c75fc7, #87CEFA);
        }

        

    </style>
 </head>
 <body>

    <div class="container">
        <h1>Painel de Administração</h1><br><br>

        <p style="text-align:center;"><img src="images/admin.jpg" alt="persona" width="20%" height="auto" style="border-radius:50%;"></p>

        <div class="caixa1 row" style="padding:50px;">
        <?php
        // Consulta para recuperar informações de todos os usuários
        $sql_users = "SELECT * FROM utilizadores";
        $result_users = $conn->query($sql_users);

        if ($result_users->num_rows > 0) {
            echo "<h2>Informações de Todos os Utilizadores:</h2>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Nome</th><th>Apelido</th><th>Nome de Utilizador</th><th>E-mail</th><th>Ações</th></tr>";

        while ($row = $result_users->fetch_assoc()) {
            $user_id = $row['user_id'];
            $nome = $row['nome'];
            $apelido = $row['apelido'];
            $user_name = $row['user_name'];
            $email = $row['email'];

                echo "<tr><td>$user_id</td><td>$nome</td><td>$apelido</td><td>$user_name</td><td>$email</td>";
                echo "<td><a href='editar_perfil_admin.php?user_id=$user_id'>Editar</a> | <a href='excluir_utilizador_admin.php?user_id=$user_id'>Excluir</a></td></tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Nenhum usuário encontrado.</p><br>";
        }
        

        // Consulta para listar todas as consultas marcadas
        $sql_consultas = "SELECT * FROM consultas";
        $result_consultas = $conn->query($sql_consultas);

        if ($result_consultas->num_rows > 0) {
            echo "<br><h2>Consultas Marcadas:</h2>";
            echo "<table>";
            echo "<tr><th>ID</th><th>ID do Utilizador</th><th>Data</th><th>Horário</th><th>Ações</th></tr>";

        while ($row = $result_consultas->fetch_assoc()) {
            $consulta_id = $row['id'];
            $user_id = $row['user_id'];
            $data = $row['data'];
            $horario = $row['horario'];

                echo "<tr><td>$consulta_id</td><td>$user_id</td><td>$data</td><td>$horario</td>";
                echo "<td><a href='editar_consulta_admin.php?consulta_id=$consulta_id'>Editar</a> | <a href='excluir_consulta_admin.php?consulta_id=$consulta_id'>Excluir</a></td></tr>";
            }

            echo "</table>";
        } else {
            echo "<p></p>";
        }
        ?><br><br>

        <!-- Seção de Adicionar Projeto -->
        <h2>Adicionar Novo Projeto</h2>
        <div class="section">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <!-- Campos do formulário para adicionar um novo projeto -->
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            
                <label for="data_criacao">Data de Criação:</label>
                <input type="date" id="data_criacao" name="data_criacao" required><br>

                <label for="tecnologia_associada">Tecnologia Associada:</label>
                <input type="text" id="tecnologia_associada" name="tecnologia_associada" required><br>

                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="marcado">Marcado</option>
                    <option value="em_progresso">Em Progresso</option>
                    <option value="terminado">Terminado</option>
                </select><br>

                <label for="user_image">Imagem do Projeto:</label>
                <input type="file" id="user_image" name="user_image" accept="image/*" required><br>

                <input id="botaoSair" class="degrade-horizontal" type="submit" value="Registrar Projeto">
            </form>
        </div><br>

        <h2>Projetos Registados</h2>
        <div class="section">
            <?php
            if ($result_projetos->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>ID</th><th>ID do Usuário</th><th>Data de Criação</th><th>Tecnologia Associada</th><th>Status</th><th>Imagem</th></tr>";

            while ($row = $result_projetos->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . (isset($row['projeto_id']) ? $row['projeto_id'] : 'N/A') . "</td>";
                echo "<td>" . (isset($row['user_id']) ? $row['user_id'] : 'N/A') . "</td>";
                echo "<td>" . (isset($row['data_criacao']) ? $row['data_criacao'] : 'N/A') . "</td>";
                echo "<td>" . (isset($row['tecnologia_associada']) ? $row['tecnologia_associada'] : 'N/A') . "</td>";
                echo "<td>" . (isset($row['status']) ? $row['status'] : 'N/A') . "</td>";
                echo "<td><img src='" . (isset($row['imagem']) ? $row['imagem'] : '') . "' width='100'></td>";
                echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>Nenhum projeto encontrado.</p>";
            }
            ?>
        </div><br><br>

        <a href="index.php" id="botaoSair" class="degrade-horizontal">Logout</a>

        </div>
</div>

</body>
</html>
