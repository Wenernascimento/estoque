<?php
// Conexão com o banco de dados
$pdo = new PDO('mysql:host=localhost;dbname=estoque', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Verifica se o ID da venda foi passado via GET
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idVenda = $_GET['id'];

    try {
        // Prepara e executa o comando para excluir a venda
        $stmt = $pdo->prepare("DELETE FROM vendas WHERE id = :id");
        $stmt->bindParam(':id', $idVenda, PDO::PARAM_INT);
        $stmt->execute();

        // Redireciona para a página index.php após a exclusão
        header("Location: index.php");  // Aqui foi alterado para redirecionar para o index.php
        exit();  // Garantir que o script seja interrompido após o redirecionamento
    } catch (PDOException $e) {
        // Caso haja algum erro, exibe uma mensagem
        echo "Erro ao excluir a venda: " . $e->getMessage();
    }
} else {
    // Caso o ID não seja fornecido via GET
    echo "ID da venda não fornecido.";
}
?>
