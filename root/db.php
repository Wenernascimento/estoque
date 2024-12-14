<?php
$host = 'localhost'; // ou o seu host de banco de dados
$db = 'estoque'; // nome do seu banco de dados
$user = 'root'; // usuário do banco
$pass = ''; // senha do banco

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>
