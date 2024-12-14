<?php
// Inicia a sessão
session_start();

// Inclui o arquivo de configuração do banco de dados
require_once 'db.php';

$erro = ''; // Inicializa a variável de erro

// Verifica se o formulário foi enviado (com método POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário e limpa
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Verifica se ambos os campos foram preenchidos
    if (!empty($username) && !empty($password)) {
        // Consulta para verificar se o nome de usuário existe no banco
        $sql = "SELECT * FROM usuarios WHERE username = :username LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o usuário foi encontrado
        if ($usuario) {
            // Verifica se a senha foi recuperada corretamente (a chave correta é 'senha')
            if (isset($usuario['senha']) && !empty($usuario['senha'])) {
                // Verifica se a senha fornecida corresponde ao hash da senha armazenado
                if (password_verify($password, $usuario['senha'])) {
                    // Se a autenticação for bem-sucedida
                    $_SESSION['user_id'] = $usuario['id'];
                    $_SESSION['username'] = $usuario['username'];
                    header('Location: index.php'); // Redireciona para a página inicial
                    exit(); // Interrompe o script após o redirecionamento
                } else {
                    // Se a senha ou o nome de usuário estiverem incorretos
                    $erro = 'Nome de usuário ou senha inválidos!';
                }
            } else {
                // Se a senha não foi encontrada ou está vazia
                $erro = 'Erro ao recuperar a senha do banco de dados!';
            }
        } else {
            // Se o usuário não for encontrado
            $erro = 'Nome de usuário não encontrado!';
        }
    } else {
        // Se algum dos campos estiver vazio
        $erro = 'Por favor, preencha ambos os campos!';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Estilo global */
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('sua-imagem.jpg'); /* Altere o caminho para a sua imagem */
            background-size: cover; /* Faz a imagem cobrir toda a tela */
            background-position: center; /* Centraliza a imagem */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #fff; /* Ajusta a cor do texto para branco para maior contraste */
        }

        /* Estilo do container do login */
        .login-container {
            background-color: rgba(255, 255, 255, 0.8); /* Fundo branco translúcido */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 30px;
            color: #333;
        }

        label {
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #4e54c8; /* Cor de foco no campo */
            outline: none;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Estilo da mensagem de erro */
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>

        <!-- Formulário de login -->
        <form method="POST" action="">
            <label for="username">Nome de usuário:</label>
            <input type="text" name="username" id="username" required><br><br>

            <label for="password">Senha:</label>
            <input type="password" name="password" id="password" required><br><br>

            <input type="submit" value="Entrar">
        </form>

        <!-- Exibe a mensagem de erro, se houver -->
        <?php if (!empty($erro)): ?>
            <p class="error-message"><?php echo $erro; ?></p>
        <?php endif; ?>
    </div>

</body>
</html>
