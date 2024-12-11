<?php
// Conexão com o banco de dados
$pdo = new PDO('mysql:host=localhost;dbname=estoque', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Verifica se o ID da venda foi passado
if (isset($_GET['id'])) {
    $idVenda = $_GET['id'];

    // Busca as informações da venda no banco
    $stmt = $pdo->prepare("SELECT * FROM vendas WHERE id = :id");
    $stmt->bindParam(':id', $idVenda, PDO::PARAM_INT);
    $stmt->execute();
    $venda = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$venda) {
        die("Venda não encontrada.");
    }

    // Processa a edição quando o formulário for enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $quantidade = $_POST['quantidade'];
        $formaPagamento = $_POST['forma_pagamento'];

        // Atualiza as informações da venda
        $stmt = $pdo->prepare("UPDATE vendas SET quantidade = :quantidade, forma_pagamento = :forma_pagamento WHERE id = :id");
        $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindParam(':forma_pagamento', $formaPagamento, PDO::PARAM_STR);
        $stmt->bindParam(':id', $idVenda, PDO::PARAM_INT);
        $stmt->execute();

        echo "Venda atualizada com sucesso!";
    }
} else {
    die("ID da venda não fornecido.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Venda</title>
</head>
<body>
    <h1>Editar Venda</h1>
    <form method="POST">
        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" value="<?= $venda['quantidade'] ?>" required>
        
        <label for="forma_pagamento">Forma de Pagamento:</label>
        <select name="forma_pagamento" required>
            <option value="debito" <?= $venda['forma_pagamento'] == 'debito' ? 'selected' : '' ?>>Débito</option>
            <option value="credito" <?= $venda['forma_pagamento'] == 'credito' ? 'selected' : '' ?>>Crédito</option>
            <option value="pix" <?= $venda['forma_pagamento'] == 'pix' ? 'selected' : '' ?>>Pix</option>
            <option value="dinheiro" <?= $venda['forma_pagamento'] == 'dinheiro' ? 'selected' : '' ?>>Dinheiro</option>
        </select>

        <button type="submit">Atualizar</button>
    </form>
</body>
</html>
