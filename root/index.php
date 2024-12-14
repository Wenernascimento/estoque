<?php
session_start();
require_once 'db.php'; // Conexão com o banco de dados

$erro = ''; // Inicializa a variável de erro

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Verifica se ambos os campos foram preenchidos
    if (!empty($username) && !empty($password)) {
        // Consulta para verificar se o nome de usuário existe no banco
        $sql = "SELECT * FROM usuarios WHERE username = :username LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Depuração: Mostra o conteúdo da variável $usuario
        var_dump($usuario); // Para depurar e entender o que está sendo retornado do banco de dados

        // Verifica se o usuário foi encontrado
        if ($usuario) {
            // Verifica se a senha foi recuperada corretamente do banco e não é null
            if (isset($usuario['senha']) && !empty($usuario['senha'])) {
                // Agora podemos verificar a senha
                if (password_verify($password, $usuario['senha'])) {
                    // Se a autenticação for bem-sucedida
                    $_SESSION['user_id'] = $usuario['id'];
                    $_SESSION['username'] = $usuario['username'];

                    // Verifica se o usuário é admin
                    if ($usuario['role'] == 'admin') {
                        $_SESSION['role'] = 'admin'; // Marca como admin
                    } else {
                        $_SESSION['role'] = 'user'; // Marca como user
                    }

                    header('Location: index.php'); // Redireciona para a página inicial
                    exit(); // Interrompe o script após o redirecionamento
                } else {
                    // Se a senha estiver incorreta
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
