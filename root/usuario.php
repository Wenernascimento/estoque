<?php
require_once 'db.php';

class Usuario {

    private $conn;

    // Construtor da classe recebe a conexão do banco de dados
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Verificar se o usuário é administrador
    public function isAdmin($userId) {
        $sql = "SELECT role FROM usuarios WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $userId]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuario['role'] === 'admin'; // Assumindo que o campo "role" define o tipo de usuário
    }

    // Criar um novo usuário
    public function criar($username, $email, $senha) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT); // Criptografa a senha
        $sql = "INSERT INTO usuarios (username, email, senha, role) VALUES (:username, :email, :senha, 'user')";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['username' => $username, 'email' => $email, 'senha' => $senhaHash]);
    }

    // Obter todos os usuários
    public function obterTodos() {
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obter um usuário pelo ID
    public function obterPorId($id) {
        $sql = "SELECT * FROM usuarios WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualizar um usuário
    public function atualizar($id, $username, $email, $senha) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT); // Criptografa a senha
        $sql = "UPDATE usuarios SET username = :username, email = :email, senha = :senha WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['username' => $username, 'email' => $email, 'senha' => $senhaHash, 'id' => $id]);
    }

    // Deletar um usuário
    public function deletar($id) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
?>
