<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber os dados do formulário de login
    $user_name = $_POST['user_name']; // Alterado de 'email' para 'user_name'
    $password = $_POST['password']; // Alterado de 'pass' para 'password'

    // Conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "phpprojetofinal";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Verificar a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Consulta para verificar as credenciais do usuário
    $sql = "SELECT user_id, user_type FROM utilizadores WHERE user_name = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user_name, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        die("Erro na consulta SQL: " . $conn->error);
    }

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id']; // Definir a variável de sessão após a autenticação bem-sucedida

        if ($row['user_type'] === 'utilizador') {
            header("Location: perfil_utilizador.php"); // Redirecionar para o perfil do utilizador
        } elseif ($row['user_type'] === 'administrador' && $user_name === 'admin' && $password === 'admin1234') {
            header("Location: perfil_admin.php"); // Redirecionar para o perfil do administrador
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
    <title>Login V2</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->    
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->    
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->    
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
    <?php
        if (isset($login_error)) {
            echo '<p class="error-message">' . $login_error . '</p>';
        }
    ?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <span class="login100-form-title p-b-26">
                        WELCOME
                    </span>
                    <span class="login100-form-title p-b-48">
                        <i class="zmdi zmdi-font"></i>
                    </span>

                    <div class="wrap-input100 validate-input" data-validate = "E-mail válido é: a@b.c">
                        <input class="input100" type="text" name="user_name">
                        <span class="focus-input100" data-placeholder="Name"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Digite a senha">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="input100" type="password" name="password">
                        <span class="focus-input100" data-placeholder="Password"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn">
                                Login
                            </button>
                        </div>
                    </div>

                    <div class="text-center p-t-115">
                        <span class="txt1">
                            Don't have an account? 
                        </span>

                        <a href="pagina_de_registro.html" class="txt2" href="#">Register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    <div id="dropDownSelect1"></div>
    
<!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
    <script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
    <script src="js/main.js"></script>

</body>
</html>