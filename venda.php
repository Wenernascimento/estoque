<?php
// Conexão com o banco de dados
try {
    $pdo = new PDO('mysql:host=localhost;dbname=estoque', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitização e validação das entradas
    $idProduto = filter_input(INPUT_POST, 'produto_id', FILTER_VALIDATE_INT);
    $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);

    // Usando FILTER_SANITIZE_FULL_SPECIAL_CHARS para evitar ataques de injeção de XSS
    $formaPagamento = filter_input(INPUT_POST, 'forma_pagamento', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //$formaPagamento = filter_input(INPUT_POST, 'forma_pagamento');


    // Validação do valor pago, caso o pagamento seja em dinheiro
    $valorPago = filter_input(INPUT_POST, 'valor_pago', FILTER_VALIDATE_FLOAT);

    // Verifica se a quantidade, ID e forma de pagamento são válidos
    if (!$quantidade || !$idProduto || !$formaPagamento) {
        echo "<p style='color: red;'>Erro: Dados inválidos.</p>";
        exit;
    }

    try {
        // Busca o produto para pegar o preço e o estoque
        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
        $stmt->bindParam(':id', $idProduto, PDO::PARAM_INT);
        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o produto existe e se há estoque suficiente
        if ($produto && $produto['quantidade'] >= $quantidade) {
            // Calcula o total da venda
            $total = $produto['preco'] * $quantidade;

            // Se a forma de pagamento for dinheiro, calcula o troco
            if ($formaPagamento == 'dinheiro') {
                if ($valorPago < $total) {
                    echo "<p style='color: red;'>Erro: Valor pago é insuficiente para o total da venda.</p>";
                    exit;
                } else {
                    $troco = $valorPago - $total;
                    echo "<p><strong>Troco: R$ " . number_format($troco, 2, ',', '.') . "</strong></p>";
                }
            }

            // Inicia transação
            $pdo->beginTransaction();

            // Registra a venda
            $stmt = $pdo->prepare("INSERT INTO vendas (id_produto, quantidade, total, data_venda, forma_pagamento) 
                                   VALUES (:id_produto, :quantidade, :total, NOW(), :forma_pagamento)");
            $stmt->bindParam(':id_produto', $idProduto, PDO::PARAM_INT);
            $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
            $stmt->bindParam(':total', $total, PDO::PARAM_STR);
            $stmt->bindParam(':forma_pagamento', $formaPagamento, PDO::PARAM_STR);
            $stmt->execute();

            // Atualiza o estoque
            $novoEstoque = $produto['quantidade'] - $quantidade;
            $stmt = $pdo->prepare("UPDATE produtos SET quantidade = :quantidade WHERE id = :id");
            $stmt->bindParam(':quantidade', $novoEstoque, PDO::PARAM_INT);
            $stmt->bindParam(':id', $idProduto, PDO::PARAM_INT);
            $stmt->execute();

            // Commit
            $pdo->commit();

            echo "<p style='color: green;'><strong>✔</strong> Venda registrada com sucesso!</p>";
        } else {
            echo "<p style='color: red;'><strong>✘</strong> Erro: Produto não encontrado ou estoque insuficiente.</p>";
        }
    } catch (Exception $e) {
        // Rollback em caso de erro
        $pdo->rollBack();
        echo "<p style='color: red;'>Erro: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-image: url('mercado1.png');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            color: #444;
        }

        h1 {
            color: #fff;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        form {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            font-weight: bold;
            font-size: 14px;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        select, input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        select {
            font-family: 'Georgia', serif;
            font-size: 16px;
            font-weight: bold;
            color: #2F4F4F;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
            font-size: 14px;
        }

        @media (max-width: 600px) {
            form {
                width: 90%;
            }

            h1 {
                font-size: 1.5em;
            }
        }
    </style>
</head>
<body>
    <h1>Registrar Venda</h1>
    <form method="POST">
        <label for="produto_id">Produto:</label>
        <select name="produto_id" required>
            <option value="">Selecione um produto</option>
            <?php
            // Busca todos os produtos para exibir no formulário
            $stmt = $pdo->query("SELECT * FROM produtos");
            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($produtos as $produto) {
                echo "<option value='{$produto['id']}' data-estoque='{$produto['quantidade']}' data-preco='{$produto['preco']}'>{$produto['nome']} - R$ {$produto['preco']}</option>";
            }
            ?>
        </select>

        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" id="quantidade" min="1" required>

        <!-- Novo campo para selecionar a forma de pagamento -->
        <label for="forma_pagamento">Forma de Pagamento:</label>
        <select name="forma_pagamento" id="forma_pagamento" required>
            <option value="">Selecione a forma de pagamento</option>
            <option value="debito">Débito</option>
            <option value="credito">Crédito</option>
            <option value="pix">Pix</option>
            <option value="dinheiro">Dinheiro</option>
        </select>

        <!-- Campo para valor pago (só aparece se o pagamento for em dinheiro) -->
        <div id="valor_pago_container" style="display: none;">
            <label for="valor_pago">Valor Pago:</label>
            <input type="number" name="valor_pago" id="valor_pago" step="0.01" min="0" placeholder="Digite o valor pago">
        </div>

        <button type="submit">Registrar Venda</button>
    </form>

    <script>
        // Exibe o campo para o valor pago quando a forma de pagamento for "dinheiro"
        document.getElementById('forma_pagamento').addEventListener('change', function() {
            var valorPagoContainer = document.getElementById('valor_pago_container');
            if (this.value === 'dinheiro') {
                valorPagoContainer.style.display = 'block';
            } else {
                valorPagoContainer.style.display = 'none';
            }
        });
    </script>

    <p style="text-align: center;">
        <a href="index.php" style="background-color: #FF6347; padding: 10px 20px; border-radius: 5px; color: white; font-weight: bold; text-decoration: none;">Voltar para Início</a>
    </p>
</body>
</html>
