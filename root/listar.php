<?php
session_start();
require_once 'db.php'; // Conexão com o banco de dados

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redireciona para login se não estiver logado
    exit();
}

// Consulta para pegar todos os usuários cadastrados
$sql = "SELECT id, username, role FROM usuarios"; // Seleciona id, username e role
$stmt = $conn->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC); // Pega todos os usuários como um array associativo
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários Cadastrados</title>
    <style>
        /* Estilo básico para a tabela */
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Usuários Cadastrados</h2>

    <!-- Tabela para exibir os usuários -->
    <table>
        <tr>
            <th>ID</th>
            <th>Nome de Usuário</th>
            <th>Role</th>
        </tr>
        
        <!-- Loop para exibir cada usuário -->
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                <td><?php echo htmlspecialchars($usuario['username']); ?></td>
                <td><?php echo htmlspecialchars($usuario['role']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
