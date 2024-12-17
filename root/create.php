<?php
// Inicia a sessão
session_start();

// Inclui o arquivo de configuração do banco de dados
require_once 'db.php';

$erro = ''; // Variável de erro

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário e limpa
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = 'user'; // Atribui o role padrão como 'user'

    // Verifica se os campos não estão vazios
    if (!empty($username) && !empty($password)) {
        // Cria um hash da senha
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Consulta para verificar se o nome de usuário já existe no banco
        $sql = "SELECT * FROM usuarios WHERE username = :username LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $erro = 'Nome de usuário já existe!';
        } else {
            // Caso não exista, insere o novo usuário no banco de dados
            $sql = "INSERT INTO usuarios (username, senha, role) VALUES (:username, :password, :role)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'username' => $username,
                'password' => $hashed_password,
                'role' => $role
            ]);

            $_SESSION['user_id'] = $conn->lastInsertId();
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role; // Salva o role na sessão

            header('Location: listar.php'); // Redireciona para a página inicial
            exit();
        }
    } else {
        $erro = 'Por favor, preencha todos os campos!';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuário</title>
</head>
<body>
    <h2>Registrar Novo Usuário</h2>
    <form method="POST" action="">
        <label for="username">Nome de usuário:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Senha:</label>
        <input type="password" name="password" id="password" required><br><br>

        <input type="submit" value="Registrar">
    </form>

    <?php if (!empty($erro)): ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php endif; ?>
</body>
</html>
