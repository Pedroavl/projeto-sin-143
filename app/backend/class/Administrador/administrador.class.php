<?php
/**
 *  Classe Administrador
 *  Criação, Listagem, Atualização e Remoção
 */ 

class Administrador {
    private $conn;
    private $table_name = "Administrador";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read_administradores() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function create_administrador($data) {
        // Vê se o id_usuario existe na tabela de Usuario
        if(!$this->id_usuario_existe($data['id_usuario'])) {
            return false; // Usuário não existe
        }

        // Checa se o id_usuario já existe na tabela Administrador
        if ($this->id_administrador_existe($data['id_usuario'])) {
            return false; // Administrador existe
        }

        $query = "INSERT INTO " . $this->table_name . " (id_usuario) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $data['id_usuario']);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update_administrador($data) {
        // Vê se o id_usuario existe na tabela de Usuario
        if(!$this->id_usuario_existe($data['id_usuario'])) {
            return false; // Usuário não existe
        }

        // Checa se o id_usuario já existe na tabela Administrador
        if ($this->id_administrador_existe($data['id_usuario'])) {
            return false; // Administrador existe
        }

        $query = "UPDATE " . $this->table_name . " SET id_usuario = ? WHERE id_administrador = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $data['id_usuario'], $data['id_administrador']);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_administrador($id_administrador) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_administrador = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_administrador);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_administrador_by_user_id($id_usuario) {
        $query = "DELETE " . $this->table_name . " FROM " . $this->table_name . " JOIN Usuario AS U ON U.id_usuario = " . $this->table_name . ".id_usuario WHERE U.id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function get_administrador_by_user($id_usuario) {
        $query = "SELECT id_administrador FROM " . $this->table_name . " JOIN Usuario AS U ON U.id_usuario = " . $this->table_name . ".id_usuario WHERE U.id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            return $res->fetch_assoc();
        } else {
            return null;
        }
    }

    // Executa uma query para verificar se o id_usuario já existe antes de inserir
    private function id_usuario_existe($id_usuario) {
        $query = "SELECT id_usuario FROM Usuario WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

    // Verificar se o id_usuario já existe na tabela Administrador
    private function id_administrador_existe($id_usuario) {
        $query = "SELECT id_usuario FROM " . $this->table_name . " WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }
}