<?php
// Este bloco PHP pode ser usado para configurações dinâmicas, se necessário.
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Mim - Wener Felice</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            flex-direction: column;
        }

        .container {
            padding: 20px;
            border-radius: 10px;
            background: rgba(0, 0, 0, 0.5);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 600px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .clock {
            font-size: 2rem;
            font-weight: bold;
            margin-top: 30px;
            color: #ffdd57;
        }

        .footer {
            margin-top: 20px;
            color: white;
        }

        .footer img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .footer a {
            display: block;
            color: #ffdd57;
            text-decoration: none;
            font-size: 1.2rem;
            margin-top: 10px;
        }

        .footer a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <h1>Olá, meu nome é Wener Felice</h1>
            <p>Sou programador júnior especializado em PHP, HTML e CSS. Crio sistemas online para pequenos comércios, com foco em soluções no formato SaaS.</p>
            <p>Atualmente, moro na cidade de São Paulo e estou sempre em busca de novos desafios para aprimorar minhas habilidades e ajudar empresas a crescerem com soluções digitais eficientes.</p>
            <div class="clock" id="clock"></div>
        </div>
    </div>

    <div class="footer">
        <!-- Aqui você deve substituir "sua_foto.jpg" pelo caminho correto da sua imagem -->
        <img src="perfil.jpeg" alt="Wener Felice">
        <p>Email: <a href="wenerfelice@gmail.com">wenerfelice@gmail.com</a></p>
        <p>Instagram: <a href="https://www.instagram.com/wenerfelice/" target="_blank">wenerfelice</a></p>
    </div>

    <script>
        function updateClock() {
            const clockElement = document.getElementById('clock');
            const now = new Date();
            let hours = now.getHours().toString().padStart(2, '0');
            let minutes = now.getMinutes().toString().padStart(2, '0');
            let seconds = now.getSeconds().toString().padStart(2, '0');

            clockElement.textContent = `${hours}:${minutes}:${seconds}`;
        }

        // Atualiza o relógio a cada segundo
        setInterval(updateClock, 1000);

        // Inicializa o relógio
        updateClock();
    </script>
</body>
</html>
