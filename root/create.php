<?php
session_start();
require_once 'db.php';
require_once 'Usuario.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Acesso restrito! Somente administradores podem acessar essa página.");
}

$usuarios = new Usuario($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    
    if ($usuarios->criar($username, $email, $senha)) {
        echo "Usuário criado com sucesso!";
    } else {
        echo "Erro ao criar usuário.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
</head>
<body>
    <h2>Cadastrar Novo Usuário</h2>
    <form method="POST">
        <label for="username">Nome de usuário:</label>
        <input type="text" name="username" required><br><br>

        <label for="email">E-mail:</label>
        <input type="email" name="email" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required><br><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
