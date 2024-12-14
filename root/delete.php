<?php
session_start();
require_once 'db.php';
require_once 'Usuario.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Acesso restrito! Somente administradores podem acessar essa página.");
}

$usuarios = new Usuario($conn);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($usuarios->deletar($id)) {
        echo "Usuário deletado com sucesso!";
        header('Location: index.php'); // Redireciona de volta para a lista de usuários
        exit();
    } else {
        echo "Erro ao deletar usuário.";
    }
}
?>
