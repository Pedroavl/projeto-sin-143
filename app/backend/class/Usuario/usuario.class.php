<?php
/**
 *  Classe Usuários
 *  Criação, Listagem, Atualização e Remoção
 */ 

class Usuario {
    private $conn;
    private $table_name = "Usuario";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read_user() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function create_user($data) {
        $user_pass = $data['senha'];

        // Criptografando a senha
        $user_pass_hash = password_hash($user_pass, PASSWORD_DEFAULT);

        $query = "INSERT INTO " . $this->table_name . " (email, senha, nome) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $data['email'], $user_pass_hash, $data['nome']);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update_user($data) {
        $user_pass = $data['senha'];

        // Criptografando a senha
        $user_pass_hash = password_hash($user_pass, PASSWORD_DEFAULT);

        $query = "UPDATE " . $this->table_name . " SET email = ?, senha = ?, nome = ? WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssi", $data['email'], $user_pass_hash, $data['nome'], $data['id_usuario']);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_user($id_usuario) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}