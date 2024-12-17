<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre o Sistema de Gestão de Vendas</title>
    <style>
        /* Reset de margin e padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Estilos gerais */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to bottom right, #4e54c8, #8f94fb);
            color: #fff;
            line-height: 1.6;
        }

        h1, h2, h3 {
            color: #fff;
            text-align: center;
        }

        p {
            font-size: 16px;
            color: #eee;
        }

        /* Container geral */
        .container {
            width: 90%;
            margin: 30px auto;
        }

        /* Estilo para o título principal */
        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        /* Cartões de funcionalidades */
        .features {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            margin-top: 40px;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            width: 300px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .feature-card:hover {
            transform: scale(1.05);
        }

        .feature-card h3 {
            margin-bottom: 15px;
        }

        .feature-card p {
            font-size: 14px;
            line-height: 1.4;
        }

        .feature-card i {
            font-size: 3rem;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        /* Estilos para as seções de texto */
        .section-title {
            font-size: 2rem;
            margin-bottom: 20px;
            text-align: center;
            color: #ffffff;
        }

        .section-content {
            margin-bottom: 40px;
            font-size: 1.1rem;
            line-height: 1.7;
        }

        .section-content ul {
            list-style-type: none;
            padding: 0;
        }

        .section-content ul li {
            margin: 10px 0;
        }

        .cta-button {
            display: block;
            margin: 30px auto;
            padding: 15px 30px;
            background-color: #4CAF50;
            color: white;
            font-size: 1.2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #45a049;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .features {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>

    <!-- Container principal -->
    <div class="container">

        <!-- Título principal -->
        <h1>Sobre o Sistema de Gestão de Vendas</h1>

        <!-- Descrição breve -->
        <p class="section-content">
            Bem-vindo ao <strong>Sistema de Gestão de Vendas</strong>! Este aplicativo foi desenvolvido para facilitar o controle de produtos, registros de vendas e gerenciamento financeiro de forma simples e eficiente. Abaixo, explicamos como usar cada uma das principais funcionalidades do sistema, e o que cada uma delas faz.
        </p>

        <!-- Seção de funcionalidades -->
        <h2 class="section-title">Funcionalidades</h2>

        <div class="features">

            <!-- Funcionalidade 1 -->
            <div class="feature-card">
                <i class="fas fa-user"></i>
                <h3>Cadastro de Usuários</h3>
                <p>Crie e gerencie usuários com permissões específicas. Apenas administradores podem gerenciar outros usuários.</p>
            </div>

            <!-- Funcionalidade 2 -->
            <div class="feature-card">
                <i class="fas fa-box"></i>
                <h3>Cadastro de Produtos</h3>
                <p>Adicione, edite e exclua produtos do seu inventário com detalhes como preço, quantidade e validade.</p>
            </div>

            <!-- Funcionalidade 3 -->
            <div class="feature-card">
                <i class="fas fa-calendar-alt"></i>
                <h3>Controle de Validade</h3>
                <p>Controle a data de validade dos produtos para evitar a venda de itens vencidos.</p>
            </div>

            <!-- Funcionalidade 4 -->
            <div class="feature-card">
                <i class="fas fa-credit-card"></i>
                <h3>Registro de Vendas</h3>
                <p>Registre vendas por diferentes métodos de pagamento como crédito, débito, Pix e dinheiro.</p>
            </div>

        </div>

        <!-- Descrição detalhada -->
        <h2 class="section-title">Como Usar o Sistema</h2>
        <div class="section-content">
            <ul>
                <li><strong>1. Login</strong>: Acesse o sistema com seu nome de usuário e senha. Se não tiver uma conta, registre-se primeiro.</li>
                <li><strong>2. Cadastro de Produtos</strong>: Vá para a seção "Cadastro de Produtos" e adicione os itens ao inventário.</li>
                <li><strong>3. Realização de Vendas</strong>: Selecione os produtos, escolha o método de pagamento e registre a venda.</li>
                <li><strong>4. Visualizando Gráficos</strong>: Acompanhe as vendas diárias e mensais nos gráficos de desempenho.</li>
                <li><strong>5. Excluir ou Editar Produtos/Vendas</strong>: Caso necessário, edite ou exclua produtos e vendas com facilidade.</li>
            </ul>
        </div>

        <!-- Call to Action Button -->
        <button class="cta-button" onclick="window.location.href = 'index.php';">Comece Agora</button>

    </div>

    <!-- Inclusão de Font Awesome para ícones -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>
</html>
